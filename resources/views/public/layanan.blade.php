<x-public-layout>
    @section('title', 'Layanan Surat')

    <section class="bg-gradient-to-r from-indigo-700 to-purple-800 py-16 px-4">
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-3">Layanan Surat</h1>
            <p class="text-indigo-200">Daftar lengkap layanan administrasi surat yang tersedia di
                {{ $profil->nama_desa ?? 'desa kami' }}</p>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        @if ($layanan->count() > 0)
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @php $icons = ['📄','📋','📑','🏠','👶','💒','📜','🗂️','🏥','💼','🎓','⚖️']; @endphp
                @foreach ($layanan as $i => $s)
                    <div
                        class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-100 dark:border-gray-800 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 hover:border-indigo-200 dark:hover:border-indigo-700">
                        <div class="flex items-start gap-4 mb-4">
                            <div class="text-3xl">{{ $icons[$i % count($icons)] }}</div>
                            <div>
                                <span
                                    class="text-xs font-mono bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 px-2 py-0.5 rounded">{{ $s->kode }}</span>
                            </div>
                        </div>
                        <h3 class="font-bold text-gray-900 dark:text-white text-lg mb-2">{{ $s->nama }}</h3>
                        @if ($s->deskripsi)
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4 leading-relaxed">{{ $s->deskripsi }}
                            </p>
                        @endif
                        <div class="space-y-2 pt-4 border-t border-gray-50 dark:border-gray-800">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Estimasi waktu</span>
                                <span class="font-semibold text-gray-900 dark:text-white">{{ $s->sla_hari }} hari
                                    kerja</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Verifikasi</span>
                                <span
                                    class="font-semibold {{ $s->requires_verification ? 'text-amber-600 dark:text-amber-400' : 'text-green-600 dark:text-green-400' }}">{{ $s->requires_verification ? 'Diperlukan' : 'Tidak perlu' }}</span>
                            </div>
                        </div>
                        <a href="{{ route('auth.phone') }}"
                            class="mt-4 block w-full text-center py-2.5 px-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white text-sm font-semibold rounded-xl transition-all">
                            Ajukan Sekarang
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-20">
                <p class="text-5xl mb-4">📭</p>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Belum ada layanan tersedia</h3>
                <p class="text-gray-500 dark:text-gray-400">Layanan akan segera ditambahkan oleh admin.</p>
            </div>
        @endif
    </section>
</x-public-layout>
