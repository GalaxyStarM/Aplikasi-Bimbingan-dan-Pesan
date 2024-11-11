<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\UsulanBimbingan;

class DosenController extends Controller
{   
    protected $googleCalendarController;

    public function __construct(GoogleCalendarController $googleCalendarController) 
    {
        $this->googleCalendarController = $googleCalendarController;
    }
    public function index(Request $request)
    {
        try {
            $activeTab = $request->query('tab', 'usulan');
            $perPage = $request->query('per_page', 10);
            $nip = Auth::user()->nip;

            // Default values
            $usulan = collect();
            $jadwal = collect();
            $riwayat = collect();

            // Load data based on active tab
            switch($activeTab) {
                case 'usulan':
                    $usulan = DB::table('usulan_bimbingans as ub')
                        ->join('mahasiswas as m', 'ub.nim', '=', 'm.nim')
                        ->join('bimbingankonsultasi.jadwal_bimbingans as jb', function($join) {
                            $join->on('ub.event_id', '=', 'jb.event_id')
                                 ->on('ub.nip', '=', 'jb.nip');
                        })
                        ->where('jb.nip', $nip)
                        ->where('jb.status', 'tersedia')
                        ->where('ub.status', 'USULAN')
                        ->select(
                            'ub.*',
                            'm.nama as mahasiswa_nama',
                            'jb.lokasi as lokasi_default'
                        )
                        ->orderBy('jb.waktu_mulai', 'asc')
                        ->orderBy('ub.created_at', 'desc')
                        ->paginate($perPage);
                    break;

                case 'jadwal':
                    $jadwal = DB::table('usulan_bimbingans as ub')
                        ->where('ub.nip', $nip)
                        ->where('status', 'DISETUJUI')
                        ->select(
                            'ub.*',
                            DB::raw('(SELECT COUNT(*) FROM usulan_bimbingans 
                                    WHERE tanggal = ub.tanggal 
                                    AND waktu_mulai = ub.waktu_mulai 
                                    AND status = "DISETUJUI") as total_bimbingan')
                        )
                        ->orderBy('ub.tanggal', 'desc')
                        ->orderBy('ub.waktu_mulai', 'asc')
                        ->paginate($perPage);
                    break;

                case 'riwayat':
                    $riwayat = DB::table('usulan_bimbingans as ub')
                        ->join('mahasiswas as m', 'ub.nim', '=', 'm.nim')
                        ->where('ub.nip', $nip)
                        ->whereIn('ub.status', ['SELESAI', 'DITOLAK'])
                        ->select('ub.*', 'm.nama as mahasiswa_nama')
                        ->orderBy('ub.tanggal', 'desc')
                        ->orderBy('ub.waktu_mulai', 'desc')
                        ->paginate($perPage);
                    break;
            }

            return view('bimbingan.dosen.persetujuan', compact(
                'activeTab',
                'usulan',
                'jadwal',
                'riwayat'
            ));

        } catch (\Exception $e) {
            Log::error('Error in dosen index: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memuat data');
        }
    }

    public function getDetailBimbingan($id)
    {
        try {
            $usulan = DB::table('usulan_bimbingans as ub')
                ->join('mahasiswas as m', 'ub.nim', '=', 'm.nim')
                ->join('prodi as p', 'm.prodi_id', '=', 'p.id')
                ->join('konsentrasi as k', 'm.konsentrasi_id', '=', 'k.id')
                ->join('dosens as d', 'ub.nip', '=', 'd.nip')
                ->join('bimbingankonsultasi.jadwal_bimbingans as jb', function($join) {
                    $join->on('ub.event_id', '=', 'jb.event_id')
                        ->on('ub.nip', '=', 'jb.nip');
                })
                ->where('ub.id', $id)
                ->select(
                    'ub.*',
                    'm.nama as mahasiswa_nama',
                    'm.nim',
                    'p.nama_prodi',
                    'k.nama_konsentrasi',
                    'd.nama as dosen_nama',
                    'jb.lokasi as lokasi_default'
                )
                ->firstOrFail();

            // Format data
            $tanggal = Carbon::parse($usulan->tanggal)->locale('id')->isoFormat('dddd, D MMMM Y');
            $waktu = Carbon::parse($usulan->waktu_mulai)->format('H:i') . ' - ' . 
                    Carbon::parse($usulan->waktu_selesai)->format('H:i');

            // Sesuaikan warna status
            switch($usulan->status) {
                case 'DISETUJUI':
                    $statusClass = 'bg-success';
                    break;
                case 'DITOLAK':
                    $statusClass = 'bg-danger';
                    break;
                case 'USULAN':
                    $statusClass = 'bg-warning';
                    break;
                default:
                    $statusClass = 'bg-secondary';
            }

            return view('bimbingan.dosen.terimausulanbimbingan', compact(
                'usulan',
                'tanggal',
                'waktu',
                'statusClass'
            ));

        } catch (\Exception $e) {
            Log::error('Error in getDetailUsulan: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memuat detail usulan');
        }
    }

    public function getRiwayatDetail($id)
    {
        try {
            $riwayat = DB::table('usulan_bimbingans as ub')
                ->join('mahasiswas as m', 'ub.nim', '=', 'm.nim')
                ->where('ub.id', $id)
                ->where('ub.status', 'SELESAI')
                ->select('ub.*', 'm.nama as mahasiswa_nama')
                ->firstOrFail();

            $tanggal = Carbon::parse($riwayat->tanggal)->locale('id')->isoFormat('dddd, D MMMM Y');
            $waktuMulai = Carbon::parse($riwayat->waktu_mulai)->format('H:i');
            $waktuSelesai = Carbon::parse($riwayat->waktu_selesai)->format('H:i');

            return view('bimbingan.riwayatdosen', compact(
                'riwayat',
                'tanggal',
                'waktuMulai',
                'waktuSelesai'
            ));

        } catch (\Exception $e) {
            Log::error('Error getting riwayat detail: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat detail riwayat bimbingan');
        }
    }

