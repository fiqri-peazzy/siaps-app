<x-public-layout>
    @section('title', 'Profil Desa')

    {{-- Header Banner --}}
    <section class="relative bg-blue-700 py-24 px-4 overflow-hidden">
        <div class="absolute inset-0 opacity-10"
            style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.4\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
        </div>
        <div class="relative max-w-7xl mx-auto text-center">
            <h1 class="text-4xl md:text-6xl font-black text-white mb-6">Profil {{ $profil->nama_desa ?? 'Desa' }}</h1>
            <p class="text-blue-100 text-lg max-w-3xl mx-auto font-medium">
                {{ $profil->kecamatan ? 'Kecamatan ' . $profil->kecamatan . ', ' . $profil->kabupaten . ', ' . $profil->provinsi : 'Mengenal lebih dekat sejarah, visi, dan misi desa kami.' }}
            </p>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="grid lg:grid-cols-12 gap-12">
            {{-- Left: Info Singkat --}}
            <div class="lg:col-span-4 space-y-8">
                <div
                    class="bg-white dark:bg-gray-900 rounded-[2.5rem] p-10 border border-gray-100 dark:border-gray-800 shadow-xl shadow-gray-200/50 dark:shadow-none sticky top-24">
                    <div class="relative mb-8 text-center">
                        @if ($profil->logo_path)
                            <div class="relative inline-block">
                                <img src="{{ asset('storage/' . $profil->logo_path) }}" alt="Logo Desa"
                                    class="w-32 h-32 rounded-[2rem] object-cover mx-auto border-8 border-blue-50 dark:border-blue-900/30 shadow-lg">
                                <div
                                    class="absolute -bottom-2 -right-2 w-10 h-10 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                        @else
                            <div
                                class="w-32 h-32 rounded-[2rem] bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center mx-auto shadow-xl">
                                <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                            </div>
                        @endif
                        <h2 class="text-2xl font-black text-gray-900 dark:text-white mt-6 mb-1">
                            {{ $profil->nama_desa ?? 'Desa Kami' }}</h2>
                        @if ($profil->kode_desa)
                            <p class="text-sm font-bold text-blue-600 tracking-widest uppercase">KODE:
                                {{ $profil->kode_desa }}</p>
                        @endif
                    </div>

                    <div class="space-y-6 pt-8 border-t border-gray-100 dark:border-gray-800">
                        @if ($profil->alamat_kantor)
                            <div class="flex gap-4 items-start">
                                <div
                                    class="w-10 h-10 rounded-xl bg-gray-50 dark:bg-gray-800 flex items-center justify-center text-gray-400 shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-0.5">
                                        Alamat Kantor</p>
                                    <p class="text-sm font-bold text-gray-700 dark:text-gray-300 leading-snug">
                                        {{ $profil->alamat_kantor }}</p>
                                </div>
                            </div>
                        @endif
                        @if ($profil->telepon)
                            <div class="flex gap-4 items-start">
                                <div
                                    class="w-10 h-10 rounded-xl bg-gray-50 dark:bg-gray-800 flex items-center justify-center text-gray-400 shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-0.5">
                                        Telepon</p>
                                    <p class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ $profil->telepon }}
                                    </p>
                                </div>
                            </div>
                        @endif
                        @if ($profil->email)
                            <div class="flex gap-4 items-start">
                                <div
                                    class="w-10 h-10 rounded-xl bg-gray-50 dark:bg-gray-800 flex items-center justify-center text-gray-400 shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-0.5">
                                        Email Resmi</p>
                                    <p class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ $profil->email }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Statistik --}}
                @if ($profil->luas_wilayah || $profil->jumlah_penduduk)
                    <div class="bg-gray-900 rounded-[2.5rem] p-10 text-white shadow-2xl relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-4 opacity-10">
                            <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-black mb-8 border-b border-white/10 pb-4">Statistik Wilayah</h3>
                        <div class="space-y-8">
                            @if ($profil->luas_wilayah)
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-500 mb-1">Luas
                                        Wilayah</p>
                                    <p class="text-3xl font-black">{{ number_format($profil->luas_wilayah, 2) }} <span
                                            class="text-sm font-bold text-blue-400">km²</span></p>
                                </div>
                            @endif
                            @if ($profil->jumlah_penduduk)
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-500 mb-1">Total
                                        Populasi</p>
                                    <p class="text-3xl font-black">{{ number_format($profil->jumlah_penduduk) }} <span
                                            class="text-sm font-bold text-blue-400">Jiwa</span></p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            {{-- Right: Content --}}
            <div class="lg:col-span-8 space-y-12">
                @if ($profil->visi)
                    <section class="relative">
                        <div class="absolute -top-6 -left-6 text-blue-100 dark:text-blue-900/40">
                            <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H16.017C14.9124 8 14.017 7.10457 14.017 6V5C14.017 4.44772 14.4647 4 15.017 4H21.017C21.5693 4 22.017 4.44772 22.017 5V15C22.017 18.3137 19.3307 21 16.017 21H14.017ZM2.017 21L2.017 18C2.017 16.8954 2.91239 16 4.017 16H7.017C7.56928 16 8.017 15.5523 8.017 15V9C8.017 8.44772 7.56928 8 7.017 8H4.017C2.91239 8 2.017 7.10457 2.017 6V5C2.017 4.44772 2.46472 4 3.017 4H9.017C9.56928 4 10.017 4.44772 10.017 5V15C10.017 18.3137 7.33072 21 4.017 21H2.017Z">
                                </path>
                            </svg>
                        </div>
                        <div
                            class="bg-blue-600 rounded-[3rem] p-12 shadow-2xl shadow-blue-500/30 relative overflow-hidden group">
                            <div
                                class="absolute top-0 right-0 p-8 text-blue-500/20 group-hover:scale-110 transition-transform">
                                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M13 3h-2v10h2V3zm4.83 2.17l-1.42 1.42C17.99 7.86 19 9.81 19 12c0 3.87-3.13 7-7 7s-7-3.13-7-7c0-2.19 1.01-4.14 2.58-5.42L6.17 5.17C4.23 6.82 3 9.26 3 12c0 4.97 4.03 9 9 9s9-4.03 9-9c0-2.74-1.23-5.18-3.17-6.83z" />
                                </svg>
                            </div>
                            <h3 class="text-blue-200 text-xs font-black uppercase tracking-[0.3em] mb-6">Visi Desa Kami
                            </h3>
                            <p class="text-white text-2xl md:text-3xl font-black leading-tight italic">
                                "{{ $profil->visi }}"
                            </p>
                        </div>
                    </section>
                @endif

                @if ($profil->misi)
                    <div
                        class="bg-white dark:bg-gray-900 rounded-[3rem] p-12 border border-gray-100 dark:border-gray-800 shadow-sm relative">
                        <h3 class="text-gray-900 dark:text-white text-2xl font-black mb-10 flex items-center gap-4">
                            <div
                                class="w-12 h-12 bg-indigo-50 dark:bg-indigo-900/30 rounded-2xl flex items-center justify-center text-indigo-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 2v6h6"></path>
                                </svg>
                            </div>
                            Misi & Program Kerja
                        </h3>
                        <div
                            class="prose prose-lg dark:prose-invert max-w-none 
                            prose-p:text-gray-600 dark:prose-p:text-gray-400 prose-p:leading-relaxed
                            prose-li:text-gray-600 dark:prose-li:text-gray-400 font-medium">
                            {!! nl2br(e($profil->misi)) !!}
                        </div>
                    </div>
                @endif

                @if ($profil->sejarah)
                    <div
                        class="bg-white dark:bg-gray-900 rounded-[3rem] p-12 border border-gray-100 dark:border-gray-800 shadow-sm">
                        <h3 class="text-gray-900 dark:text-white text-2xl font-black mb-8">Sejarah Singkat</h3>
                        <div class="prose prose-lg dark:prose-invert max-w-none text-gray-600 dark:text-gray-400">
                            {!! $profil->sejarah !!}
                        </div>
                    </div>
                @endif

                @if (!$profil->visi && !$profil->misi)
                    <div
                        class="bg-gray-50 dark:bg-gray-800/50 rounded-[3rem] p-20 text-center border-2 border-dashed border-gray-200 dark:border-gray-700">
                        <div
                            class="w-20 h-20 bg-white dark:bg-gray-800 rounded-3xl flex items-center justify-center mx-auto mb-6 text-gray-300">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-400">Informasi profil belum dilengkapi oleh admin.</h3>
                    </div>
                @endif
            </div>
        </div>
    </section>
</x-public-layout>
</x-public-layout>
