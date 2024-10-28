<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Dosen extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'dosen';
    protected $primaryKey = 'nip';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nip',
        'nama',
        'nama_singkat',
        'email',
        'password',
        'prodi_id',
        'role_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    public function hasRole($roleName)
    {
        return $this->role->name === $roleName;
    }
}