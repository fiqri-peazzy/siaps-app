<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-y-2">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Daftar Prioritas Surat (DPS)') }}
            </h2>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white transition-colors">
                            <svg class="w-3.5 h-3.5 me-2.5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center text-gray-400">
                            <svg class="rtl:rotate-180 w-3 h-3 mx-1" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-sm font-medium">DPS</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <div class="p-4 bg-white border border-gray-200 rounded-2xl shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
        <div class="sm:flex sm:items-center sm:justify-between mb-8">
            <div>
                <h3 class="text-xl font-black text-gray-900 dark:text-white tracking-tight">Antrian Pengajuan Surat</h3>
                <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">Daftar pengajuan masyarakat yang
                    diurutkan berdasarkan skor prioritas tertinggi.</p>
            </div>
            <div class="flex items-center gap-3">
                <span
                    class="flex items-center gap-2 px-3 py-1.5 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 border border-blue-100 dark:border-blue-800 rounded-lg text-xs font-bold uppercase tracking-wider">
                    <span class="relative flex h-2 w-2">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                    </span>
                    Live Sorting
                </span>
            </div>
        </div>

        <div class="flex flex-col">
            <div class="overflow-x-auto rounded-xl border border-gray-100 dark:border-gray-700">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-800/50">
                                <tr>
                                    <th scope="col"
                                        class="p-4 text-xs font-bold text-left text-gray-500 uppercase dark:text-gray-400 tracking-wider">
                                        Prioritas / Skor
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-bold text-left text-gray-500 uppercase dark:text-gray-400 tracking-wider">
                                        Kode / Layanan
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-bold text-left text-gray-500 uppercase dark:text-gray-400 tracking-wider">
                                        Pemohon
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-bold text-left text-gray-500 uppercase dark:text-gray-400 tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-bold text-left text-gray-500 uppercase dark:text-gray-400 tracking-wider">
                                        Waktu
                                    </th>
                                    <th scope="col"
                                        class="p-4 text-xs font-bold text-left text-gray-500 uppercase dark:text-gray-400 tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @forelse($submissions as $index => $s)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group">
                                        <td class="p-4 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 font-black text-sm">
                                                    {{ $submissions->firstItem() + $index }}
                                                </div>
                                                <div class="flex flex-col">
                                                    {{-- The Badge is now a clickable button to show breakdown --}}
                                                    <button type="button" x-data=""
                                                        x-on:click.prevent="$dispatch('open-modal', 'breakdown-{{ $s->id }}')"
                                                        class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-black bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300 hover:bg-blue-200 dark:hover:bg-blue-800 transition-colors cursor-pointer group/score"
                                                        title="Lihat Detail Perhitungan">
                                                        <span>{{ number_format($s->priority_score, 1) }}</span>
                                                        <svg class="w-3 h-3 text-blue-500 opacity-50 group-hover/score:opacity-100 transition-opacity"
                                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="p-4">
                                            <div
                                                class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tighter">
                                                {{ $s->kode_pengajuan }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $s->jenisSurat->nama }}
                                            </div>
                                        </td>
                                        <td class="p-4">
                                            <div class="flex items-center gap-3">
                                                @php
                                                    $displayName = $s->biodata->nama_lengkap ?? $s->user->name;
                                                @endphp
                                                <div
                                                    class="w-8 h-8 bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-600 dark:to-gray-700 rounded-full flex items-center justify-center font-bold text-xs text-gray-600 dark:text-gray-300 uppercase">
                                                    {{ substr($displayName, 0, 2) }}
                                                </div>
                                                <div>
                                                    <div class="text-sm font-bold text-gray-900 dark:text-white">
                                                        {{ $displayName }}</div>
                                                    <div class="text-[10px] text-gray-500 uppercase leading-none">
                                                        {{ $s->biodata->nik ?? '-' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="p-4 whitespace-nowrap">
                                            @php
                                                $statusColors = [
                                                    'submitted' =>
                                                        'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400',
                                                    'in_process' =>
                                                        'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                                    'approved' =>
                                                        'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                                    'rejected' =>
                                                        'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                                ];
                                                $color =
                                                    $statusColors[$s->status] ??
                                                    'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                                            @endphp
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider {{ $color }}">
                                                {{ str_replace('_', ' ', $s->status) }}
                                            </span>
                                        </td>
                                        <td class="p-4 whitespace-nowrap">
                                            <div
                                                class="text-[10px] font-bold text-gray-500 uppercase dark:text-gray-400">
                                                Diajukan</div>
                                            <div class="text-xs text-gray-900 dark:text-white font-semibold">
                                                {{ $s->submitted_at->diffForHumans() }}</div>
                                        </td>
                                        <td class="p-4 whitespace-nowrap text-right">
                                            <a href="{{ route('admin.pengajuan.show', $s) }}"
                                                class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-xl text-xs font-bold text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all shadow-sm">
                                                Detail Sesuai Prosedur
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="p-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-full mb-4">
                                                    <svg class="w-12 h-12 text-gray-300 dark:text-gray-600"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="1.5"
                                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <h4 class="text-lg font-bold text-gray-900 dark:text-white">Belum Ada
                                                    Pengajuan</h4>
                                                <p
                                                    class="text-sm text-gray-500 dark:text-gray-400 mt-1 max-w-xs mx-auto">
                                                    Saat ini belum ada pengajuan surat dari masyarakat yang masuk ke
                                                    dalam sistem.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-8">
            {{ $submissions->links() }}
        </div>
    </div>

    {{-- Priority Breakdown Modals --}}
    @foreach ($submissions as $s)
        <x-modal name="breakdown-{{ $s->id }}" maxWidth="lg">
            <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden">

                {{-- Header --}}
                <div
                    class="flex items-center justify-between px-6 py-5 border-b border-gray-100 dark:border-gray-700/80 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-800">
                    <div class="flex items-center gap-3">
                        <div
                            class="flex-shrink-0 w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-200 dark:shadow-none">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3
                                class="text-base font-black text-gray-900 dark:text-white uppercase tracking-tight leading-tight">
                                Detail Perhitungan Prioritas</h3>
                            <p
                                class="text-[10px] font-bold text-blue-600 dark:text-blue-400 uppercase tracking-widest mt-0.5">
                                {{ $s->kode_pengajuan }}</p>
                        </div>
                    </div>
                    <button x-on:click="$dispatch('close-modal', 'breakdown-{{ $s->id }}')"
                        class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-white/80 dark:hover:bg-gray-700 rounded-xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Content --}}
                <div class="p-6 space-y-5">

                    {{-- Identity section --}}
                    @php
                        $breakdownName = $s->biodata->nama_lengkap ?? $s->user->name;
                    @endphp
                    <div
                        class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-900/50 rounded-2xl border border-gray-100 dark:border-gray-700">
                        <div
                            class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-sm font-black flex-shrink-0">
                            {{ strtoupper(substr($breakdownName, 0, 2)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-black text-gray-900 dark:text-white truncate">{{ $breakdownName }}
                            </p>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                {{ $s->biodata->nik ?? '-' }} • {{ $s->jenisSurat->nama }}</p>
                        </div>
                    </div>

                    {{-- Total Score highlight --}}
                    <div
                        class="flex items-center justify-between p-5 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl shadow-lg shadow-blue-200 dark:shadow-none">
                        <div>
                            <p class="text-[10px] font-black text-blue-200 uppercase tracking-widest mb-0.5">Total Skor
                                Prioritas Akhir</p>
                            <p class="text-xs text-blue-100 font-medium">Akumulasi semua komponen di bawah</p>
                        </div>
                        <span class="text-4xl font-black text-white">{{ number_format($s->priority_score, 1) }}</span>
                    </div>

                    {{-- Breakdown detail --}}
                    <div>
                        <h4
                            class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">
                            Rincian Variabel Perhitungan</h4>

                        @if (is_array($s->priority_breakdown) && count($s->priority_breakdown) > 0)
                            <div class="space-y-2">
                                @foreach ($s->priority_breakdown as $idx => $item)
                                    @php
                                        $label = $item['label'] ?? 'Variabel';
                                        $score = $item['score'] ?? 0;
                                        $isBase =
                                            str_contains(strtolower($label), 'base') ||
                                            str_contains(strtolower($label), 'dasar');
                                        $dotColor = $isBase ? 'bg-indigo-500' : 'bg-emerald-500';
                                        $badgeColor = $isBase
                                            ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 ring-1 ring-indigo-200 dark:ring-indigo-800'
                                            : 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 ring-1 ring-emerald-200 dark:ring-emerald-800';
                                    @endphp
                                    <div
                                        class="flex items-center justify-between p-4 bg-white dark:bg-gray-900/60 rounded-xl border border-gray-100 dark:border-gray-700 hover:border-blue-200 dark:hover:border-blue-700 transition-colors group">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-6 h-6 rounded-lg bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-[9px] font-black text-gray-500 dark:text-gray-400 flex-shrink-0">
                                                {{ $idx + 1 }}
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <div
                                                    class="w-1.5 h-1.5 rounded-full {{ $dotColor }} flex-shrink-0">
                                                </div>
                                                <span
                                                    class="text-sm font-bold text-gray-700 dark:text-gray-200">{{ $label }}</span>
                                            </div>
                                        </div>
                                        <span class="text-sm font-black px-3 py-1.5 rounded-lg {{ $badgeColor }}">
                                            +{{ number_format($score, 1) }}
                                        </span>
                                    </div>
                                @endforeach

                                {{-- Separator & sum --}}
                                <div
                                    class="flex items-center justify-between px-4 py-3 bg-gray-50 dark:bg-gray-900 rounded-xl border border-dashed border-gray-200 dark:border-gray-700 mt-1">
                                    <span class="text-xs font-black text-gray-400 uppercase tracking-wider">Σ Total
                                        Akumulasi</span>
                                    <span class="text-base font-black text-blue-600 dark:text-blue-400">=
                                        {{ number_format($s->priority_score, 1) }}</span>
                                </div>
                            </div>
                        @else
                            <div
                                class="py-8 text-center bg-gray-50 dark:bg-gray-900/50 rounded-xl border border-dashed border-gray-200 dark:border-gray-700">
                                <svg class="w-8 h-8 mx-auto text-gray-300 dark:text-gray-600 mb-2" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <p class="text-xs font-bold text-gray-400 italic">Data rincian tidak tersedia untuk
                                    pengajuan ini.</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Footer --}}
                <div
                    class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/80 dark:bg-gray-800/80 flex items-center justify-between gap-3">
                    <p class="text-[10px] text-gray-400 font-medium italic">Diajukan
                        {{ $s->submitted_at->diffForHumans() }}</p>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.pengajuan.show', $s) }}"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-black rounded-lg transition-all uppercase tracking-wider">
                            Lihat Detail
                        </a>
                        <button x-on:click="$dispatch('close-modal', 'breakdown-{{ $s->id }}')"
                            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 text-[10px] font-black rounded-lg transition-all uppercase tracking-wider">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </x-modal>
    @endforeach
</x-app-layout>
