<x-public-layout>
    @section('title', 'Detail Pengajuan ' . $pengajuan->kode_pengajuan)

    <div class="py-12 bg-gray-50/50 dark:bg-gray-950/50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header & Progress --}}
            <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <a href="{{ route('masyarakat.pengajuan.index') }}"
                        class="inline-flex items-center text-sm font-bold text-blue-600 hover:text-blue-700 transition-colors mb-2">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Kembali ke Daftar Layanan
                    </a>
                    <h1 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight uppercase">Detail
                        Pengajuan Surat</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">ID: {{ $pengajuan->kode_pengajuan }}
                    </p>
                </div>
                <div>
                    @php
                        $statusColors = [
                            'submitted' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-400',
                            'in_process' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-400',
                            'approved' => 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-400',
                            'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-400',
                            'ready' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-400',
                        ];
                    @endphp
                    <span
                        class="inline-flex px-4 py-2 rounded-2xl text-xs font-black uppercase tracking-widest {{ $statusColors[$pengajuan->status] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ str_replace('_', ' ', $pengajuan->status) }}
                    </span>
                </div>
            </div>

            <div class="space-y-8">
                {{-- 1. Priority Score & Status --}}
                <div
                    class="bg-white dark:bg-gray-900 rounded-3xl p-8 border border-gray-100 dark:border-gray-800 shadow-xl shadow-gray-200/50 dark:shadow-none overflow-hidden relative">
                    <div
                        class="absolute -right-8 -top-8 w-32 h-32 bg-blue-50 dark:bg-blue-900/20 rounded-full blur-2xl">
                    </div>

                    <div class="flex flex-col md:flex-row items-center gap-8 relative z-10">
                        <div
                            class="flex-shrink-0 text-center px-8 py-4 bg-blue-600 rounded-3xl text-white shadow-xl shadow-blue-200 dark:shadow-none">
                            <span class="block text-[10px] font-black uppercase tracking-widest mb-1 opacity-80">Skor
                                Prioritas</span>
                            <span
                                class="text-3xl font-black leading-none">{{ number_format($pengajuan->priority_score, 1) }}</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-tight mb-2">
                                Transparansi Prioritas</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">Sesuai dengan **Sistem
                                Prioritas Pintar**, pengajuan Anda dinilai berdasarkan urgensi profil dan jenis layanan.
                                Skor ini menentukan urutan pengerjaan oleh petugas.</p>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-50 dark:border-gray-800">
                        <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4 italic">Breakdown
                            Perhitungan:</h4>
                        <div class="flex flex-wrap gap-3">
                            @foreach ($pengajuan->priority_breakdown as $item)
                                <div
                                    class="px-4 py-2 bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-xl text-xs font-bold text-gray-700 dark:text-gray-300">
                                    {{ $item['label'] }} <span
                                        class="text-blue-600 dark:text-blue-400 ml-1">+{{ number_format($item['score'], 1) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {{-- 2. Detail Pengajuan --}}
                    <div
                        class="bg-white dark:bg-gray-900 rounded-3xl p-8 border border-gray-100 dark:border-gray-800 shadow-lg shadow-gray-200/50 dark:shadow-none">
                        <h3
                            class="text-md font-black text-gray-900 dark:text-white uppercase tracking-tight mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Input Data Surat
                        </h3>
                        <div class="space-y-6">
                            <div>
                                <label
                                    class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 italic">Keperluan</label>
                                <p class="text-sm text-gray-800 dark:text-gray-300 font-bold leading-relaxed">
                                    {{ $pengajuan->keperluan }}</p>
                            </div>
                            @foreach ($pengajuan->field_data as $key => $val)
                                <div>
                                    <label
                                        class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 italic">{{ str_replace('_', ' ', strtoupper($key)) }}</label>
                                    <p class="text-sm text-gray-800 dark:text-gray-300 font-bold">{{ $val }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- 3. Histori Perubahan --}}
                    <div
                        class="bg-white dark:bg-gray-900 rounded-3xl p-8 border border-gray-100 dark:border-gray-800 shadow-lg shadow-gray-200/50 dark:shadow-none">
                        <h3
                            class="text-md font-black text-gray-900 dark:text-white uppercase tracking-tight mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Log Status
                        </h3>
                        <div class="space-y-6">
                            @foreach ($pengajuan->history->sortByDesc('created_at') as $log)
                                <div class="relative pl-6 border-l-2 border-blue-100 dark:border-blue-900/50 pb-2">
                                    <div
                                        class="absolute -left-[9px] top-0 w-4 h-4 bg-white dark:bg-gray-900 border-2 border-blue-600 rounded-full">
                                    </div>
                                    <div
                                        class="text-[10px] font-black text-blue-600 dark:text-blue-400 uppercase tracking-widest mb-1">
                                        {{ $log->created_at->format('d M Y H:i') }}</div>
                                    <div class="text-sm font-bold text-gray-800 dark:text-gray-200 mb-1 leading-tight">
                                        @if ($log->to_status === 'submitted')
                                            Berhasil Dikirim
                                        @elseif($log->to_status === 'in_process')
                                            Sedang Diproses Admin
                                        @else
                                            Status menjadi {{ strtoupper($log->to_status) }}
                                        @endif
                                    </div>
                                    @if ($log->catatan)
                                        <p class="text-xs text-gray-500 dark:text-gray-500 italic">
                                            "{{ $log->catatan }}"</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
