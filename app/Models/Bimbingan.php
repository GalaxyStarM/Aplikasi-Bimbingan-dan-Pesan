<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Bimbingan extends Model
{
    use HasFactory;
    
    protected $table = 'bimbingan';
    
    protected $fillable = [
        'nim',
        'dosen_nama',
        'jenis_bimbingan',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'lokasi',
        'deskripsi',    // Deskripsi/keperluan dari mahasiswa
        'status',       // USULAN/DISETUJUI/DITOLAK/SELESAI
        'keterangan'    // Keterangan dari dosen (alasan ditolak/disetujui)
    ];

    protected $casts = [
        'tanggal' => 'date',
        'waktu_mulai' => 'time',
        'waktu_selesai' => 'time'
    ];

    protected $attributes = [
        'status' => self::STATUS_USULAN
    ];

    // Status bimbingan
    const STATUS_USULAN = 'USULAN';
    const STATUS_DISETUJUI = 'DISETUJUI';
    const STATUS_DITOLAK = 'DITOLAK';
    const STATUS_SELESAI = 'SELESAI';

    // Jenis bimbingan yang tersedia
    const JENIS_BIMBINGAN = [
        'Bimbingan Skripsi',
        'Bimbingan KP',
        'Bimbingan Akademik',
        'Konsultasi Pribadi'
    ];

    // Relasi ke mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    // Format tanggal ke Bahasa Indonesia
    public function getTanggalIndonesiaAttribute()
    {
        return Carbon::parse($this->tanggal)->translatedFormat('l, d F Y');
    }

    // Format range waktu
    public function getWaktuRangeAttribute()
    {
        return date('H.i', strtotime($this->waktu_mulai)) . ' - ' . 
               date('H.i', strtotime($this->waktu_selesai));
    }

    // Method untuk menyetujui usulan
    public function setujui($lokasi)
    {
        $this->update([
            'status' => self::STATUS_DISETUJUI,
            'lokasi' => $lokasi,
            'keterangan' => 'Disetujui'
        ]);
    }

    // Method untuk menolak usulan
    public function tolak($alasan)
    {
        $this->update([
            'status' => self::STATUS_DITOLAK,
            'keterangan' => $alasan
        ]);
    }

    // Method untuk menyelesaikan bimbingan
    public function selesaikan()
    {
        $this->update([
            'status' => self::STATUS_SELESAI
        ]);
    }

    // Scope untuk daftar usulan
    public function scopeUsulan($query)
    {
        return $query->where('status', self::STATUS_USULAN);
    }

    // Scope untuk daftar yang disetujui
    public function scopeDisetujui($query)
    {
        return $query->where('status', self::STATUS_DISETUJUI);
    }

    // Scope untuk daftar yang ditolak
    public function scopeDitolak($query)
    {
        return $query->where('status', self::STATUS_DITOLAK);
    }

    // Scope untuk riwayat bimbingan
    public function scopeRiwayat($query)
    {
        return $query->where('status', self::STATUS_SELESAI);
    }
}