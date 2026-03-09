<x-public-layout>
    @section('title', 'Beranda')

    {{-- HERO SECTION --}}
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600 via-indigo-700 to-purple-800"></div>
        <div class="absolute inset-0 opacity-20"
            style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.4\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-36">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <div
                        class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur rounded-full text-white/80 text-sm mb-6">
                        <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                        Sistem Pelayanan Digital Aktif
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-6">
                        Selamat Datang di<br>
                        <span class="text-yellow-300">{{ $profil->nama_desa ?? 'Desa Kami' }}</span>
                    </h1>
                    @if ($profil->visi)
                        <p class="text-blue-100 text-lg leading-relaxed mb-8 italic">
                            "{{ Str::limit($profil->visi, 160) }}"</p>
                    @else
                        <p class="text-blue-100 text-lg leading-relaxed mb-8">Layanan administrasi surat menyurat secara
                            digital — cepat, mudah, dan transparan.</p>
                    @endif
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ Auth::check() && Auth::user()->role === 'masyarakat' ? route('masyarakat.pengajuan.index') : route('auth.phone') }}"
                            class="inline-flex items-center gap-2 px-6 py-3.5 bg-white text-blue-700 font-bold rounded-2xl hover:bg-yellow-50 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 transform">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                            Ajukan Surat Sekarang
                        </a>
                        <a href="{{ route('public.layanan') }}"
                            class="inline-flex items-center gap-2 px-6 py-3.5 bg-white/10 backdrop-blur text-white font-semibold rounded-2xl hover:bg-white/20 border border-white/20 transition-all">
                            Lihat Layanan
                        </a>
                    </div>
                </div>

                {{-- Stats Cards --}}
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/20">
                        <div class="text-3xl font-extrabold text-white mb-1">{{ number_format($totalPenduduk) }}</div>
                        <div class="text-blue-200 text-sm">Penduduk Terdaftar</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/20">
                        <div class="text-3xl font-extrabold text-white mb-1">{{ $layanan->count() }}</div>
                        <div class="text-blue-200 text-sm">Jenis Layanan Surat</div>
                    </div>
                    <div
                        class="col-span-2 bg-yellow-400/20 backdrop-blur-md rounded-2xl p-5 border border-yellow-300/30">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-yellow-400/30 rounded-xl">
                                <svg class="w-6 h-6 text-yellow-200" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-white font-bold">Layanan 24 Jam</div>
                                <div class="text-yellow-200 text-xs">Pengajuan online kapan saja</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- LAYANAN SECTION --}}
    @if ($layanan->count() > 0)
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center mb-12">
                <span
                    class="inline-block px-4 py-1.5 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-sm font-semibold rounded-full mb-3">Layanan
                    Kami</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">Layanan Surat Tersedia</h2>
                <p class="text-gray-500 dark:text-gray-400 mt-3 max-w-2xl mx-auto">Ajukan berbagai keperluan surat
                    administrasi kependudukan secara digital dari rumah Anda.</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    $icons = [
                        'file-text',
                        'clipboard-list',
                        'files',
                        'home',
                        'baby',
                        'heart',
                        'scroll',
                        'folder-kanban',
                        'hospital',
                        'briefcase',
                    ];
                @endphp
                @foreach ($layanan as $i => $s)
                    <div
                        class="group bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-100 dark:border-gray-800 hover:border-blue-200 dark:hover:border-blue-700 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                        <div
                            class="p-3 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-xl w-fit mb-4">
                            <x-icon name="{{ $icons[$i % count($icons)] }}" class="w-7 h-7" />
                        </div>
                        <h3
                            class="font-bold text-gray-900 dark:text-white mb-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                            {{ $s->nama }}</h3>
                        @if ($s->deskripsi)
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4 leading-relaxed">
                                {{ Str::limit($s->deskripsi, 90) }}</p>
                        @endif
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-400 dark:text-gray-500 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                        clip-rule="evenodd" />
                                </svg>
                                SLA {{ $s->sla_hari }} hari kerja
                            </span>
                            <a href="{{ Auth::check() && Auth::user()->role === 'masyarakat' ? route('masyarakat.pengajuan.create', $s->kode) : route('auth.phone') }}"
                                class="text-xs font-semibold text-blue-600 dark:text-blue-400 hover:underline">Ajukan
                                →</a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-8">
                <a href="{{ Auth::check() && Auth::user()->role === 'masyarakat' ? route('masyarakat.pengajuan.index') : route('public.layanan') }}"
                    class="inline-flex items-center gap-2 px-6 py-3 border-2 border-blue-600 text-blue-600 dark:text-blue-400 dark:border-blue-400 font-semibold rounded-xl hover:bg-blue-600 hover:text-white dark:hover:bg-blue-600 dark:hover:text-white transition-all">
                    Lihat Semua Layanan
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        </section>
    @endif

    {{-- HOW IT WORKS --}}
    <section class="bg-gradient-to-br from-gray-50 to-blue-50 dark:from-gray-900 dark:to-indigo-950 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span
                    class="inline-block px-4 py-1.5 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 text-sm font-semibold rounded-full mb-3">Panduan</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">Cara Pengajuan Surat</h2>
            </div>
            <div class="grid md:grid-cols-4 gap-8">
                @php
                    $steps = [
                        [
                            'icon' => 'smartphone',
                            'title' => '1. Daftar / Login',
                            'desc' => 'Masukkan nomor HP dan verifikasi dengan kode OTP yang dikirim ke WhatsApp Anda.',
                        ],
                        [
                            'icon' => 'clipboard-list',
                            'title' => '2. Pilih Layanan',
                            'desc' => 'Pilih jenis surat yang dibutuhkan dari daftar layanan yang tersedia.',
                        ],
                        [
                            'icon' => 'send',
                            'title' => '3. Isi & Kirim',
                            'desc' => 'Lengkapi formulir dan unggah dokumen persyaratan yang diperlukan.',
                        ],
                        [
                            'icon' => 'package',
                            'title' => '4. Terima Surat',
                            'desc' => 'Pantau status pengajuan dan unduh surat yang sudah terbit.',
                        ],
                    ];
                @endphp
                @foreach ($steps as $step)
                    <div class="text-center">
                        <div
                            class="w-16 h-16 bg-white dark:bg-gray-800 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm border border-gray-100 dark:border-gray-800 text-indigo-600 dark:text-indigo-400">
                            <x-icon name="{{ $step['icon'] }}" class="w-8 h-8" />
                        </div>
                        <h3 class="font-bold text-gray-900 dark:text-white mb-2">{{ $step['title'] }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">{{ $step['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- BERITA SECTION --}}
    @if ($berita->count() > 0)
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <span
                        class="inline-block px-4 py-1.5 bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400 text-sm font-semibold rounded-full mb-3">Terbaru</span>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Informasi & Berita Desa</h2>
                </div>
                <a href="{{ route('public.informasi') }}"
                    class="text-sm font-semibold text-blue-600 dark:text-blue-400 hover:underline hidden md:block">Lihat
                    Semua →</a>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach ($berita as $artikel)
                    <article
                        class="group bg-white dark:bg-gray-900 rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-800 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                        @if ($artikel->thumbnail)
                            <div class="aspect-video overflow-hidden">
                                <img src="{{ asset('storage/' . $artikel->thumbnail) }}" alt="{{ $artikel->judul }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </div>
                        @else
                            <div
                                class="aspect-video bg-gradient-to-br from-blue-100 to-indigo-200 dark:from-blue-900/30 dark:to-indigo-900/30 flex items-center justify-center">
                                <x-icon name="{{ $artikel->kategori === 'pengumuman' ? 'megaphone' : 'newspaper' }}"
                                    class="w-12 h-12 text-blue-400 dark:text-blue-500" />
                            </div>
                        @endif
                        <div class="p-5">
                            <div class="flex items-center gap-2 mb-3">
                                <span
                                    class="px-2.5 py-1 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-xs font-semibold rounded-full">{{ $artikel->kategori_label }}</span>
                                @if ($artikel->is_pinned)
                                    <span class="text-yellow-500 text-xs">📌 Pinned</span>
                                @endif
                            </div>
                            <h3
                                class="font-bold text-gray-900 dark:text-white mb-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-2">
                                {{ $artikel->judul }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                                {{ $artikel->published_at?->diffForHumans() ?? '-' }}</p>
                            <a href="{{ route('public.informasi.show', $artikel->slug) }}"
                                class="text-sm font-semibold text-blue-600 dark:text-blue-400 hover:underline">Baca
                                selengkapnya →</a>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    {{-- CTA SECTION --}}
    <section class="py-20 px-4 sm:px-6 lg:px-8">
        <div
            class="max-w-4xl mx-auto text-center bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl px-8 py-16 shadow-2xl">
            <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-4">Butuh Surat Keterangan?</h2>
            <p class="text-blue-100 text-lg mb-8">Ajukan secara online tanpa perlu antri. Proseskan dari rumah kapan
                saja dan di mana saja.</p>
            <a href="{{ Auth::check() && Auth::user()->role === 'masyarakat' ? route('masyarakat.pengajuan.index') : route('auth.phone') }}"
                class="inline-flex items-center gap-2 px-8 py-4 bg-white text-blue-700 font-bold rounded-2xl hover:bg-yellow-50 transition-all shadow-lg hover:shadow-xl text-base">
                Mulai Sekarang — Gratis
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </a>
        </div>
    </section>
</x-public-layout>
