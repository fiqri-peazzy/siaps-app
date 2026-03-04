<x-public-layout>
    @section('title', 'Akun Saya')

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl p-8 text-white mb-8 shadow-xl">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center text-3xl">👤</div>
                <div>
                    <h1 class="text-2xl font-bold">Halo, {{ Auth::user()->name }}!</h1>
                    <p class="text-blue-200 text-sm mt-1">{{ Auth::user()->phone }} · Akun Warga</p>
                </div>
            </div>
        </div>

        <div class="grid sm:grid-cols-2 gap-6 mb-8">
            <a href="{{ route('public.layanan') }}"
                class="group bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-100 dark:border-gray-800 hover:border-blue-200 dark:hover:border-blue-700 hover:shadow-lg transition-all hover:-translate-y-1">
                <div class="text-3xl mb-3">📋</div>
                <h3
                    class="font-bold text-gray-900 dark:text-white mb-1 group-hover:text-blue-600 dark:group-hover:text-blue-400">
                    Ajukan Surat Baru</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Pilih jenis surat dan ajukan permohonan secara
                    online</p>
            </a>
            <div
                class="bg-gray-50 dark:bg-gray-900/50 rounded-2xl p-6 border border-dashed border-gray-200 dark:border-gray-700">
                <div class="text-3xl mb-3">📬</div>
                <h3 class="font-bold text-gray-500 dark:text-gray-400 mb-1">Status Pengajuan</h3>
                <p class="text-sm text-gray-400 dark:text-gray-500">Fitur pelacakan status pengajuan akan segera
                    tersedia</p>
                <span
                    class="inline-block mt-2 px-2 py-1 bg-yellow-50 dark:bg-yellow-900/20 text-yellow-600 dark:text-yellow-400 text-xs rounded-full">Segera
                    hadir</span>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-100 dark:border-gray-800">
            <h2 class="font-bold text-gray-900 dark:text-white mb-4">Informasi Akun</h2>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between py-2 border-b border-gray-50 dark:border-gray-800">
                    <span class="text-gray-500 dark:text-gray-400">Nama</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{ Auth::user()->name }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-50 dark:border-gray-800">
                    <span class="text-gray-500 dark:text-gray-400">No. HP</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{ Auth::user()->phone }}</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-gray-500 dark:text-gray-400">Status HP</span>
                    <span
                        class="text-green-600 dark:text-green-400 font-medium">{{ Auth::user()->phone_verified_at ? '✓ Terverifikasi' : 'Belum terverifikasi' }}</span>
                </div>
            </div>
            <div class="mt-6 pt-4 border-t border-gray-100 dark:border-gray-800">
                <form action="{{ route('auth.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-public-layout>
