<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpVerification extends Model
{
    protected $table = 'otp_verifications';

    protected $fillable = [
        'identifier',
        'type',
        'purpose',
        'otp_code',
        'channel',
        'is_used',
        'attempt_count',
        'expires_at',
        'used_at',
        'ip_address',
    ];

    protected $casts = [
        'is_used'      => 'boolean',
        'expires_at'   => 'datetime',
        'used_at'      => 'datetime',
    ];

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function isValid(): bool
    {
        return !$this->is_used && !$this->isExpired() && $this->attempt_count < 5;
    }
}
