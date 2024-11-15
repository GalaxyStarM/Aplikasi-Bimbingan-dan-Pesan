<?php

namespace App\Http\Controllers;

use App\Models\Pesan;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Services\FirebaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Tambahkan ini
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Routing\Controller;

class PesanController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function create()
    {
        // Cek guard yang aktif
        if (Auth::guard('mahasiswa')->check()) {
            $dosen = Dosen::all();
            return view('pesan.mahasiswa.buatpesan', compact('dosen'));
        } else {
            $mahasiswa = Mahasiswa::all();
            return view('pesan.dosen.buatpesan', compact('mahasiswa'));
        }
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'subject' => 'required|string|max:255',
            'recipient' => 'required|exists:dosens,nip', // Validate NIP exists
            'priority' => 'required|in:mendesak,umum',
            'message' => 'required|string',
            'attachment' => 'nullable|url'
        ]);

        try {
            $user = auth()->user();

            $pesanData = [
                'subjek' => $request->subject,
                'pesan' => $request->message,
                'prioritas' => $request->priority,
                'attachment' => $request->attachment,
                'status' => 'aktif',
                'last_reply_at' => now(),
                'mahasiswa_nim' => $user->nim,
                'dosen_nip' => $request->recipient,
                'last_reply_by' => 'mahasiswa'
            ];

            // Simpan pesan ke database
            $pesan = Pesan::create($pesanData);

            // Firebase notification jika diperlukan
            try {
                $this->firebaseService->sendNewConsultationNotification($pesan);
            } catch (\Exception $e) {
                \Log::error('Firebase notification failed: ' . $e->getMessage());
            }

            return response()->json(['success' => true, 'message' => 'Pesan berhasil dikirim']);
        } catch (\Exception $e) {
            \Log::error('Error storing message: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menyimpan pesan'], 500);
        }
    }

    public function indexMahasiswa()
    {
        try {
            \Log::info('Accessing indexMahasiswa');
            $user = auth()->guard('mahasiswa')->user();
            \Log::info('User: ' . ($user ? $user->nim : 'none'));
            
            $pesanList = Pesan::where('mahasiswa_nim', $user->nim)
                ->with(['dosen', 'balasan'])
                ->orderBy('created_at', 'desc')
                ->get();

            return view('pesan.mahasiswa.dashboardpesan', [
                'pesanAktif' => $pesanList->where('status', 'aktif'),
                'pesanSelesai' => $pesanList->where('status', 'selesai')
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in indexMahasiswa: ' . $e->getMessage());
            throw $e;
        }
    }

    public function indexDosen() 
    {
        $user = auth()->user();
        $pesanList = Pesan::where('dosen_nip', $user->nip)
            ->with(['mahasiswa', 'balasan'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pesan.mahasiswa.dashboardpesan', [
            'pesanAktif' => $pesanList->where('status', 'aktif'),
            'pesanSelesai' => $pesanList->where('status', 'selesai')
        ]);
    }

    /**
     * Menampilkan detail pesan beserta balasannya
     */
    public function show($id)
    {
        try {
            // Gunakan guard yang aktif untuk menentukan tipe user
            $guard = Auth::getDefaultDriver(); // Akan return 'mahasiswa' atau 'dosen'
            $user = Auth::user();
            
            // Ambil pesan dengan eager loading
            $pesan = Pesan::with([
                'mahasiswa',
                'dosen',
                'balasan' => function($query) {
                    $query->orderBy('created_at', 'asc');
                },
                'balasan.pengirim'
            ])->findOrFail($id);

            // Validasi akses berdasarkan guard
            $isAuthorized = false;
            if ($guard === 'mahasiswa') {
                $isAuthorized = $pesan->mahasiswa_nim === $user->nim;
                $redirectRoute = 'pesan.dashboardkonsultasi';
            } else {
                $isAuthorized = $pesan->dosen_nip === $user->nip;
                $redirectRoute = 'pesan.dashboardpesan';
            }

            if (!$isAuthorized) {
                return redirect()
                    ->route($redirectRoute)
                    ->with('error', 'Anda tidak memiliki akses ke pesan ini');
            }

            // Tentukan view berdasarkan guard
            $view = $guard === 'mahasiswa' ? 
                'pesan.mahasiswa.isipesan' : 
                'pesan.dosen.isipesandosen';

            return view($view, compact('pesan'));

        } catch (\Exception $e) {
            Log::error('Error showing pesan: ' . $e->getMessage());
            
            // Redirect ke dashboard yang sesuai
            $redirectRoute = Auth::getDefaultDriver() === 'mahasiswa' ? 
                'pesan.dashboardkonsultasi' : 
                'pesan.dashboardkonsultasi';
                
            return redirect()
                ->route($redirectRoute)
                ->with('error', 'Terjadi kesalahan saat menampilkan pesan');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $pesan = Pesan::findOrFail($id);
        $oldStatus = $pesan->status;
        
        // Validasi akses
        if (auth()->user()->role === 'mahasiswa' && $pesan->mahasiswa_nim !== auth()->user()->nim) {
            return back()->with('error', 'Unauthorized access');
        }
        
        if (auth()->user()->role === 'dosen' && $pesan->dosen_nip !== auth()->user()->nip) {
            return back()->with('error', 'Unauthorized access');
        }

        $request->validate([
            'status' => 'required|in:aktif,selesai'
        ]);

        $pesan->update([
            'status' => $request->status
        ]);

        // Kirim notifikasi perubahan status
        try {
            $this->firebaseService->sendStatusChangeNotification($pesan, $oldStatus);
        } catch (\Exception $e) {
            \Log::error('Status change notification failed: ' . $e->getMessage());
        }

        return back()->with('success', 'Status pesan berhasil diubah');
    }

    public function remindUnreplied()
    {
        $unrepliedPesan = Pesan::aktif()
            ->whereNull('last_reply_at')
            ->orWhere('last_reply_at', '<=', now()->subDays(2))
            ->get();

        foreach ($unrepliedPesan as $pesan) {
            try {
                $this->firebaseService->sendReminderNotification($pesan);
            } catch (\Exception $e) {
                \Log::error('Reminder notification failed: ' . $e->getMessage());
            }
        }

        return response()->json(['message' => 'Reminders sent successfully']);
    }

    public function getDosen(Request $request)
    {
        try {
            $search = $request->input('search');
            
            $dosen = Dosen::where('nama', 'LIKE', "%{$search}%")
                        ->orWhere('nip', 'LIKE', "%{$search}%")
                        ->select('nip', 'nama')
                        ->limit(10)
                        ->get();
            
            return response()->json($dosen);
        } catch (\Exception $e) {
            return response()->json([], 500);
        }
    }
    public function filterAktif()
    {
        $user = auth()->user();
        $pesanList = [];

        if ($user->role === 'mahasiswa') {
            $pesanList = Pesan::aktif()
                ->where('mahasiswa_nim', $user->nim)
                ->with(['dosen', 'balasan'])
                ->orderBy('created_at', 'desc')
                ->get();
        } elseif ($user->role === 'dosen') {
            $pesanList = Pesan::aktif()
                ->where('dosen_nip', $user->nip)
                ->with(['mahasiswa', 'balasan'])
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('pesan.index', [
            'pesanAktif' => $pesanList,
            'pesanSelesai' => collect(), // Empty collection for completed messages
            'filter' => 'aktif'
        ]);
    }

    public function filterSelesai()
    {
        $user = auth()->user();
        $pesanList = [];

        if ($user->role === 'mahasiswa') {
            $pesanList = Pesan::selesai()
                ->where('mahasiswa_nim', $user->nim)
                ->with(['dosen', 'balasan'])
                ->orderBy('created_at', 'desc')
                ->get();
        } elseif ($user->role === 'dosen') {
            $pesanList = Pesan::selesai()
                ->where('dosen_nip', $user->nip)
                ->with(['mahasiswa', 'balasan'])
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('pesan.index', [
            'pesanAktif' => collect(), // Empty collection for active messages
            'pesanSelesai' => $pesanList,
            'filter' => 'selesai'
        ]);
    }

    public function storeFcmToken(Request $request)
    {
        $request->validate([
            'fcm_token' => 'required|string'
        ]);

        $user = auth()->user();
        
        if ($user->role === 'mahasiswa') {
            Mahasiswa::where('nim', $user->nim)
                ->update(['fcm_token' => $request->fcm_token]);
        } else {
            Dosen::where('nip', $user->nip)
                ->update(['fcm_token' => $request->fcm_token]);
        }

        return response()->json(['message' => 'Token updated successfully']);
    }

    public function requestNotificationPermission()
    {
        try {
            $token = request()->fcm_token;
            if ($token) {
                $user = auth()->user();
                if ($user->role === 'mahasiswa') {
                    Mahasiswa::where('nim', $user->nim)->update(['fcm_token' => $token]);
                } else {
                    Dosen::where('nip', $user->nip)->update(['fcm_token' => $token]);
                }
                session(['fcm_token' => $token]);
                return response()->json(['success' => true]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Menyimpan balasan pesan
     */
    public function storeReply(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            
            // Validasi input
            $request->validate([
                'pesan' => 'required|string',
                'attachment' => 'nullable|file|mimes:pdf,doc,docx|max:10240' // max 10MB
            ]);

            // Temukan pesan utama
            $pesan = Pesan::findOrFail($id);
            
            // Cek apakah pesan masih aktif
            if ($pesan->status !== 'aktif') {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesan sudah tidak aktif'
                ], 403);
            }

            // Dapatkan user yang sedang login dan rolenya
            if (Auth::guard('mahasiswa')->check()) {
                $user = Auth::guard('mahasiswa')->user();
                $role = Role::where('role_akses', 'mahasiswa')->first();
                $isAuthorized = $pesan->mahasiswa_nim === $user->nim;
                $pengirim_id = $user->nim;
            } else if (Auth::guard('dosen')->check()) {
                $user = Auth::guard('dosen')->user();
                $role = Role::where('role_akses', 'dosen')->first();
                $isAuthorized = $pesan->dosen_nip === $user->nip;
                $pengirim_id = $user->nip;
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak terautentikasi'
                ], 401);
            }

            // Cek autorisasi
            if (!$isAuthorized) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses untuk membalas pesan ini'
                ], 403);
            }

            if (!$role) {
                throw new \Exception('Role tidak ditemukan');
            }

            // Handle attachment jika ada
            $attachmentPath = null;
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $attachmentPath = $request->file('attachment')->storeAs(
                    'public/attachments',
                    $fileName
                );
                // Hapus 'public/' dari path karena sudah di-handle oleh storage:link
                $attachmentPath = str_replace('public/', '', $attachmentPath);
            }

            // Simpan balasan
            $balasan = new PesanBalasan();
            $balasan->pesan_id = $id;
            $balasan->role_id = $role->id;
            $balasan->pengirim_id = $pengirim_id;
            $balasan->pesan = $request->pesan;
            $balasan->attachment = $attachmentPath;
            $balasan->is_read = false;
            $balasan->save();

            // Update informasi pesan terakhir
            $pesan->update([
                'last_reply_by' => $role->role_akses,
                'last_reply_at' => Carbon::now()
            ]);

            DB::commit();

            // Siapkan data untuk response
            $response_data = $balasan->load(['role', 'pengirim']);

            return response()->json([
                'success' => true,
                'message' => 'Balasan berhasil dikirim',
                'data' => $response_data
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error storing reply: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengirim balasan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
    * Mengakhiri percakapan
    */
    public function endChat($id)
    {
        try {
            $user = Auth::user();
            $pesan = Pesan::findOrFail($id);

            // Validasi akses
            $isAuthorized = false;
            if ($user->role === 'mahasiswa') {
                $isAuthorized = $pesan->mahasiswa_nim === $user->nim;
            } elseif ($user->role === 'dosen') {
                $isAuthorized = $pesan->dosen_nip === $user->nip;
            }

            if (!$isAuthorized) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            // Update status pesan
            $pesan->update([
                'status' => 'selesai'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pesan telah diakhiri'
            ]);

        } catch (\Exception $e) {
            Log::error('Error ending chat: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengakhiri pesan'
            ], 500);
        }
    }

    /**
     * Download attachment
     */
    public function downloadAttachment($id)
    {
        try {
            $balasan = PesanBalasan::findOrFail($id);
            
            if (!$balasan->attachment) {
                return back()->with('error', 'Tidak ada file attachment');
            }

            if (!Storage::disk('public')->exists($balasan->attachment)) {
                return back()->with('error', 'File tidak ditemukan');
            }

            return Storage::disk('public')->download($balasan->attachment);

        } catch (\Exception $e) {
            Log::error('Error downloading attachment: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengunduh file');
        }
    }

    <?php

namespace App\Http\Controllers;

use App\Models\Pesan;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PesanController extends Controller
{
    public function storePesanDosen(Request $request)
    {
        try {
            DB::beginTransaction();
            
            // Validasi input
            $request->validate([
                'subject' => 'required|string|max:255',
                'recipients' => 'required|array',
                'recipients.*.nim' => 'required|exists:mahasiswas,nim',
                'priority' => 'required|in:high,medium',
                'attachment' => 'nullable|string|url',
                'message' => 'required|string'
            ]);

            // Dapatkan dosen yang sedang login
            $dosen = Auth::guard('dosen')->user();
            if (!$dosen) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 401);
            }

            $success = 0;
            $failed = 0;
            $pesanCreated = [];

            // Konversi prioritas dari form ke database
            $priorityMap = [
                'high' => 'mendesak',
                'medium' => 'umum'
            ];

            // Buat pesan untuk setiap penerima
            foreach ($request->recipients as $recipient) {
                try {
                    $pesan = Pesan::create([
                        'subjek' => $request->subject,
                        'pesan' => $request->message,
                        'prioritas' => $priorityMap[$request->priority],
                        'status' => 'aktif',
                        'attachment' => $request->attachment,
                        'last_reply_at' => now(),
                        'last_reply_by' => 'dosen',
                        'mahasiswa_nim' => $recipient['nim'],
                        'dosen_nip' => $dosen->nip
                    ]);

                    $pesanCreated[] = $pesan;
                    $success++;

                } catch (\Exception $e) {
                    \Log::error('Error creating message for recipient: ' . $recipient['nim'] . ' - ' . $e->getMessage());
                    $failed++;
                }
            }

            DB::commit();

            // Prepare response message
            $message = sprintf(
                'Berhasil mengirim pesan ke %d mahasiswa, %d gagal',
                $success,
                $failed
            );

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => [
                    'success_count' => $success,
                    'failed_count' => $failed,
                    'messages' => $pesanCreated
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error sending messages: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengirim pesan: ' . $e->getMessage()
            ], 500);
        }
    }

    // Method untuk mendapatkan daftar mahasiswa berdasarkan angkatan
    public function getMahasiswaByAngkatan($tahun)
    {
        try {
            $mahasiswa = Mahasiswa::where('angkatan', $tahun)
                ->select('nim', 'nama', 'angkatan')
                ->orderBy('nama')
                ->get()
                ->map(function ($m) {
                    return [
                        'id' => $m->nim,
                        'name' => $m->nama . ' - ' . $m->angkatan,
                        'nim' => $m->nim
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $mahasiswa
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data mahasiswa: ' . $e->getMessage()
            ], 500);
        }
    }
}
}