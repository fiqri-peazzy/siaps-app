<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PhoneAuthController extends Controller
{
    public function __construct(private OtpService $otpService) {}

    /** Step 1: Show phone input form */
    public function showPhoneForm()
    {
        if (Auth::check() && Auth::user()->role === 'masyarakat') {
            return redirect()->route('masyarakat.home');
        }
        return view('auth.phone-login');
    }

    /** Step 2: Send OTP to phone */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'string', 'regex:/^(\+62|62|0)8[1-9][0-9]{6,10}$/'],
        ], [
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.regex'    => 'Format nomor telepon tidak valid. Gunakan format: 08xx atau +62xx',
        ]);

        // Normalize phone: ensure it starts with 62
        $phone = $this->normalizePhone($request->phone);

        // Find or create user
        $user = User::firstOrCreate(
            ['phone' => $phone],
            ['name' => 'Pengguna ' . substr($phone, -4), 'role' => 'masyarakat', 'status' => 'active']
        );

        if ($user->status === 'suspended') {
            return back()->withErrors(['phone' => 'Akun Anda telah dinonaktifkan. Hubungi admin.']);
        }

        $this->otpService->generateOtp($phone, 'login');

        session(['otp_phone' => $phone]);

        return redirect()->route('auth.otp.form')
            ->with('info', 'Kode OTP telah dikirim ke ' . $this->maskPhone($phone));
    }

    /** Step 3: Show OTP input form */
    public function showOtpForm(Request $request)
    {
        if (!session('otp_phone')) {
            return redirect()->route('auth.phone')->withErrors(['phone' => 'Sesi habis. Silakan ulangi.']);
        }
        $maskedPhone = $this->maskPhone(session('otp_phone'));
        return view('auth.otp-verify', compact('maskedPhone'));
    }

    /** Step 4: Verify OTP and login */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ], [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.digits'   => 'Kode OTP harus 6 angka.',
        ]);

        $phone = session('otp_phone');
        if (!$phone) {
            return redirect()->route('auth.phone')->withErrors(['phone' => 'Sesi habis. Silakan ulangi.']);
        }

        if (!$this->otpService->verifyOtp($phone, $request->otp, 'login')) {
            return back()->withErrors(['otp' => 'Kode OTP salah atau sudah kadaluarsa.']);
        }

        $user = User::where('phone', $phone)->first();
        $user->update([
            'phone_verified_at' => $user->phone_verified_at ?? now(),
            'last_login_at'     => now(),
            'last_login_ip'     => $request->ip(),
        ]);

        Auth::login($user, true);
        session()->forget('otp_phone');
        $request->session()->regenerate();

        return redirect()->route('masyarakat.home');
    }

    /** Resend OTP */
    public function resendOtp(Request $request)
    {
        $phone = session('otp_phone');
        if (!$phone) {
            return redirect()->route('auth.phone');
        }

        $this->otpService->generateOtp($phone, 'login');

        return back()->with('info', 'Kode OTP baru telah dikirim.');
    }

    /** Logout */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    private function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/\D/', '', $phone);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        } elseif (!str_starts_with($phone, '62')) {
            $phone = '62' . $phone;
        }
        return $phone;
    }

    private function maskPhone(string $phone): string
    {
        if (strlen($phone) <= 6) return $phone;
        return substr($phone, 0, 4) . str_repeat('*', strlen($phone) - 7) . substr($phone, -3);
    }
}
