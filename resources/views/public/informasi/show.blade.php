<x-public-layout>
    @section('title', $artikel->judul)

    <article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-20">
        {{-- Back --}}
        <a href="{{ route('public.informasi') }}"
            class="inline-flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400 mb-8 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Informasi
        </a>

        {{-- Category badge --}}
        <div class="flex items-center gap-3 mb-4">
            <span
                class="px-3 py-1 bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400 text-sm font-semibold rounded-full">{{ $artikel->kategori_label }}</span>
            @if ($artikel->is_pinned)
                <span class="flex items-center gap-1.5 text-yellow-600 dark:text-yellow-400 text-sm font-medium">
                    <x-icon name="pin" class="w-4 h-4 fill-yellow-500" /> Dipin
                </span>
            @endif
        </div>

        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white leading-tight mb-6">
            {{ $artikel->judul }}</h1>

        <div
            class="flex items-center gap-6 text-sm text-gray-500 dark:text-gray-400 mb-8 pb-6 border-b border-gray-100 dark:border-gray-800">
            <span class="flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                        clip-rule="evenodd" />
                </svg>
                {{ $artikel->published_at?->format('d F Y') }}
            </span>
            <span class="flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                    <path fill-rule="evenodd"
                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                        clip-rule="evenodd" />
                </svg>
                {{ number_format($artikel->view_count) }} dilihat
            </span>
            @if ($artikel->penulis)
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ $artikel->penulis->name }}
                </span>
            @endif
        </div>

        @if ($artikel->thumbnail)
            <div class="rounded-2xl overflow-hidden mb-8 shadow-lg">
                <img src="{{ asset('storage/' . $artikel->thumbnail) }}" alt="{{ $artikel->judul }}"
                    class="w-full max-h-96 object-cover">
            </div>
        @endif

        <div
            class="prose prose-lg dark:prose-invert max-w-none prose-headings:font-bold prose-a:text-green-600 dark:prose-a:text-green-400">
            {!! nl2br(e($artikel->konten)) !!}
        </div>

        {{-- Related --}}
        @if ($related->count() > 0)
            <div class="mt-16 pt-10 border-t border-gray-100 dark:border-gray-800">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Informasi Terkait</h2>
                <div class="grid sm:grid-cols-3 gap-4">
                    @foreach ($related as $r)
                        <a href="{{ route('public.informasi.show', $r->slug) }}"
                            class="group bg-white dark:bg-gray-900 rounded-xl p-4 border border-gray-100 dark:border-gray-800 hover:border-green-200 dark:hover:border-green-700 hover:shadow-md transition-all">
                            <p
                                class="text-sm font-semibold text-gray-900 dark:text-white group-hover:text-green-600 dark:group-hover:text-green-400 line-clamp-2 mb-1">
                                {{ $r->judul }}</p>
                            <p class="text-xs text-gray-400">{{ $r->published_at?->format('d M Y') }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </article>
</x-public-layout>
