<?php

namespace App\Traits;

use Illuminate\Support\Facades\Crypt;

trait HasGoogleCalendar
{
    /**
     * Get the decrypted access token
     */
    public function getGoogleAccessTokenAttribute($value)
    {
        return $value ? Crypt::decryptString($value) : null;
    }

    /**
     * Set the encrypted access token
     */
    public function setGoogleAccessTokenAttribute($value)
    {
        $this->attributes['google_access_token'] = $value ? Crypt::encryptString($value) : null;
    }

    /**
     * Get the decrypted refresh token
     */
    public function getGoogleRefreshTokenAttribute($value)
    {
        return $value ? Crypt::decryptString($value) : null;
    }

    /**
     * Set the encrypted refresh token
     */
    public function setGoogleRefreshTokenAttribute($value)
    {
        $this->attributes['google_refresh_token'] = $value ? Crypt::encryptString($value) : null;
    }

    /**
     * Check if Google Calendar is connected
     */
    public function hasGoogleCalendarConnected()
    {
        return !empty($this->google_access_token) && !empty($this->google_refresh_token);
    }

    /**
     * Check if the Google token is expired
     */
    public function isGoogleTokenExpired()
    {
        if (!$this->google_token_created_at || !$this->google_token_expires_in) {
            return true;
        }
        
        return $this->google_token_created_at
            ->addSeconds($this->google_token_expires_in)
            ->isPast();
    }

    /**
     * Update Google token information
     */
    public function updateGoogleToken($accessToken, $refreshToken = null, $expiresIn = null)
    {
        $this->google_access_token = $accessToken;
        
        if ($refreshToken) {
            $this->google_refresh_token = $refreshToken;
        }
        
        if ($expiresIn) {
            $this->google_token_expires_in = $expiresIn;
            $this->google_token_created_at = now();
        }
        
        $this->save();
        
        return $this;
    }
}
