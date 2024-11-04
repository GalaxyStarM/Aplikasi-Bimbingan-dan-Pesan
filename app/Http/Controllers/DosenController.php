<?php
// app/Http/Controllers/DosenController.php

namespace App\Http\Controllers;

use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\JadwalBimbingan;
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
            
            $calendarId = 'primary'; // Menggunakan kalender utama pengguna
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
                // Skip events yang tidak memiliki waktu mulai/selesai (all day events)
                if (!$event->start->dateTime || !$event->end->dateTime) {
                    continue;
                }

                // Format event untuk FullCalendar
                $eventData = [
                    'id' => $event->id,
                    'title' => $event->getSummary() ?: 'No Title',
                    'start' => Carbon::parse($event->start->dateTime)->toIso8601String(),
                    'end' => Carbon::parse($event->end->dateTime)->toIso8601String(),
                    'description' => $event->getDescription(),
                    'editable' => false, // Events dari Google Calendar tidak bisa diedit langsung
                ];

                // Cek apakah ini event bimbingan
                if (strpos(strtolower($event->getSummary()), 'bimbingan') !== false) {
                    $eventData['color'] = '#4285f4'; // Warna untuk event bimbingan
                    $eventData['editable'] = true; // Event bimbingan bisa diedit
                } else {
                    $eventData['color'] = '#9e9e9e'; // Warna default untuk event lain
                    $eventData['className'] = 'external-event'; // Class khusus untuk event external
                }

                // Tambahkan status jika ada di description
                if ($event->getDescription()) {
                    if (preg_match('/Status:\s*(.*?)(?:\n|$)/', $event->getDescription(), $matches)) {
                        $eventData['status'] = trim($matches[1]);
                    }
                }

                $events[] = $eventData;
            }

            return response()->json($events);
        } catch (\Exception $e) {
            Log::error('Error getting events: ' . $e->getMessage());
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

            // Log request data
            Log::info('Incoming request data:', $request->all());

            // Validate request
            $validated = $request->validate([
                'start' => 'required|date',
                'end' => 'required|date|after:start',
                'description' => 'nullable|string',
                'capacity' => 'required|integer|min:1|max:10'
            ]);

            // Parse dates with explicit timezone
            $start = Carbon::parse($request->start)->setTimezone('Asia/Jakarta');
            $end = Carbon::parse($request->end)->setTimezone('Asia/Jakarta');

            // Log parsed dates
            Log::info('Parsed dates:', [
                'start' => $start->toDateTimeString(),
                'end' => $end->toDateTimeString(),
            ]);

            // Validate work hours (08:00 - 18:00)
            $startHour = $start->format('H');
            if ($startHour < 8 || $startHour >= 18) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jadwal harus dalam jam kerja (08:00 - 18:00)'
                ], 422);
            }

            // Calculate duration
            $durasi = $end->diffInMinutes($start, false);
            Log::info('Duration in minutes: ' . $durasi);

            if (abs($durasi) < 30) {
                return response()->json([
                    'success' => false,
                    'message' => 'Durasi minimum bimbingan adalah 30 menit'
                ], 422);
            }

            $dosen = Auth::guard('dosen')->user();
            $this->service = new Google_Service_Calendar($this->client);

            $description = "Status: Tersedia\n" .
                      "Dosen: {$dosen->nama}\n" .
                      "NIP: {$dosen->nip}\n" .
                      "Email: {$dosen->email}\n" .
                      "Kapasitas: {$request->capacity} Mahasiswa\n\n" .
                      ($request->description ? "Catatan: {$request->description}" : "");

            $event = new Google_Service_Calendar_Event([
                'summary' => 'Jadwal Bimbingan',
                'description' => $description,
                'start' => [
                    'dateTime' => $start->toRfc3339String(),
                    'timeZone' => 'Asia/Jakarta',
                ],
                'end' => [
                    'dateTime' => $end->toRfc3339String(),
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

            $createdEvent = $this->service->events->insert('primary', $event);
            
            $jadwal = JadwalBimbingan::create([
                'event_id' => $createdEvent->id,
                'nip' => $dosen->nip,
                'waktu_mulai' => $start,
                'waktu_selesai' => $end,
                'catatan' => $request->description,
                'status' => 'tersedia',
                'kapasitas' => $request->capacity,
                'sisa_kapasitas' => $request->capacity
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Jadwal berhasil ditambahkan!',
                'data' => [
                    'id' => $event->id,
                    'title' => 'Jadwal Bimbingan',
                    'start' => $start->toIso8601String(),
                    'end' => $end->toIso8601String(),
                    'description' => $request->description,
                    'status' => 'Tersedia',
                    'capacity' => $request->capacity
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error adding event: ' . $e->getMessage());
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

            // Delete from Google Calendar
            $this->service = new Google_Service_Calendar($this->client);
            $this->service->events->delete('primary', $eventId);

            // Delete from database
            $jadwal = JadwalBimbingan::where('event_id', $eventId)->first();
            if ($jadwal) {
                $jadwal->delete();
            }

            return response()->json([
                'success' => true,
                'message' => 'Jadwal berhasil dihapus dari sistem dan Google Calendar!'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting schedule: ' . $e->getMessage());
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