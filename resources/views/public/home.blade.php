<x-public-layout>
    @section('title', 'Beranda')

    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
        <style>
            .hero-swiper {
                width: 100%;
                height: 700px;
            }

            @media (max-width: 768px) {
                .hero-swiper {
                    height: 600px;
                }
            }

            .swiper-slide {
                position: relative;
                overflow: hidden;
                border-radius: 0 0 2rem 2rem;
            }

            .swiper-pagination-bullet {
                background: white !important;
                opacity: 0.5;
            }

            .swiper-pagination-bullet-active {
                opacity: 1;
                width: 24px !important;
                border-radius: 4px !important;
            }

            .glass-card {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }

            .dark .glass-card {
                background: rgba(0, 0, 0, 0.3);
                border: 1px solid rgba(255, 255, 255, 0.1);
            }
        </style>
    @endpush

    {{-- HERO SLIDER SECTION --}}
    <section class="relative bg-black">
        <div class="swiper hero-swiper">
            <div class="swiper-wrapper">
                @forelse($slider as $item)
                    <div class="swiper-slide overflow-hidden">
                        <div class="mt-[-100px] pt-[100px] min-h-full flex flex-col justify-center relative">
                            <div class="absolute inset-0">
                                @if ($item->thumbnail)
                                    <img src="{{ asset('storage/' . $item->thumbnail) }}"
                                        class="w-full h-full object-cover" alt="{{ $item->judul }}">
                                @endif
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent">
                                </div>
                            </div>
                            <div class="relative h-full max-w-7xl mx-auto px-6 pb-32">
                                <div class="max-w-3xl">
                                    <div
                                        class="inline-flex items-center gap-2 px-3 py-1 bg-blue-600 text-white text-[10px] font-black rounded-lg mb-6 uppercase tracking-widest border border-blue-500/50 shadow-lg shadow-blue-500/20">
                                        {{ $item->kategori }}
                                    </div>
                                    <h1
                                        class="text-4xl md:text-7xl font-black text-white leading-[1.1] mb-8 tracking-tight">
                                        {{ $item->judul }}
                                    </h1>
                                    <div class="flex items-center gap-6 text-gray-300 text-xs font-bold mb-10">
                                        <span class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ $item->published_at->translatedFormat('d F Y') }}
                                        </span>
                                        <span class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            {{ $item->penulis->name }}
                                        </span>
                                    </div>
                                    <div class="flex flex-wrap gap-4">
                                        <a href="{{ route('public.informasi.show', $item->slug) }}"
                                            class="inline-flex items-center gap-3 px-10 py-5 bg-white text-blue-900 font-black rounded-2xl hover:bg-blue-50 transition-all shadow-2xl hover:-translate-y-1 uppercase text-sm tracking-widest">
                                            Baca Selengkapnya
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="swiper-slide overflow-hidden">
                        <div class="mt-[-100px] pt-[100px] min-h-full flex flex-col justify-center relative">
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-700 to-indigo-900"></div>
                            <div class="relative max-w-7xl mx-auto px-6 text-center items-center flex flex-col">
                                <h1 class="text-5xl md:text-8xl font-black text-white mb-8 tracking-tighter">Selamat
                                    Datang</h1>
                                <p class="text-xl text-blue-100 max-w-2xl mb-12 font-medium leading-relaxed opacity-80">
                                    {{ $profil->visi }}</p>
                                <a href="{{ route('public.layanan') }}"
                                    class="px-10 py-5 bg-white text-blue-700 font-black rounded-2xl uppercase text-sm tracking-widest shadow-xl hover:-translate-y-1 transition-all">Lihat
                                    Layanan</a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Navigation --}}
            <div
                class="hidden md:flex swiper-button-prev !text-white !w-14 !h-14 bg-white/10 hover:bg-white/20 backdrop-blur-md rounded-2xl transition-all border border-white/10 after:!text-xl">
            </div>
            <div
                class="hidden md:flex swiper-button-next !text-white !w-14 !h-14 bg-white/10 hover:bg-white/20 backdrop-blur-md rounded-2xl transition-all border border-white/10 after:!text-xl">
            </div>

            <div class="swiper-pagination !bottom-10"></div>
        </div>

        {{-- Floating Stats Bar --}}
        <div class="absolute bottom-0 left-0 right-0 z-10 translate-y-1/2 px-4">
            <div class="max-w-5xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="glass-card p-6 rounded-3xl shadow-2xl text-center">
                    <div class="text-2xl md:text-3xl font-black text-white dark:text-blue-400 mb-1 tracking-tight">
                        {{ number_format($totalPenduduk) }}</div>
                    <div
                        class="text-gray-300 dark:text-gray-400 text-[10px] md:text-xs font-bold uppercase tracking-widest">
                        Penduduk</div>
                </div>
                <div class="glass-card p-6 rounded-3xl shadow-2xl text-center">
                    <div class="text-2xl md:text-3xl font-black text-white dark:text-blue-400 mb-1 tracking-tight">
                        {{ $layanan->count() }}</div>
                    <div
                        class="text-gray-300 dark:text-gray-400 text-[10px] md:text-xs font-bold uppercase tracking-widest">
                        Layanan Digital</div>
                </div>
                <div class="glass-card p-6 rounded-3xl shadow-2xl text-center">
                    <div class="text-2xl md:text-3xl font-black text-white dark:text-blue-400 mb-1 tracking-tight">24/7
                    </div>
                    <div
                        class="text-gray-300 dark:text-gray-400 text-[10px] md:text-xs font-bold uppercase tracking-widest">
                        Akses Mandiri</div>
                </div>
                <div class="glass-card p-6 rounded-3xl shadow-2xl text-center">
                    <div class="text-2xl md:text-3xl font-black text-white dark:text-blue-400 mb-1 tracking-tight">100%
                    </div>
                    <div
                        class="text-gray-300 dark:text-gray-400 text-[10px] md:text-xs font-bold uppercase tracking-widest">
                        Transparan</div>
                </div>
            </div>
        </div>
        {{-- LAYANAN SECTION --}}
        <section id="layanan" class="pt-32 pb-20 bg-gray-50 dark:bg-gray-950">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
                    <div class="max-w-2xl">
                        <h2 class="text-3xl md:text-4xl font-black text-gray-900 dark:text-white mb-4">Layanan
                            Administrasi Digital</h2>
                        <p class="text-gray-600 dark:text-gray-400 text-lg">Warga dapat mengajukan berbagai jenis surat
                            keterangan dengan mudah tanpa perlu antre di kantor desa.</p>
                    </div>
                    <a href="{{ route('public.layanan') }}"
                        class="inline-flex items-center gap-2 text-blue-600 font-bold hover:underline">
                        Semua Layanan
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($layanan as $item)
                        <div
                            class="group bg-white dark:bg-gray-900 p-8 rounded-3xl border border-gray-100 dark:border-gray-800 hover:border-blue-500 transition-all duration-300 shadow-sm hover:shadow-xl hover:-translate-y-1">
                            <div
                                class="w-14 h-14 bg-blue-50 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center text-blue-600 mb-6 group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $item->nama }}</h3>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mb-6">
                                {{ Str::limit($item->deskripsi, 100) }}</p>
                            <a href="{{ Auth::check() && Auth::user()->role === 'masyarakat' ? route('masyarakat.pengajuan.create', ['jenis_surat' => $item->kode]) : route('auth.phone') }}"
                                class="inline-flex items-center gap-2 text-sm font-bold text-blue-600 group-hover:gap-3 transition-all">
                                Pilih Layanan
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- INFORMASI SECTION --}}
        <section id="informasi"
            class="py-20 bg-white dark:bg-gray-900 rounded-t-[3rem] shadow-[0_-20px_50px_-20px_rgba(0,0,0,0.1)]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-black text-gray-900 dark:text-white mb-4">Warta Desa &
                            Pengumuman</h2>
                        <p class="text-gray-600 dark:text-gray-400 text-lg">Informasi terkini seputar program kerja dan
                            berita terbaru dari {{ $profil->nama_desa }}.</p>
                    </div>
                    <a href="{{ route('public.informasi') }}"
                        class="inline-flex items-center gap-2 text-blue-600 font-bold hover:underline">
                        Lihat Semua Berita
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($berita as $post)
                        <article
                            class="flex flex-col bg-gray-50 dark:bg-gray-800 rounded-3xl overflow-hidden group border border-gray-100 dark:border-gray-700 hover:shadow-2xl transition-all h-full">
                            <div class="relative aspect-video overflow-hidden">
                                @if ($post->thumbnail)
                                    <img src="{{ asset('storage/' . $post->thumbnail) }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                        alt="{{ $post->judul }}">
                                @endif
                                <div class="absolute top-4 left-4">
                                    <span
                                        class="px-3 py-1 bg-white/90 backdrop-blur rounded-lg text-xs font-black uppercase text-blue-700 tracking-tighter shadow-sm">
                                        {{ $post->kategori }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-8 flex flex-col flex-1">
                                <div class="text-gray-400 text-xs font-bold mb-3 uppercase tracking-widest">
                                    {{ $post->published_at->translatedFormat('d F Y') }}</div>
                                <h3
                                    class="text-xl font-bold text-gray-900 dark:text-white mb-4 group-hover:text-blue-600 transition-colors line-clamp-2">
                                    <a
                                        href="{{ route('public.informasi.show', $post->slug) }}">{{ $post->judul }}</a>
                                </h3>
                                <div class="mt-auto">
                                    <a href="{{ route('public.informasi.show', $post->slug) }}"
                                        class="inline-flex items-center gap-2 text-sm font-bold text-gray-900 dark:text-white hover:text-blue-600 transition-colors">
                                        Baca Artikel
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
            <script>
                new Swiper('.hero-swiper', {
                    loop: true,
                    autoplay: {
                        delay: 7000,
                        disableOnInteraction: false,
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    effect: 'fade',
                    fadeEffect: {
                        crossFade: true
                    },
                });
            </script>
        @endpush
</x-public-layout>
