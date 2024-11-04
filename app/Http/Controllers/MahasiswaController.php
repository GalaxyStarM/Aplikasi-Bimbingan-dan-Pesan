<?php
// app/Http/Controllers/MahasiswaJadwalController.php

namespace App\Http\Controllers;

use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Booking;
use Illuminate\Support\Facades\File;

class MahasiswaController extends Controller
{
    protected $client;
    protected $service;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:mahasiswa');
        
        $this->client = new Google_Client();
        $this->client->setClientId(config('google-calendar.client_id'));
        $this->client->setClientSecret(config('google-calendar.client_secret'));
        $this->client->setRedirectUri(config('google-calendar.redirect_uri'));
        $this->client->addScope(Google_Service_Calendar::CALENDAR_EVENTS);
    }

    /**
     * Mengambil data dosen dari JSON
     */
    private function getDosenFromJson()
    {
        $jsonPath = public_path('dosen.json');
        
        if (!File::exists($jsonPath)) {
            throw new \Exception('File dosen.json tidak ditemukan');
        }

        $jsonContent = File::get($jsonPath);
        $dosenData = json_decode($jsonContent, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Error membaca file dosen.json: ' . json_last_error_msg());
        }

        return $dosenData['dosen'] ?? [];
    }

    /**
     * Menampilkan form pilih jadwal
     */
    public function index()
    {
        try {
            $dosenList = $this->getDosenFromJson();
            return view('bimbingan.pilih-jadwal', [
                'dosenList' => $dosenList
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memuat daftar dosen: ' . $e->getMessage());
        }
    }

    /**
     * Mengambil jadwal tersedia berdasarkan dosen dan tanggal
     */
    public function getAvailableSlots(Request $request)
    {
        try {
            $request->validate([
                'dosen_id' => 'required',
                'tanggal' => 'required|date_format:d/m/Y'
            ]);

            // Validasi dosen dari JSON
            $dosenList = $this->getDosenFromJson();
            if (!in_array($request->dosen_id, $dosenList)) {
                return response()->json(['error' => 'Dosen tidak ditemukan'], 404);
            }

            if (!$this->checkAndRefreshToken()) {
                return response()->json(['error' => 'Tidak dapat mengakses jadwal'], 401);
            }

            $this->service = new Google_Service_Calendar($this->client);
            
            // Convert tanggal ke format yang sesuai
            $selectedDate = Carbon::createFromFormat('d/m/Y', $request->tanggal);
            
            $optParams = [
                'timeMin' => $selectedDate->startOfDay()->toRfc3339String(),
                'timeMax' => $selectedDate->endOfDay()->toRfc3339String(),
                'singleEvents' => true,
                'orderBy' => 'startTime',
            ];

            // Gunakan calendar ID default karena tidak ada di JSON
            $calendarId = 'primary';
            $results = $this->service->events->listEvents($calendarId, $optParams);
            
            $availableSlots = [];
            foreach ($results->getItems() as $event) {
                // Hanya ambil slot yang available (belum di-booking)
                if (str_contains($event->getSummary(), 'Available:')) {
                    $availableSlots[] = [
                        'id' => $event->id,
                        'waktu' => Carbon::parse($event->start->dateTime)->format('H:i') . ' - ' . 
                                 Carbon::parse($event->end->dateTime)->format('H:i'),
                        'tersedia' => true
                    ];
                }
            }

            return response()->json($availableSlots);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Menyimpan booking jadwal
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'dosen' => 'required|string',
                'jenis_bimbingan' => 'required|string|in:krs,kp,mbkm,skripsi',
                'tanggal' => 'required|date_format:d/m/Y',
                'jadwal' => 'required|string',
                'deskripsi' => 'required|string'
            ]);

            // Validasi dosen dari JSON
            $dosenList = $this->getDosenFromJson();
            if (!in_array($request->dosen, $dosenList)) {
                return back()->with('error', 'Dosen tidak ditemukan')->withInput();
            }

            if (!$this->checkAndRefreshToken()) {
                return back()->with('error', 'Tidak dapat mengakses jadwal')->withInput();
            }

            $this->service = new Google_Service_Calendar($this->client);

            // Parse waktu
            $times = explode(' - ', $request->jadwal);
            $tanggal = Carbon::createFromFormat('d/m/Y', $request->tanggal);
            $startTime = Carbon::createFromFormat('d/m/Y H:i', $request->tanggal . ' ' . $times[0]);
            $endTime = Carbon::createFromFormat('d/m/Y H:i', $request->tanggal . ' ' . $times[1]);

            // Update event di Google Calendar
            $event = new Google_Service_Calendar_Event([
                'summary' => '[BOOKED] Bimbingan ' . strtoupper($request->jenis_bimbingan),
                'description' => "Deskripsi: " . $request->deskripsi . "\n\n" .
                               "Mahasiswa: " . auth()->user()->name . "\n" .
                               "NIM: " . auth()->user()->nim . "\n" .
                               "Dosen: " . $request->dosen,
                'start' => [
                    'dateTime' => $startTime->toRfc3339String(),
                    'timeZone' => 'Asia/Jakarta',
                ],
                'end' => [
                    'dateTime' => $endTime->toRfc3339String(),
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

            $calendarId = 'primary';
            $event = $this->service->events->insert($calendarId, $event);

            // Simpan ke database
            Booking::create([
                'mahasiswa_id' => auth()->id(),
                'dosen_name' => $request->dosen, // Simpan nama dosen sebagai string
                'jenis_bimbingan' => $request->jenis_bimbingan,
                'tanggal' => $tanggal,
                'jam_mulai' => $startTime,
                'jam_selesai' => $endTime,
                'deskripsi' => $request->deskripsi,
                'status' => 'booked',
                'event_id' => $event->id
            ]);

            return redirect()->route('dashboard')
                           ->with('success', 'Jadwal bimbingan berhasil dibooking!');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membooking jadwal: ' . $e->getMessage())
                        ->withInput();
        }
    }

    private function checkAndRefreshToken()
    {
        if (!session('google_token')) {
            return false;
        }

        $this->client->setAccessToken(session('google_token'));
        
        if ($this->client->isAccessTokenExpired()) {
            if ($this->client->getRefreshToken()) {
                $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
                session(['google_token' => $this->client->getAccessToken()]);
                return true;
            }
            return false;
        }

        return true;
    }
}