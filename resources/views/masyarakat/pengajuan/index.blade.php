<x-public-layout>
    @section('title', 'Layanan Pengajuan Surat')

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header Section --}}
            <div class="mb-10 text-center md:text-left">
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
                    Layanan Pengajuan Surat
                </h1>
                <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">
                    Pilih jenis surat yang ingin Anda ajukan. Proses cepat, mudah, dan transparan.
                </p>
            </div>

            @if($activeSubmissions->count() > 0)
            {{-- Active Submissions Alert --}}
            <div class="mb-10 bg-blue-50 dark:bg-blue-900/20 rounded-2xl p-6 border border-blue-100 dark:border-blue-800 shadow-sm">
                <div class="flex items-center gap-4 mb-4">
                    <div class="p-2 bg-blue-100 dark:bg-blue-800 rounded-lg text-blue-600 dark:text-blue-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white">Pengajuan Sedang Diproses</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Anda memiliki {{ $activeSubmissions->count() }} pengajuan yang masih dalam proses.</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($activeSubmissions as $sub)
                    <div class="bg-white dark:bg-gray-800 p-4 rounded-xl border border-gray-100 dark:border-gray-700 shadow-xs flex justify-between items-center transition-transform hover:scale-[1.02]">
                        <div>
                            <div class="text-xs font-semibold text-blue-600 dark:text-blue-400 uppercase tracking-wider mb-1">{{ $sub->kode_pengajuan }}</div>
                            <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $sub->jenisSurat->nama }}</div>
                        </div>
                        <div class="px-3 py-1 bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-400 text-xs font-bold rounded-full uppercase">
                            {{ str_replace('_', ' ', $sub->status) }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Grid Jenis Surat --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($layanan as $item)
                <div class="group relative bg-white dark:bg-gray-900 rounded-3xl p-8 border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-xl hover:border-blue-500/30 transition-all duration-300 overflow-hidden flex flex-col justify-between">
                    {{-- Decorative Background --}}
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-blue-50 dark:bg-blue-900/10 rounded-full blur-3xl group-hover:bg-blue-100 dark:group-hover:bg-blue-900/20 transition-colors"></div>
                    
                    <div>
                        <div class="inline-flex items-center justify-center p-3 mb-6 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl shadow-lg ring-4 ring-blue-50 dark:ring-blue-900/20 transition-transform group-hover:scale-110">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>

                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 tracking-tight">{{ $item->nama }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed mb-6">{{ $item->deskripsi ?? 'Ajukan surat keterangan '.strtolower($item->nama).' melalui portal SIAPS.' }}</p>

                        <div class="flex flex-wrap gap-2 mb-8">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 ring-1 ring-inset ring-green-600/20">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"/></svg>
                                SLA: {{ $item->sla_hari }} Hari
                            </span>
                            @if($item->requires_verification)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-400">
                                Wajib Verif Biodata
                            </span>
                            @endif
                        </div>
                    </div>

                    <a href="{{ route('masyarakat.pengajuan.create', $item->kode) }}" 
                        class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-bold rounded-2xl text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all shadow-md active:scale-95">
                        Mulai Pengajuan
                        <svg class="ml-2 -mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-public-layout>
