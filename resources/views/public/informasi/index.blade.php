<x-public-layout>
    @section('title', 'Informasi Desa')

    <section class="bg-gradient-to-r from-green-700 to-teal-800 py-16 px-4">
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-3">Informasi & Berita Desa</h1>
            <p class="text-green-200">Pengumuman, berita, dan informasi terkini dari
                {{ $profil->nama_desa ?? 'desa kami' }}</p>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        {{-- Filter tabs --}}
        <div class="flex flex-wrap gap-2 mb-8">
            @php
                $tabs = [
                    null => 'Semua',
                    'pengumuman' => 'Pengumuman',
                    'berita' => 'Berita',
                    'agenda' => 'Agenda',
                    'layanan' => 'Layanan',
                ];
            @endphp
            @foreach ($tabs as $key => $label)
                <a href="{{ route('public.informasi', $key ? ['kategori' => $key] : []) }}"
                    class="px-4 py-2 rounded-full text-sm font-semibold transition-colors
               {{ $kategori === $key ? 'bg-green-600 text-white shadow-md' : 'bg-white dark:bg-gray-900 text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-gray-700 hover:border-green-300 hover:text-green-600' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        @if ($berita->count() > 0)
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($berita as $artikel)
                    <article
                        class="group bg-white dark:bg-gray-900 rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-800 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                        @if ($artikel->thumbnail)
                            <div class="aspect-video overflow-hidden"><img
                                    src="{{ asset('storage/' . $artikel->thumbnail) }}" alt="{{ $artikel->judul }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </div>
                        @else
                            <div
                                class="aspect-video bg-gradient-to-br from-green-100 to-teal-100 dark:from-green-900/30 dark:to-teal-900/30 flex items-center justify-center">
                                <span
                                    class="text-5xl">{{ match ($artikel->kategori) {'pengumuman' => '📢','agenda' => '📅','layanan' => '🗂️',default => '📰'} }}</span>
                            </div>
                        @endif
                        <div class="p-5">
                            <div class="flex items-center gap-2 mb-3">
                                <span
                                    class="px-2.5 py-1 text-xs font-semibold rounded-full
                            {{ match ($artikel->kategori) {'pengumuman' => 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400','berita' => 'bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400','agenda' => 'bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400',default => 'bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-400'} }}">{{ $artikel->kategori_label }}</span>
                                @if ($artikel->is_pinned)
                                    <span class="text-yellow-500 text-xs">📌</span>
                                @endif
                            </div>
                            <h3
                                class="font-bold text-gray-900 dark:text-white mb-2 group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors line-clamp-2">
                                {{ $artikel->judul }}</h3>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mb-4">
                                {{ $artikel->published_at?->format('d M Y') }}</p>
                            <a href="{{ route('public.informasi.show', $artikel->slug) }}"
                                class="text-sm font-semibold text-green-600 dark:text-green-400 hover:underline">Baca
                                selengkapnya →</a>
                        </div>
                    </article>
                @endforeach
            </div>
            <div class="mt-10">{{ $berita->links() }}</div>
        @else
            <div class="text-center py-20">
                <p class="text-5xl mb-4">📭</p>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Belum ada informasi</h3>
                <p class="text-gray-500 dark:text-gray-400">Informasi akan segera ditambahkan oleh admin.</p>
            </div>
        @endif
    </section>
</x-public-layout>
