<?php

namespace App\Http\Controllers;

use App\Models\Bimbingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class BimbinganController extends Controller
{
    private $dosenList;

    public function __construct()
    {
        $jsonPath = public_path('dosen.json');
        $jsonContent = File::get($jsonPath);
        $this->dosenList = json_decode($jsonContent, true)['dosen'];
    }

    /**
     * Menampilkan form bimbingan
     */
    public function create()
    {
        return view('bimbingan.mahasiswa.pilihjadwal', [
            'dosenList' => $this->dosenList
        ]);
    }

    /**
     * Menampilkan daftar bimbingan
     */
    public function index(Request $request)
    {
        $query = Bimbingan::with('mahasiswa');
        
        // Filter berdasarkan status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter berdasarkan jenis bimbingan
        if ($request->has('jenis')) {
            $query->where('jenis_bimbingan', $request->jenis);
        }

        $bimbingan = $query->latest()->paginate(10);
        
        return response()->json([
            'success' => true,
            'data' => $bimbingan
        ]);
    }

    /**
     * Menyimpan usulan bimbingan baru
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nim' => 'required|exists:mahasiswas,nim',
            'jenis_bimbingan' => 'required|in:' . implode(',', Bimbingan::JENIS_BIMBINGAN),
            'tanggal' => 'required|date|after_or_equal:today',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'deskripsi' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $bimbingan = Bimbingan::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Usulan bimbingan berhasil disimpan',
            'data' => $bimbingan
        ], 201);
    }

    /**
     * Menampilkan detail bimbingan
     */
    public function show($id)
    {
        $bimbingan = Bimbingan::with('mahasiswa')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $bimbingan
        ]);
    }

    /**
     * Menyetujui usulan bimbingan
     */
    public function approve(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'lokasi' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $bimbingan = Bimbingan::findOrFail($id);
        
        if ($bimbingan->status !== Bimbingan::STATUS_USULAN) {
            return response()->json([
                'success' => false,
                'message' => 'Hanya usulan bimbingan yang dapat disetujui'
            ], 422);
        }

        $bimbingan->setujui($request->lokasi);

        return response()->json([
            'success' => true,
            'message' => 'Usulan bimbingan berhasil disetujui',
            'data' => $bimbingan
        ]);
    }

    /**
     * Menolak usulan bimbingan
     */
    public function reject(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'alasan' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $bimbingan = Bimbingan::findOrFail($id);
        
        if ($bimbingan->status !== Bimbingan::STATUS_USULAN) {
            return response()->json([
                'success' => false,
                'message' => 'Hanya usulan bimbingan yang dapat ditolak'
            ], 422);
        }

        $bimbingan->tolak($request->alasan);

        return response()->json([
            'success' => true,
            'message' => 'Usulan bimbingan berhasil ditolak',
            'data' => $bimbingan
        ]);
    }

    /**
     * Menyelesaikan bimbingan
     */
    public function complete($id)
    {
        $bimbingan = Bimbingan::findOrFail($id);
        
        if ($bimbingan->status !== Bimbingan::STATUS_DISETUJUI) {
            return response()->json([
                'success' => false,
                'message' => 'Hanya bimbingan yang disetujui yang dapat diselesaikan'
            ], 422);
        }

        $bimbingan->selesaikan();

        return response()->json([
            'success' => true,
            'message' => 'Bimbingan berhasil diselesaikan',
            'data' => $bimbingan
        ]);
    }
}