    public function editUsulan($id)
    {
        try {
            $usulan = DB::table('usulan_bimbingans as ub')
                ->join('mahasiswas as m', 'ub.nim', '=', 'm.nim')
                ->where('ub.id', $id)
                ->where('ub.status', 'DISETUJUI')
                ->select('ub.*', 'm.nama as mahasiswa_nama')
                ->firstOrFail();

            return view('bimbingan.dosen.editusulan', compact('usulan'));

        } catch (\Exception $e) {
            Log::error('Error in editUsulan: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat data usulan untuk diedit');
        }
    }

    public function updateUsulan(Request $request, $id)
    {
        try {
            $request->validate([
                'tanggal' => 'required|date',
                'waktu_mulai' => 'required|date_format:H:i',
                'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
                'lokasi' => 'required|string|max:255'
            ]);

            DB::table('usulan_bimbingans')
                ->where('id', $id)
                ->update([
                    'tanggal' => $request->tanggal,
                    'waktu_mulai' => $request->waktu_mulai,
                    'waktu_selesai' => $request->waktu_selesai,
                    'lokasi' => $request->lokasi,
                    'updated_at' => now()
                ]);

            return redirect()
                ->route('dosen.persetujuanbimbingan', ['tab' => 'usulan'])
                ->with('success', 'Usulan bimbingan berhasil diperbarui');

        } catch (\Exception $e) {
            Log::error('Error in updateUsulan: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui usulan bimbingan');
        }
    }

    public function terima(Request $request, $id)
    {
        try {
            $usulan = UsulanBimbingan::with('mahasiswa')->findOrFail($id);
            
            DB::beginTransaction();
            
            if ($usulan->setujui($request->lokasi)) {
                try {
                    // Debug log untuk memeriksa event_id
                    Log::info('Mencari event dengan ID: ' . $usulan->event_id);
                    
                    // Cari event di calendar dosen
                    $events = $this->googleCalendarController->getEvents();
                    
                    // Debug log untuk melihat response events
                    Log::info('Events response:', ['events' => $events]);
                    
                    if (!$events || !isset($events->original)) {
                        throw new \Exception('Tidak bisa mengambil events dari Google Calendar');
                    }

                    $event = collect($events->original)->first(function ($event) use ($usulan) {
                        return isset($event['id']) && $event['id'] === $usulan->event_id;
                    });
                    
                    if ($event) {
                        // Siapkan data attendee
                        $existingAttendees = $event['attendees'] ?? [];
                        
                        // Debug log untuk attendees
                        Log::info('Existing attendees:', ['attendees' => $existingAttendees]);
                        
                        // Cek apakah email mahasiswa sudah ada
                        $mahasiswaEmail = $usulan->mahasiswa->email;
                        $emailExists = collect($existingAttendees)->contains('email', $mahasiswaEmail);
                        
                        if (!$emailExists) {
                            Log::info('Menambahkan attendee baru:', ['email' => $mahasiswaEmail]);
                            
                            $existingAttendees[] = [
                                'email' => $mahasiswaEmail,
                                'responseStatus' => 'needsAction'
                            ];
                            
                            // Update event dengan attendee baru dan notifikasi
                            $this->googleCalendarController->updateEventAttendees(
                                $usulan->event_id,
                                $existingAttendees,
                                [
                                    'sendUpdates' => 'all',
                                    'reminders' => [
                                        'useDefault' => false,
                                        'overrides' => [
                                            ['method' => 'email', 'minutes' => 24 * 60], // 1 hari sebelum
                                            ['method' => 'popup', 'minutes' => 30]  // 30 menit sebelum
                                        ]
                                    ]
                                ]
                            );

                            Log::info('Berhasil menambahkan attendee dengan notifikasi');
                        } else {
                            Log::info('Email mahasiswa sudah terdaftar sebagai attendee');
                        }

                        DB::commit();
                        return response()->json([
                            'success' => true,
                            'message' => 'Usulan bimbingan berhasil disetujui dan undangan telah dikirim'
                        ]);
                    } else {
                        Log::warning('Event tidak ditemukan di Google Calendar:', [
                            'event_id' => $usulan->event_id,
                            'total_events' => count($events->original)
                        ]);
                    }
                    
                    // Jika sampai di sini, event tidak ditemukan tapi tetap setujui usulan
                    DB::commit();
                    return response()->json([
                        'success' => true,
                        'message' => 'Usulan bimbingan berhasil disetujui (tanpa notifikasi calendar)'
                    ]);
                    
                } catch (\Exception $e) {
                    Log::error('Google Calendar Error Detail:', [
                        'message' => $e->getMessage(),
                        'event_id' => $usulan->event_id,
                        'trace' => $e->getTraceAsString()
                    ]);
                    
                    // Jika gagal menambahkan ke calendar, tetap setujui usulan
                    DB::beginTransaction();
                    $usulan->setujui($request->lokasi);
                    DB::commit();
                    
                    return response()->json([
                        'success' => true,
                        'message' => 'Usulan bimbingan berhasil disetujui (tanpa notifikasi calendar)'
                    ]);
                }
            }

            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyetujui usulan bimbingan'
            ], 500);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in approve consultation:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses usulan'
            ], 500);
        }
    }

    public function tolak(Request $request, $id)
    {
        try {
            $usulan = UsulanBimbingan::findOrFail($id);
            
            $usulan->update([
                'status' => 'DITOLAK',
                'keterangan' => $request->keterangan
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Usulan bimbingan berhasil ditolak'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses usulan'
            ], 500);
        }
    }
    
}