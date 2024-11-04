<?php
// app/Models/JadwalBimbingan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalBimbingan extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'nip',
        'waktu_mulai',
        'waktu_selesai',
        'catatan',
        'status',
        'kapasitas',
        'sisa_kapasitas'
    ];

    protected $dates = [
        'waktu_mulai',
        'waktu_selesai'
    ];

    // Relasi dengan dosen
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'nip', 'nip');
    }

    // Cek apakah jadwal masih tersedia
    public function isAvailable()
    {
        return $this->status === 'available' && $this->sisa_kapasitas > 0;
    }
}