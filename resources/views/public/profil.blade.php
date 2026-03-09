<x-public-layout>
    @section('title', 'Profil Desa')

    {{-- Header Banner --}}
    <section class="bg-gradient-to-r from-blue-700 to-indigo-800 py-16 px-4">
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-3">Profil {{ $profil->nama_desa ?? 'Desa' }}
            </h1>
            <p class="text-blue-200">
                {{ $profil->kecamatan ? 'Kec. ' . $profil->kecamatan . ', ' . $profil->kabupaten . ', ' . $profil->provinsi : 'Informasi & Sejarah Desa' }}
            </p>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid lg:grid-cols-3 gap-10">
            {{-- Left: Info Singkat --}}
            <div class="space-y-6">
                <div
                    class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-100 dark:border-gray-800 shadow-sm">
                    @if ($profil->logo_path)
                        <img src="{{ asset('storage/' . $profil->logo_path) }}" alt="Logo Desa"
                            class="w-24 h-24 rounded-full object-cover mx-auto mb-4 border-4 border-blue-100">
                    @else
                        <div
                            class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                            </svg>
                        </div>
                    @endif
                    <h2 class="text-xl font-bold text-center text-gray-900 dark:text-white mb-1">
                        {{ $profil->nama_desa ?? 'Desa Kami' }}</h2>
                    @if ($profil->kode_desa)
                        <p class="text-center text-sm text-gray-500 dark:text-gray-400 mb-4">Kode:
                            {{ $profil->kode_desa }}</p>
                    @endif

                    <div class="space-y-3 pt-4 border-t border-gray-100 dark:border-gray-800">
                        @if ($profil->alamat_kantor)
                            <div class="flex gap-3 text-sm"><x-icon name="map-pin"
                                    class="text-blue-500 w-4 h-4 mt-0.5" /><span
                                    class="text-gray-600 dark:text-gray-400">{{ $profil->alamat_kantor }}</span></div>
                        @endif
                        @if ($profil->telepon)
                            <div class="flex gap-3 text-sm"><x-icon name="phone" class="text-blue-500 w-4 h-4" /><span
                                    class="text-gray-600 dark:text-gray-400">{{ $profil->telepon }}</span></div>
                        @endif
                        @if ($profil->email)
                            <div class="flex gap-3 text-sm"><x-icon name="mail" class="text-blue-500 w-4 h-4" /><span
                                    class="text-gray-600 dark:text-gray-400">{{ $profil->email }}</span></div>
                        @endif
                        @if ($profil->website)
                            <div class="flex gap-3 text-sm"><x-icon name="globe" class="text-blue-500 w-4 h-4" /><a
                                    href="{{ $profil->website }}"
                                    class="text-blue-600 hover:underline">{{ $profil->website }}</a></div>
                        @endif
                    </div>
                </div>

                {{-- Statistik --}}
                @if ($profil->luas_wilayah || $profil->jumlah_penduduk)
                    <div
                        class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-100 dark:border-gray-800 shadow-sm">
                        <h3 class="font-bold text-gray-900 dark:text-white mb-4">Statistik Desa</h3>
                        @if ($profil->luas_wilayah)
                            <div class="flex justify-between py-2 border-b border-gray-50 dark:border-gray-800">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Luas Wilayah</span>
                                <span
                                    class="text-sm font-semibold text-gray-900 dark:text-white">{{ number_format($profil->luas_wilayah, 2) }}
                                    km²</span>
                            </div>
                        @endif
                        @if ($profil->jumlah_penduduk)
                            <div class="flex justify-between py-2">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Jumlah Penduduk</span>
                                <span
                                    class="text-sm font-semibold text-gray-900 dark:text-white">{{ number_format($profil->jumlah_penduduk) }}
                                    jiwa</span>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Right: Visi Misi --}}
            <div class="lg:col-span-2 space-y-8">
                @if ($profil->visi)
                    <div
                        class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl p-8 border border-blue-100 dark:border-blue-800">
                        <h3 class="text-xl font-bold text-blue-800 dark:text-blue-300 mb-4 flex items-center gap-2">
                            <x-icon name="target" class="w-6 h-6" /> Visi
                        </h3>
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed italic text-lg">
                            "{{ $profil->visi }}"</p>
                    </div>
                @endif

                @if ($profil->misi)
                    <div
                        class="bg-white dark:bg-gray-900 rounded-2xl p-8 border border-gray-100 dark:border-gray-800 shadow-sm">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <x-icon name="rocket" class="w-6 h-6 text-indigo-500" /> Misi
                        </h3>
                        <div
                            class="prose prose-sm dark:prose-invert max-w-none text-gray-600 dark:text-gray-400 leading-relaxed">
                            {!! nl2br(e($profil->misi)) !!}
                        </div>
                    </div>
                @endif

                @if (!$profil->visi && !$profil->misi)
                    <div
                        class="bg-gray-50 dark:bg-gray-900 rounded-2xl p-12 text-center border border-dashed border-gray-200 dark:border-gray-700">
                        <p class="text-gray-400">Profil desa belum dilengkapi. Admin dapat mengisi informasi ini melalui
                            panel administrasi.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
</x-public-layout>
