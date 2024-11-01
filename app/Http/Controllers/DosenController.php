<?php
// app/Http/Controllers/DosenController.php

namespace App\Http\Controllers;

use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Dosen;
use App\Models\DosenGoogleToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DosenController extends Controller
{
    protected $client;
    protected $service;

    public function __construct()
    {   
        $this->client = new Google_Client();
        
        try {
            // Gunakan URL callback yang hard-coded untuk memastikan konsistensi
            $callbackUrl = url('/dosen/google/callback'); // Tanpa prefix 'dosen'
            Log::info('Setting callback URL to: ' . $callbackUrl);
            
            $credentialsPath = storage_path('app/google-calendar/credentials.json');
            if (!file_exists($credentialsPath)) {
                throw new \Exception('Google Calendar credentials file not found');
            }
            
            $this->client->setAuthConfig($credentialsPath);
            $this->client->setApplicationName('Sistem Bimbingan');
            $this->client->setAccessType('offline');
            $this->client->setPrompt('consent');
            $this->client->setIncludeGrantedScopes(true);
            $this->client->setRedirectUri($callbackUrl);
            
            $this->client->addScope(Google_Service_Calendar::CALENDAR);
            $this->client->addScope('email');
            $this->client->addScope('profile');
            
        } catch (\Exception $e) {
            Log::error('Error in DosenController constructor: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Menampilkan halaman masukkan jadwal
     */
    public function index()
    {
        $dosen = Auth::guard('dosen')->user();
        $isConnected = $dosen->googleToken && !$dosen->googleToken->isExpired();
        
        return view('bimbingan.dosen.masukkanjadwal', [
            'isConnected' => $isConnected,
            'email' => $dosen->email
        ]);
    }

    /**
     * Menghubungkan dengan Google Calendar
     */

    public function connect()
    {
        $dosen = Auth::guard('dosen')->user();
        
        // Set state untuk validasi callback, tidak perlu menyertakan email
        $state = base64_encode(json_encode([
            'nip' => $dosen->nip,
            'timestamp' => time()
        ]));
        
        $this->client->setState($state);
        
        // Set login hint dengan email dosen
        $this->client->setLoginHint($dosen->email);
        
        $authUrl = $this->client->createAuthUrl();
        return redirect($authUrl);
    }

    /**
     * Handle callback dari Google OAuth
     */
    public function callback(Request $request)
    {
        if (!$request->has('code')) {
            return redirect()->route('dosen.jadwal.index')
                ->with('error', 'Gagal terhubung ke Google Calendar.');
        }

        try {
            // Validasi state
            $state = json_decode(base64_decode($request->state), true);
            $dosen = Auth::guard('dosen')->user();
            
            if (!$state || $state['nip'] !== $dosen->nip || 
                (time() - $state['timestamp']) > 3600) {
                throw new \Exception('Invalid state parameter');
            }

            $token = $this->client->fetchAccessTokenWithAuthCode($request->code);
            
            // Validasi token untuk memastikan email yang sama
            $this->client->setAccessToken($token);
            $oauth2 = new \Google_Service_Oauth2($this->client);
            $userInfo = $oauth2->userinfo->get();
            
            // Mengambil email dari model Dosen
            if ($userInfo->email !== $dosen->email) {
                throw new \Exception(sprintf(
                    'Email tidak sesuai. Gunakan akun Google dengan email yang terdaftar di sistem (%s)',
                    $dosen->email
                ));
            }

            // Simpan atau update token
            DosenGoogleToken::updateOrCreate(
                ['nip' => $dosen->nip],
                [
                    'access_token' => $token['access_token'],
                    'refresh_token' => $token['refresh_token'] ?? null,
                    'expires_in' => $token['expires_in'],
                    'created' => now(),
                ]
            );

            return redirect()->route('dosen.jadwal.index')
                ->with('success', 'Google Calendar berhasil terhubung!');
                
        } catch (\Exception $e) {
            return redirect()->route('dosen.jadwal.index')
                ->with('error', 'Gagal terhubung ke Google Calendar: ' . $e->getMessage());
        }
    }

    /**
     * Mengambil events dari Google Calendar
     */
    public function getEvents()
    {
        try {
            if (!$this->checkAndRefreshToken()) {
                return response()->json(['error' => 'Not authenticated'], 401);
            }

            $this->service = new Google_Service_Calendar($this->client);
            $dosen = Auth::guard('dosen')->user();
            
            $calendarId = 'primary';
            $optParams = [
                'maxResults' => 100,
                'orderBy' => 'startTime',
                'singleEvents' => true,
                'timeMin' => Carbon::now()->startOfMonth()->toRfc3339String(),
                'timeMax' => Carbon::now()->endOfMonth()->toRfc3339String(),
            ];

            $results = $this->service->events->listEvents($calendarId, $optParams);
            $events = [];

            foreach ($results->getItems() as $event) {
                $events[] = [
                    'id' => $event->id,
                    'title' => $event->getSummary(),
                    'start' => $event->start->dateTime,
                    'end' => $event->end->dateTime,
                    'description' => $event->getDescription(),
                ];
            }

            return response()->json($events);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Menyimpan jadwal baru
     */
    public function store(Request $request)
    {
        try {
            if (!$this->checkAndRefreshToken()) {
                return response()->json(['error' => 'Not authenticated'], 401);
            }

            $dosen = Auth::guard('dosen')->user();

            $request->validate([
                'kegiatan' => 'required|string|in:krs,kp,mbkm,skripsi',
                'start' => 'required|date',
                'end' => 'required|date|after:start',
                'description' => 'nullable|string',
            ]);

            $this->service = new Google_Service_Calendar($this->client);

            $event = new Google_Service_Calendar_Event([
                'summary' => 'Available: Bimbingan ' . strtoupper($request->kegiatan),
                'description' => ($request->description ?? '') . "\n\nStatus: Available" .
                               "\nDosen: " . $dosen->nama .
                               "\nNIP: " . $dosen->nip .
                               "\nEmail: " . $dosen->email,
                'start' => [
                    'dateTime' => Carbon::parse($request->start)->toRfc3339String(),
                    'timeZone' => 'Asia/Jakarta',
                ],
                'end' => [
                    'dateTime' => Carbon::parse($request->end)->toRfc3339String(),
                    'timeZone' => 'Asia/Jakarta',
                ],
                'reminders' => [
                    'useDefault' => false,
                    'overrides' => [
                        ['method' => 'email', 'minutes' => 24 * 60],
                        ['method' => 'popup', 'minutes' => 30],
                    ],
                ],
            ]);

            $event = $this->service->events->insert('primary', $event);

            return response()->json([
                'success' => true,
                'message' => 'Jadwal berhasil ditambahkan!',
                'event' => $event,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan jadwal: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Menghapus jadwal
     */
    public function destroy($eventId)
    {
        try {
            if (!$this->checkAndRefreshToken()) {
                return response()->json(['error' => 'Not authenticated'], 401);
            }

            $this->service = new Google_Service_Calendar($this->client);
            $this->service->events->delete('primary', $eventId);

            return response()->json([
                'success' => true,
                'message' => 'Jadwal berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus jadwal: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check dan refresh token jika perlu
     */
    private function checkAndRefreshToken()
    {
        $dosen = Auth::guard('dosen')->user();
        $tokenModel = $dosen->googleToken;

        if (!$tokenModel) {
            return false;
        }

        if ($tokenModel->isExpired()) {
            try {
                $this->client->setAccessToken([
                    'access_token' => $tokenModel->access_token,
                    'refresh_token' => $tokenModel->refresh_token,
                    'expires_in' => $tokenModel->expires_in,
                    'created' => $tokenModel->created->timestamp,
                ]);

                if ($this->client->isAccessTokenExpired() && $tokenModel->refresh_token) {
                    $newToken = $this->client->fetchAccessTokenWithRefreshToken($tokenModel->refresh_token);
                    
                    $tokenModel->update([
                        'access_token' => $newToken['access_token'],
                        'refresh_token' => $newToken['refresh_token'] ?? $tokenModel->refresh_token,
                        'expires_in' => $newToken['expires_in'],
                        'created' => now(),
                    ]);

                    $this->client->setAccessToken($newToken);
                } else {
                    return false;
                }
            } catch (\Exception $e) {
                return false;
            }
        } else {
            $this->client->setAccessToken([
                'access_token' => $tokenModel->access_token,
                'refresh_token' => $tokenModel->refresh_token,
                'expires_in' => $tokenModel->expires_in,
                'created' => $tokenModel->created->timestamp,
            ]);
        }

        return true;
    }
}