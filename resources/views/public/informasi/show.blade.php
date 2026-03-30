<x-public-layout>
    @section('title', $artikel->judul)

    <article class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-24">
        {{-- Breadcrumb --}}
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3 text-sm font-medium">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-blue-600 dark:text-gray-400">Beranda</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                        <a href="{{ route('public.informasi') }}"
                            class="text-gray-500 hover:text-blue-600 dark:text-gray-400">Informasi</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                        <span
                            class="text-gray-400 dark:text-gray-500 truncate max-w-[200px]">{{ $artikel->judul }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <header class="mb-10">
            <div class="flex flex-wrap items-center gap-3 mb-6">
                <span
                    class="px-4 py-1.5 bg-blue-600 text-white text-xs font-black rounded-lg uppercase tracking-widest shadow-lg shadow-blue-500/20">
                    {{ $artikel->kategori_label }}
                </span>
                @if ($artikel->is_pinned)
                    <span
                        class="flex items-center gap-1.5 px-3 py-1.5 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 text-xs font-bold rounded-lg border border-yellow-200 dark:border-yellow-800">
                        📌 Tersemat
                    </span>
                @endif
            </div>

            <h1 class="text-3xl md:text-5xl font-black text-gray-900 dark:text-white leading-[1.15] mb-8">
                {{ $artikel->judul }}
            </h1>

            <div
                class="flex flex-wrap items-center gap-y-4 gap-x-8 text-sm text-gray-500 dark:text-gray-400 border-y border-gray-100 dark:border-gray-800 py-6">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-full bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Penulis</p>
                        <p class="font-bold text-gray-900 dark:text-white">{{ $artikel->penulis->name }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-full bg-gray-50 dark:bg-gray-800 flex items-center justify-center text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Tanggal Terbit</p>
                        <p class="font-bold text-gray-900 dark:text-white">
                            {{ $artikel->published_at->translatedFormat('d F Y') }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-full bg-gray-50 dark:bg-gray-800 flex items-center justify-center text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Dilihat</p>
                        <p class="font-bold text-gray-900 dark:text-white">{{ number_format($artikel->view_count) }}
                            Kali</p>
                    </div>
                </div>
            </div>
        </header>

        @if ($artikel->thumbnail)
            <div class="rounded-[2.5rem] overflow-hidden mb-12 shadow-2xl border border-gray-100 dark:border-gray-800">
                <img src="{{ asset('storage/' . $artikel->thumbnail) }}" alt="{{ $artikel->judul }}"
                    class="w-full max-h-[500px] object-cover">
            </div>
        @endif

        <div class="grid lg:grid-cols-4 gap-12">
            <div class="lg:col-span-3">
                <div
                    class="prose prose-lg dark:prose-invert max-w-none 
                    prose-headings:text-gray-900 dark:prose-headings:text-white prose-headings:font-black
                    prose-p:text-gray-600 dark:prose-p:text-gray-400 prose-p:leading-relaxed
                    prose-a:text-blue-600 dark:prose-a:text-blue-400 prose-a:no-underline hover:prose-a:underline
                    prose-img:rounded-3xl prose-img:shadow-xl prose-img:border prose-img:border-gray-100 dark:prose-img:border-gray-800">
                    {!! $artikel->konten !!}
                </div>

                {{-- Gallery Section --}}
                @if (!empty($artikel->gallery))
                    <div class="mt-16 pt-12 border-t border-gray-100 dark:border-gray-800">
                        <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-8 flex items-center gap-3">
                            <span
                                class="w-8 h-8 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </span>
                            Galeri Foto
                        </h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-6">
                            @foreach ($artikel->gallery as $img)
                                <a href="{{ asset('storage/' . $img) }}" target="_blank"
                                    class="block aspect-square rounded-3xl overflow-hidden group border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-xl transition-all">
                                    <img src="{{ asset('storage/' . $img) }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                        alt="Gallery">
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="lg:col-span-1">
                {{-- Tags --}}
                @if ($artikel->tags)
                    <div class="mb-10">
                        <h4 class="text-xs font-black uppercase tracking-widest text-gray-400 mb-6">Tags Artikel</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach (explode(',', $artikel->tags) as $tag)
                                <span
                                    class="px-3 py-1.5 bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-xs font-bold rounded-xl border border-gray-100 dark:border-gray-700">
                                    #{{ trim($tag) }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Related --}}
                @if ($related->count() > 0)
                    <div class="sticky top-24">
                        <h4 class="text-xs font-black uppercase tracking-widest text-gray-400 mb-6">Informasi Terkait
                        </h4>
                        <div class="space-y-6">
                            @foreach ($related as $r)
                                <a href="{{ route('public.informasi.show', $r->slug) }}" class="group block">
                                    @if ($r->thumbnail)
                                        <div class="aspect-video rounded-2xl overflow-hidden mb-3">
                                            <img src="{{ asset('storage/' . $r->thumbnail) }}"
                                                class="w-full h-full object-cover group-hover:scale-110 transition-transform"
                                                alt="Related">
                                        </div>
                                    @endif
                                    <p
                                        class="text-sm font-bold text-gray-900 dark:text-white group-hover:text-blue-600 transition-colors line-clamp-2 mb-1">
                                        {{ $r->judul }}</p>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                        {{ $r->published_at?->translatedFormat('d M Y') }}</p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </article>
</x-public-layout>
