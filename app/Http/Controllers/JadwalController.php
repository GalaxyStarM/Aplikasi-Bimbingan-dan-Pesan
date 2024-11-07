<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class JadwalController extends Controller
{
    public function index()
    {
        $dosenList = DB::table('dosens')
            ->select('nip', 'nama')
            ->get()
            ->map(function($dosen) {
                return [
                    'nip' => $dosen->nip,
                    'nama' => $dosen->nama
                ];
            })
            ->toArray();

        return view('bimbingan.mahasiswa.pilihjadwal', compact('dosenList'));
    }

    // Tambahkan method untuk cek ketersediaan
    public function checkAvailability(Request $request)
    {
        try {
            $request->validate([
                'jadwal_id' => 'required|exists:jadwal_bimbingans,id',
                'jenis_bimbingan' => 'required|in:skripsi,kp,akademik,konsultasi'
            ]);

            \Log::info('Check Availability Request:', [
                'nim' => auth()->user()->nim,
                'jadwal_id' => $request->jadwal_id,
                'jenis_bimbingan' => $request->jenis_bimbingan
            ]);

            // Get event_id untuk logging
            $event_id = DB::table('jadwal_bimbingans')
                ->where('id', $request->jadwal_id)
                ->value('event_id');
                
            \Log::info('Event ID:', ['event_id' => $event_id]);

            // Cek existing bimbingan
            $existingBimbingan = DB::table('bimbingans')
                ->where('nim', auth()->user()->nim)
                ->where('event_id', $event_id)
                ->where('status', '!=', 'DITOLAK')
                ->exists();

            \Log::info('Existing Bimbingan Check:', ['exists' => $existingBimbingan]);

            if ($existingBimbingan) {
                return response()->json([
                    'available' => false,
                    'message' => 'Anda sudah pernah mengajukan bimbingan untuk jadwal ini'
                ]);
            }

            // Cek pending bimbingan
            $pendingBimbingan = DB::table('bimbingans')
                ->where('nim', auth()->user()->nim)
                ->where('jenis_bimbingan', $request->jenis_bimbingan)
                ->whereIn('status', ['USULAN', 'DITERIMA'])
                ->exists();

            \Log::info('Pending Bimbingan Check:', ['exists' => $pendingBimbingan]);

            if ($pendingBimbingan) {
                return response()->json([
                    'available' => false,
                    'message' => 'Anda masih memiliki pengajuan bimbingan yang dalam proses'
                ]);
            }

            return response()->json([
                'available' => true
            ]);

        } catch (\Exception $e) {
            \Log::error('Check Availability Error:', ['error' => $e->getMessage()]);
            return response()->json([
                'available' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function getAvailableJadwal(Request $request)
    {
        try {
            $request->validate([
                'nip' => 'required|exists:dosens,nip',
                'jenis_bimbingan' => 'required|in:skripsi,kp,akademik,konsultasi'
            ]);

            // Get jadwal yang tersedia
            $jadwal = DB::table('jadwal_bimbingans as jb')
                ->join('dosens as d', 'jb.nip', '=', 'd.nip')
                ->where('jb.nip', $request->nip)
                ->where('jb.status', 'tersedia')
                ->where('jb.sisa_kapasitas', '>', 0)
                ->where('jb.waktu_mulai', '>', now())
                ->select(
                    'jb.id',
                    'jb.event_id',
                    'jb.waktu_mulai',
                    'jb.waktu_selesai',
                    'jb.sisa_kapasitas',
                    'jb.catatan',
                    'jb.lokasi',
                    'd.nama as dosen_nama'
                )
                ->get()
                ->map(function ($item) {
                    $waktuMulai = Carbon::parse($item->waktu_mulai);
                    $waktuSelesai = Carbon::parse($item->waktu_selesai);
                    
                    // Cek apakah mahasiswa sudah memilih jadwal ini
                    $isSelected = DB::table('bimbingans')
                        ->where('nim', auth()->user()->nim)
                        ->where('event_id', $item->event_id)
                        ->where('status', '!=', 'DITOLAK')
                        ->exists();
                    
                    return [
                        'id' => $item->id,
                        'event_id' => $item->event_id,
                        'tanggal' => $waktuMulai->isoFormat('dddd, D MMMM Y'),
                        'waktu' => $waktuMulai->format('H:i') . ' - ' . $waktuSelesai->format('H:i'),
                        'sisa_kapasitas' => $item->sisa_kapasitas,
                        'lokasi' => $item->lokasi,
                        'catatan' => $item->catatan,
                        'dosen_nama' => $item->dosen_nama,
                        'is_selected' => $isSelected
                    ];
                })
                ->sortBy('waktu_mulai')
                ->values();

            return response()->json([
                'status' => 'success',
                'data' => $jadwal
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nip' => 'required|exists:dosens,nip',
                'jenis_bimbingan' => 'required|in:skripsi,kp,akademik,konsultasi',
                'jadwal_id' => 'required|exists:jadwal_bimbingans,id',
                'deskripsi' => 'nullable|string' // Ubah menjadi nullable
            ]);

            DB::beginTransaction();

            // Cek ketersediaan jadwal dan ambil info dosen
            $jadwal = DB::table('jadwal_bimbingans as jb')
                ->join('dosens as d', 'jb.nip', '=', 'd.nip')
                ->where('jb.id', $request->jadwal_id)
                ->where('jb.status', 'tersedia')
                ->where('jb.sisa_kapasitas', '>', 0)
                ->where('jb.waktu_mulai', '>', now())
                ->select('jb.*', 'd.nama as dosen_nama')
                ->first();

            if (!$jadwal) {
                throw new \Exception('Jadwal tidak tersedia atau sudah penuh');
            }

            // Cek jadwal bentrok
            $bentrok = DB::table('bimbingans')
                ->where('nim', auth()->user()->nim)
                ->where('tanggal', Carbon::parse($jadwal->waktu_mulai)->toDateString())
                ->where(function($query) use ($jadwal) {
                    $query->whereBetween('waktu_mulai', [
                        Carbon::parse($jadwal->waktu_mulai)->format('H:i'),
                        Carbon::parse($jadwal->waktu_selesai)->format('H:i')
                    ])
                    ->orWhereBetween('waktu_selesai', [
                        Carbon::parse($jadwal->waktu_mulai)->format('H:i'),
                        Carbon::parse($jadwal->waktu_selesai)->format('H:i')
                    ]);
                })
                ->where('status', '!=', 'DITOLAK')
                ->exists();

            if ($bentrok) {
                throw new \Exception('Anda sudah memiliki jadwal bimbingan di waktu yang sama');
            }

            // Cek apakah sudah pernah mengajukan jadwal yang sama
            $existingBimbingan = DB::table('bimbingans')
                ->where('nim', auth()->user()->nim)
                ->where('event_id', $jadwal->event_id)
                ->where('status', '!=', 'DITOLAK')
                ->exists();

            if ($existingBimbingan) {
                throw new \Exception('Anda sudah pernah mengajukan bimbingan untuk jadwal ini');
            }

            // Cek apakah masih ada bimbingan dalam proses untuk jenis yang sama
            $pendingBimbingan = DB::table('bimbingans')
                ->where('nim', auth()->user()->nim)
                ->where('jenis_bimbingan', $request->jenis_bimbingan)
                ->whereIn('status', ['USULAN', 'DITERIMA'])
                ->exists();

            if ($pendingBimbingan) {
                throw new \Exception('Anda masih memiliki pengajuan bimbingan yang dalam proses');
            }

            // Simpan bimbingan
            $bimbingan = DB::table('bimbingans')->insertGetId([
                'nim' => auth()->user()->nim,
                'nip' => $request->nip,
                'dosen_nama' => $jadwal->dosen_nama,
                'jenis_bimbingan' => $request->jenis_bimbingan,
                'tanggal' => Carbon::parse($jadwal->waktu_mulai)->toDateString(),
                'waktu_mulai' => Carbon::parse($jadwal->waktu_mulai)->format('H:i'),
                'waktu_selesai' => Carbon::parse($jadwal->waktu_selesai)->format('H:i'),
                'lokasi' => $jadwal->lokasi,
                'deskripsi' => $request->deskripsi ?? null, // Beri default null jika tidak diisi
                'status' => 'USULAN',
                'event_id' => $jadwal->event_id,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Update sisa kapasitas
            DB::table('jadwal_bimbingans')
                ->where('id', $request->jadwal_id)
                ->decrement('sisa_kapasitas');

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Jadwal bimbingan berhasil diajukan',
                'data' => $bimbingan
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }
}