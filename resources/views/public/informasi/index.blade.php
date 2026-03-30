<x-public-layout>
    @section('title', 'Informasi Desa')

    <section class="relative bg-blue-700 py-24 px-4 overflow-hidden">
        <div class="absolute inset-0 opacity-10"
            style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.4\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
        </div>
        <div class="relative max-w-7xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-black text-white mb-6 tracking-tight">Warta Desa & Pengumuman</h1>
            <p class="text-blue-100 text-lg max-w-2xl mx-auto">Pantau terus perkembangan, pengumuman, dan berita terbaru
                dari {{ $profil->nama_desa ?? 'desa kami' }}.</p>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        {{-- Filter tabs --}}
        <div class="flex flex-wrap items-center gap-3 mb-12 pb-8 border-b border-gray-100 dark:border-gray-800">
            <span class="text-xs font-black uppercase tracking-widest text-gray-400 mr-2">Kategori:</span>
            @php
                $tabs = [
                    null => 'Semua Berita',
                    'pengumuman' => 'Pengumuman',
                    'berita' => 'Berita Utama',
                    'agenda' => 'Agenda Desa',
                ];
            @endphp
            @foreach ($tabs as $key => $label)
                <a href="{{ route('public.informasi', $key ? ['kategori' => $key] : []) }}"
                    class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all
               {{ $kategori === $key ? 'bg-blue-600 text-white shadow-xl shadow-blue-500/20' : 'bg-white dark:bg-gray-900 text-gray-500 dark:text-gray-400 border border-gray-100 dark:border-gray-800 hover:border-blue-300 hover:text-blue-600' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        @if ($berita->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($berita as $artikel)
                    <article
                        class="flex flex-col bg-white dark:bg-gray-900 rounded-[2.5rem] overflow-hidden group border border-gray-100 dark:border-gray-800 hover:shadow-2xl transition-all h-full">
                        <div class="relative aspect-[16/10] overflow-hidden">
                            @if ($artikel->thumbnail)
                                <img src="{{ asset('storage/' . $artikel->thumbnail) }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                    alt="{{ $artikel->judul }}">
                            @else
                                <div
                                    class="w-full h-full bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-blue-900/20 dark:to-indigo-900/20 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-blue-200 dark:text-blue-800" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                            d="M14 2v6h6"></path>
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4">
                                <span
                                    class="px-3 py-1 bg-white/90 backdrop-blur rounded-lg text-xs font-black uppercase text-blue-700 tracking-tighter shadow-sm">
                                    {{ $artikel->kategori_label }}
                                </span>
                            </div>
                        </div>
                        <div class="p-8 flex flex-col flex-1">
                            <div class="text-gray-400 text-[10px] font-bold mb-3 uppercase tracking-widest">
                                {{ $artikel->published_at?->translatedFormat('d F Y') }}</div>
                            <h3
                                class="text-xl font-bold text-gray-900 dark:text-white mb-6 group-hover:text-blue-600 transition-colors line-clamp-2 leading-snug">
                                <a href="{{ route('public.informasi.show', $artikel->slug) }}">{{ $artikel->judul }}</a>
                            </h3>
                            <div class="mt-auto pt-6 border-t border-gray-50 dark:border-gray-800">
                                <a href="{{ route('public.informasi.show', $artikel->slug) }}"
                                    class="inline-flex items-center gap-2 text-sm font-bold text-gray-900 dark:text-white hover:text-blue-600 transition-colors">
                                    Selengkapnya
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
            <div class="mt-16">{{ $berita->links() }}</div>
        @else
            <div
                class="text-center py-32 bg-gray-50 dark:bg-gray-900/50 rounded-[3rem] border border-dashed border-gray-200 dark:border-gray-800">
                <div
                    class="w-20 h-20 bg-white dark:bg-gray-800 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-sm text-gray-300">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                        </path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Belum ada warta desa</h3>
                <p class="text-gray-500 dark:text-gray-400">Informasi akan segera diperbarui oleh tim admin desa.</p>
            </div>
        @endif
    </section>
</x-public-layout>
