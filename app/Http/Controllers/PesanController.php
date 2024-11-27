<?php

namespace App\Http\Controllers;

use App\Models\Pesan;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\PesanBalasan;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PesanController extends Controller
{
    public function create()
    {
        // Cek guard yang aktif
        if (Auth::guard('mahasiswa')->check()) {
            $dosen = Dosen::all();
            return view('pesan.mahasiswa.buatpesan', compact('dosen'));
        } else {
            $mahasiswas = Mahasiswa::orderBy('nama', 'asc')->get();
            return view('pesan.mahasiswa.buatpesan', compact('mahasiswas'));
        }
    }

    public function store(Request $request)
    {
        if (auth()->guard('mahasiswa')->check()) {
            return $this->storePesanMahasiswa($request);
        } else {
            return $this->storePesanDosen($request);
        }
    }

    public function storePesanMahasiswa(Request $request)
    {
        // Validasi input
        $request->validate([
            'subject' => 'required|string|max:255',
            'recipient' => 'required|exists:dosens,nip',
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

            return response()->json(['success' => true, 'message' => 'Pesan berhasil dikirim']);
        } catch (\Exception $e) {
            \Log::error('Error storing message: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menyimpan pesan'], 500);
        }
    }

    public function storePesanDosen(Request $request)
    {
        try {
            $request->validate([
                'subject' => 'required|string|max:255',
                'selected_mahasiswa' => 'required|string', // Untuk menerima string NIM yang dipisahkan koma
                'priority' => 'required|in:mendesak,umum',
                'message' => 'required|string',
                'attachment' => 'nullable|string|url'
            ]);

            DB::beginTransaction();

            $dosen = Auth::guard('dosen')->user();
            if (!$dosen) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 401);
            }

            // Pecah string NIM menjadi array
            $selectedNims = explode(',', $request->selected_mahasiswa);
            
            $success = 0;
            $failed = 0;
            $pesanCreated = [];

            foreach ($selectedNims as $nim) {
                try {
                    $pesan = Pesan::create([
                        'subjek' => $request->subject,
                        'pesan' => $request->message,
                        'prioritas' => $request->priority,
                        'status' => 'aktif',
                        'attachment' => $request->attachment,
                        'last_reply_at' => now(),
                        'last_reply_by' => 'dosen',
                        'mahasiswa_nim' => $nim,
                        'dosen_nip' => $dosen->nip
                    ]);

                    $pesanCreated[] = $pesan;
                    $success++;

                } catch (\Exception $e) {
                    \Log::error('Error creating message for NIM: ' . $nim . ' - ' . $e->getMessage());
                    $failed++;
                }
            }

            DB::commit();

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

    public function indexMahasiswa()
    {
        try {
            $user = auth()->guard('mahasiswa')->user();
            \Log::info('User NIM: ' . $user->nim);
            
            $pesanList = Pesan::where('mahasiswa_nim', $user->nim)
                ->with(['dosen', 'balasan'])
                ->orderBy('created_at', 'desc')
                ->get();
                
            \Log::info('Jumlah pesan: ' . $pesanList->count());
            \Log::info('Pesan aktif: ' . $pesanList->where('status', 'aktif')->count());
            
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

    public function show($id)
    {
        try {
            $guard = Auth::getDefaultDriver();
            $user = Auth::user();
            
            $pesan = Pesan::with([
                'mahasiswa',
                'dosen',
                'balasan' => function($query) {
                    $query->orderBy('created_at', 'asc');
                },
                'balasan.pengirim'
            ])->findOrFail($id);

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

            $view = $guard === 'mahasiswa' ? 
                'pesan.mahasiswa.isipesan' : 
                'pesan.mahasiswa.isipesan';

            return view($view, compact('pesan'));

        } catch (\Exception $e) {
            Log::error('Error showing pesan: ' . $e->getMessage());
            
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

        return back()->with('success', 'Status pesan berhasil diubah');
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
            'pesanSelesai' => collect(),
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
            'pesanAktif' => collect(),
            'pesanSelesai' => $pesanList,
            'filter' => 'selesai'
        ]);
    }

    public function storeReply(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            
            $request->validate([
                'pesan' => 'required|string',
                'attachment' => 'nullable|file|mimes:pdf,doc,docx|max:10240'
            ]);

            $pesan = Pesan::findOrFail($id);
            
            if ($pesan->status !== 'aktif') {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesan sudah tidak aktif'
                ], 403);
            }

            if (Auth::guard('mahasiswa')->check()) {
                $user = Auth::guard('mahasiswa')->user();
                $isAuthorized = $pesan->mahasiswa_nim === $user->nim;
                $pengirim_id = $user->nim;
            } else if (Auth::guard('dosen')->check()) {
                $user = Auth::guard('dosen')->user();
                $isAuthorized = $pesan->dosen_nip === $user->nip;
                $pengirim_id = $user->nip;
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak terautentikasi'
                ], 401);
            }

            if (!$isAuthorized) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses untuk membalas pesan ini'
                ], 403);
            }

            if (!$user->role) {
                throw new \Exception('Role tidak ditemukan');
            }

            $attachmentPath = null;
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $attachmentPath = $request->file('attachment')->storeAs(
                    'public/attachments',
                    $fileName
                );
                $attachmentPath = str_replace('public/', '', $attachmentPath);
            }

            $balasan = PesanBalasan::create([
                'pesan_id' => $id,
                'role_id' => $user->role_id,
                'pengirim_id' => $pengirim_id,
                'pesan' => $request->pesan,
                'attachment' => $attachmentPath,
                'is_read' => false
            ]);

            $pesan->update([
                'last_reply_at' => Carbon::now()
            ]);

            DB::commit();

            $response_data = $balasan->load(['role', 'pengirim']);

            return response()->json([
                'success' => true,
                'data' => $response_data
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error storing reply: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                \Log::error('Error storing reply: ' . $e->getMessage()),
            ], 500);
        }
    }

    public function endChat($id)
    {
        try {
            $user = Auth::user();
            $pesan = Pesan::findOrFail($id);

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

    public function getMahasiswaByAngkatan(Request $request)
    {
        try {

            Log::info('Received request for angkatan:', [
                'angkatan' => $request->query('angkatan')
            ]);

            $angkatanString = $request->query('angkatan');
            if (!$angkatanString) {
                return response()->json([
                    'success' => false,
                    'message' => 'Parameter angkatan tidak ditemukan'
                ], 400);
            }

            $angkatan = explode(',', $angkatanString);

            $mahasiswa = Mahasiswa::whereIn('angkatan', $angkatan)
                ->select('nim', 'nama', 'angkatan')
                ->orderBy('nama')
                ->get()
                ->map(function ($m) {
                    return [
                        'id' => $m->nim,
                        'name' => $m->nama . ' - Angkatan ' . $m->angkatan,
                        'nim' => $m->nim
                    ];
                });

            if ($mahasiswa->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada mahasiswa untuk angkatan yang dipilih'
                ]);
            }

            return response()->json([
                'success' => true,
                'data' => $mahasiswa
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in getMahasiswaByAngkatan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data mahasiswa: ' . $e->getMessage()
            ], 500);
        }
    }
}
