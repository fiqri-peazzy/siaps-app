<x-auth-public-layout>
    @section('title', 'Masuk dengan Nomor HP')

    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Selamat Datang</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Masuk menggunakan nomor HP untuk mengajukan surat</p>
    </div>

    @if ($errors->any())
        <div
            class="mb-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl text-sm text-red-700 dark:text-red-400">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('auth.otp.send') }}" method="POST" class="space-y-5">
        @csrf
        <div>
            <label for="phone" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nomor
                Handphone</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">🇮🇩</span>
                </div>
                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                    placeholder="08xx-xxxx-xxxx"
                    class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-sm"
                    required autofocus>
            </div>
            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Format: 081234567890 atau +6281234567890</p>
        </div>

        <button type="submit"
            class="w-full py-3.5 px-6 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 transform text-sm">
            Kirim Kode OTP
            <svg class="inline-block w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </button>
    </form>

    <div class="mt-6 text-center">
        <p class="text-xs text-gray-400 dark:text-gray-500">
            Kode OTP akan dikirim ke nomor WhatsApp/SMS Anda.<br>
            Dengan melanjutkan, Anda menyetujui
            <a href="#" class="text-blue-500 hover:underline">Syarat & Ketentuan</a> kami.
        </p>
    </div>

    <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-800 text-center">
        <p class="text-xs text-gray-500 dark:text-gray-400">Sudah punya akun admin? <a href="{{ route('login') }}"
                class="text-blue-500 hover:underline font-medium">Login Admin</a></p>
    </div>
</x-auth-public-layout>
