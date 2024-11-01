<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class DosenGoogleToken extends Model
{
    use HasFactory;
    protected $table = 'dosen_google_tokens';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'nip',
        'access_token',
        'refresh_token',
        'expires_in',
        'created'
    ];

    protected $casts = [
        'created' => 'datetime',
    ];

    /**
     * Get the dosen that owns the token.
     */
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'nip', 'nip');
    }

    /**
     * Get the decrypted access token
     */
    public function getAccessTokenAttribute($value)
    {
        return $value ? Crypt::decryptString($value) : null;
    }

    /**
     * Set the encrypted access token
     */
    public function setAccessTokenAttribute($value)
    {
        $this->attributes['access_token'] = $value ? Crypt::encryptString($value) : null;
    }

    /**
     * Get the decrypted refresh token
     */
    public function getRefreshTokenAttribute($value)
    {
        return $value ? Crypt::decryptString($value) : null;
    }

    /**
     * Set the encrypted refresh token
     */
    public function setRefreshTokenAttribute($value)
    {
        $this->attributes['refresh_token'] = $value ? Crypt::encryptString($value) : null;
    }

    /**
     * Check if the token is expired
     */
    public function isExpired()
    {
        return $this->created->addSeconds($this->expires_in)->isPast();
    }
}