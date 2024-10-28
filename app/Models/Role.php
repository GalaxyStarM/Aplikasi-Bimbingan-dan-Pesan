<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = 'role';
    protected $primaryKey = 'role_id';
    protected $fillable = [
        'role_id',
        'role_akses'
    ];

    // Relasi ke Dosen
    public function dosen()
    {
        return $this->hasMany(Dosen::class, 'role_id');
    }

    // Relasi ke Mahasiswa
    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class, 'role_id');
    }
}
