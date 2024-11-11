<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UsulanBimbingan extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nim',
        'nip',
        'event_id',
        'mahasiswa_nama',
        'dosen_nama',
        'jenis_bimbingan',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'lokasi',
        'status',       
        'keterangan'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'waktu_mulai' => 'string', 
        'waktu_selesai' => 'string', 
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'status' => self::STATUS_USULAN,
        'lokasi' => null,
        'keterangan' => null
    ];

    // Status bimbingan
    const STATUS_USULAN = 'USULAN';
    const STATUS_DISETUJUI = 'DISETUJUI';
    const STATUS_DITOLAK = 'DITOLAK';
    const STATUS_SELESAI = 'SELESAI';

    // Relasi dengan model lain
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'nip', 'nip');
    }

    // Accessor 
    public function getWaktuLengkapAttribute(): string
    {
        return Carbon::parse($this->tanggal)->format('l, d F Y') . 
               ' | ' . 
               $this->waktu_mulai . ' - ' . $this->waktu_selesai;
    }

    // Methods untuk persetujuan
    public function setujui(?string $lokasi = null): bool
    {
        return $this->update([
            'status' => self::STATUS_DISETUJUI,
            'lokasi' => $lokasi 
        ]);
    }

    public function tolak(string $keterangan): bool
    {
        return $this->update([
            'status' => self::STATUS_DITOLAK,
            'keterangan' => $keterangan
        ]);
    }
}