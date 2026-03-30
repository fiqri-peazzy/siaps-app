<x-public-layout>
    @section('title', 'Layanan Surat')

    <section class="relative bg-blue-700 py-24 px-4 overflow-hidden">
        <div class="absolute inset-0 opacity-10"
            style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.4\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
        </div>
        <div class="relative max-w-7xl mx-auto text-center">
            <h1 class="text-4xl md:text-6xl font-black text-white mb-6">Layanan Administrasi Digital</h1>
            <p class="text-blue-100 text-lg max-w-2xl mx-auto font-medium">Pilih jenis layanan surat yang Anda butuhkan.
                Proses pengajuan dilakukan secara online, cepat, dan transparan.</p>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        @if ($layanan->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @php $icons = ['file-text', 'clipboard-list', 'files', 'home', 'baby', 'heart', 'scroll', 'folder-kanban', 'hospital', 'briefcase', 'graduation-cap', 'scale']; @endphp
                @foreach ($layanan as $i => $s)
                    <div
                        class="group bg-white dark:bg-gray-900 rounded-[2.5rem] p-10 border border-gray-100 dark:border-gray-800 hover:border-blue-500 transition-all duration-300 shadow-sm hover:shadow-2xl hover:-translate-y-2 flex flex-col h-full">
                        <div class="flex items-start justify-between mb-8">
                            <div
                                class="w-16 h-16 bg-blue-50 dark:bg-blue-900/30 rounded-[1.25rem] flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform duration-300">
                                <x-icon name="{{ $icons[$i % count($icons)] }}" class="w-8 h-8" />
                            </div>
                            <span
                                class="text-[10px] font-black bg-gray-50 dark:bg-gray-800 text-gray-400 dark:text-gray-500 px-3 py-1 rounded-lg uppercase tracking-widest border border-gray-100 dark:border-gray-700">{{ $s->kode }}</span>
                        </div>

                        <h3
                            class="text-2xl font-black text-gray-900 dark:text-white mb-4 group-hover:text-blue-600 transition-colors tracking-tight">
                            {{ $s->nama }}</h3>

                        @if ($s->deskripsi)
                            <p class="text-gray-500 dark:text-gray-400 text-sm mb-8 leading-relaxed line-clamp-3">
                                {{ $s->deskripsi }}</p>
                        @endif

                        <div class="mt-auto space-y-4 pt-8 border-t border-gray-50 dark:border-gray-800">
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">Estimasi
                                    Waktu</span>
                                <span class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $s->sla_hari }} Hari Kerja
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">Verifikasi
                                    Berkas</span>
                                <span
                                    class="text-sm font-bold {{ $s->requires_verification ? 'text-amber-500' : 'text-green-500' }} flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $s->requires_verification ? 'Diperlukan' : 'Otomatis' }}
                                </span>
                            </div>
                        </div>

                        <a href="{{ Auth::check() && Auth::user()->role === 'masyarakat' ? route('masyarakat.pengajuan.create', $s->kode) : route('auth.phone') }}"
                            class="mt-8 block w-full text-center py-4 px-6 bg-blue-600 hover:bg-blue-700 text-white text-sm font-black rounded-2xl transition-all shadow-lg shadow-blue-500/20 hover:shadow-blue-500/40 hover:-translate-y-0.5 uppercase tracking-widest">
                            Ajukan Sekarang
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div
                class="text-center py-32 bg-gray-50 dark:bg-gray-900/50 rounded-[3rem] border border-dashed border-gray-200 dark:border-gray-800">
                <div
                    class="w-24 h-24 bg-white dark:bg-gray-800 rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-sm text-gray-300">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                        </path>
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-2">Belum ada layanan tersedia</h3>
                <p class="text-gray-500 dark:text-gray-400">Hubungi admin desa untuk informasi lebih lanjut mengenai
                    ketersediaan layanan digital.</p>
            </div>
        @endif
    </section>
</x-public-layout>
