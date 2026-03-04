<x-auth-public-layout>
    @section('title', 'Verifikasi OTP')

    <div class="text-center mb-6">
        <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-blue-50 dark:bg-blue-900/30 mb-4">
            <svg class="w-7 h-7 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Masukkan Kode OTP</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kode OTP telah dikirim ke <span
                class="font-semibold text-gray-700 dark:text-gray-300">{{ $maskedPhone }}</span></p>
    </div>

    @if (session('info'))
        <div
            class="mb-4 p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl text-sm text-blue-700 dark:text-blue-400 text-center">
            {{ session('info') }}
        </div>
    @endif

    @if ($errors->any())
        <div
            class="mb-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl text-sm text-red-700 dark:text-red-400 text-center">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('auth.otp.verify') }}" method="POST" class="space-y-5">
        @csrf
        <div>
            <label for="otp"
                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 text-center">Kode OTP (6
                digit)</label>
            <input type="text" id="otp" name="otp" maxlength="6" placeholder="_ _ _ _ _ _"
                class="w-full px-4 py-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-center text-2xl font-bold tracking-[0.5em] transition-all"
                inputmode="numeric" pattern="[0-9]{6}" autofocus required
                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,6)">
        </div>

        {{-- Countdown timer --}}
        <div class="text-center text-sm text-gray-500 dark:text-gray-400">
            Kode berlaku selama <span id="countdown" class="font-bold text-blue-600 dark:text-blue-400">05:00</span>
        </div>

        <button type="submit"
            class="w-full py-3.5 px-6 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl transition-all shadow-lg hover:shadow-xl text-sm">
            Verifikasi & Masuk
        </button>
    </form>

    <div class="mt-4 text-center space-y-3">
        <form action="{{ route('auth.otp.resend') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="text-sm text-blue-600 dark:text-blue-400 hover:underline font-medium">
                Kirim ulang kode OTP
            </button>
        </form>
        <div>
            <a href="{{ route('auth.phone') }}"
                class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                ← Ganti nomor HP
            </a>
        </div>
    </div>

    {{-- Dev hint --}}
    @if (config('app.debug'))
        <div class="mt-5 pt-4 border-t border-gray-100 dark:border-gray-800">
            <p
                class="text-xs text-center text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-900/20 rounded-lg p-2">
                ⚙️ <strong>Mode Dev:</strong> Cek OTP di <code>storage/logs/laravel.log</code>
            </p>
        </div>
    @endif
</x-auth-public-layout>

<script>
    // Countdown 5 minutes
    let secs = 300;
    const el = document.getElementById('countdown');
    const timer = setInterval(() => {
        secs--;
        const m = String(Math.floor(secs / 60)).padStart(2, '0');
        const s = String(secs % 60).padStart(2, '0');
        if (el) el.textContent = `${m}:${s}`;
        if (secs <= 0) {
            clearInterval(timer);
            if (el) el.textContent = 'Kadaluarsa';
        }
    }, 1000);
</script>
