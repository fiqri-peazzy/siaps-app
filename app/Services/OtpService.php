<?php

namespace App\Services;

use App\Models\OtpVerification;
use Illuminate\Support\Facades\Log;

class OtpService
{
    const OTP_EXPIRY_MINUTES = 5;
    const OTP_LENGTH = 6;

    /**
     * Generate and store a new OTP for the given phone number.
     */
    public function generateOtp(string $phone, string $purpose = 'login'): string
    {
        // Invalidate old unused OTPs for this phone
        OtpVerification::where('identifier', $phone)
            ->where('purpose', $purpose)
            ->where('is_used', false)
            ->update(['is_used' => true]);

        $otp = str_pad(random_int(0, 999999), self::OTP_LENGTH, '0', STR_PAD_LEFT);

        OtpVerification::create([
            'identifier'  => $phone,
            'type'        => 'phone',
            'purpose'     => $purpose,
            'otp_code'    => $otp,
            'channel'     => 'whatsapp',
            'is_used'     => false,
            'attempt_count' => 0,
            'expires_at'  => now()->addMinutes(self::OTP_EXPIRY_MINUTES),
            'ip_address'  => request()->ip(),
        ]);

        // For development: log the OTP instead of sending via WhatsApp/SMS
        Log::info("OTP [{$purpose}] untuk {$phone}: {$otp} (berlaku " . self::OTP_EXPIRY_MINUTES . " menit)");

        // TODO: Send via WhatsApp/SMS gateway in production
        // $this->sendWhatsApp($phone, $otp);

        return $otp;
    }

    /**
     * Verify the OTP submitted by user.
     */
    public function verifyOtp(string $phone, string $otpInput, string $purpose = 'login'): bool
    {
        $record = OtpVerification::where('identifier', $phone)
            ->where('purpose', $purpose)
            ->where('is_used', false)
            ->latest()
            ->first();

        if (!$record) {
            return false;
        }

        // Increment attempt
        $record->increment('attempt_count');

        if (!$record->isValid()) {
            return false;
        }

        if ($record->otp_code !== $otpInput) {
            return false;
        }

        // Mark as used
        $record->update([
            'is_used' => true,
            'used_at' => now(),
        ]);

        return true;
    }

    /**
     * Check if phone has an active (non-expired) OTP session.
     */
    public function hasActiveOtp(string $phone, string $purpose = 'login'): bool
    {
        return OtpVerification::where('identifier', $phone)
            ->where('purpose', $purpose)
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->exists();
    }
}
