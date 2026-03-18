<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-black text-xl text-gray-900 dark:text-white uppercase tracking-tight">
                    Dashboard Persetujuan Kepala Desa
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Daftar draf surat yang menunggu
                    ditandatangani.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">

        {{-- Success / Error --}}
        @if (session('success'))
            <div
                class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-2xl text-green-800 dark:text-green-400 font-bold text-sm">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div
                class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-2xl text-red-800 dark:text-red-400 font-bold text-sm">
                {{ session('error') }}
            </div>
        @endif

        {{-- Stats --}}
        @php
            $waitingCount = $submissions->where('status', 'validated')->count();
            $approvedCount = $submissions->where('status', 'approved')->count();
        @endphp
        <div class="grid grid-cols-2 gap-4">
            <div
                class="p-6 bg-white dark:bg-gray-800 border border-sky-100 dark:border-sky-900/40 rounded-2xl shadow-sm">
                <p class="text-xs font-black text-sky-600 uppercase tracking-widest mb-1">Menunggu TTD</p>
                <p class="text-4xl font-black text-gray-900 dark:text-white">{{ $waitingCount }}</p>
                <p class="text-xs text-gray-400 mt-1">Draf Surat</p>
            </div>
            <div
                class="p-6 bg-white dark:bg-gray-800 border border-green-100 dark:border-green-900/40 rounded-2xl shadow-sm">
                <p class="text-xs font-black text-green-600 uppercase tracking-widest mb-1">Sudah Disetujui</p>
                <p class="text-4xl font-black text-gray-900 dark:text-white">{{ $approvedCount }}</p>
                <p class="text-xs text-gray-400 mt-1">Surat Terbit</p>
            </div>
        </div>

        {{-- Table --}}
        <div
            class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                <h3 class="font-black text-sm text-gray-900 dark:text-white uppercase tracking-widest">Daftar Draf Surat
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr
                            class="border-b border-gray-100 dark:border-gray-700 text-[10px] uppercase tracking-widest text-gray-400 font-black">
                            <th class="p-4 text-left">Kode</th>
                            <th class="p-4 text-left">Pemohon</th>
                            <th class="p-4 text-left">Jenis Surat</th>
                            <th class="p-4 text-left">Status</th>
                            <th class="p-4 text-left">Tervalidasi</th>
                            <th class="p-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-700/50">
                        @forelse($submissions as $s)
                            @php
                                $statusColors = [
                                    'validated' => 'bg-sky-100 text-sky-800 dark:bg-sky-900/30 dark:text-sky-400',
                                    'approved' =>
                                        'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                    'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                ];
                                $statusLabels = [
                                    'validated' => 'Menunggu TTD',
                                    'approved' => 'Disetujui',
                                    'rejected' => 'Ditolak Kades',
                                ];
                                $color = $statusColors[$s->status] ?? 'bg-gray-100 text-gray-600';
                                $label = $statusLabels[$s->status] ?? $s->status;
                                $displayName = $s->biodata->nama_lengkap ?? $s->user->name;
                            @endphp
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                <td
                                    class="p-4 font-black text-xs text-gray-900 dark:text-white uppercase tracking-tighter">
                                    {{ $s->kode_pengajuan }}
                                    @if ($s->nomor_surat)
                                        <div class="text-[10px] text-gray-400 font-normal">{{ $s->nomor_surat }}</div>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <div class="font-bold text-gray-900 dark:text-white">{{ $displayName }}</div>
                                    <div class="text-[10px] text-gray-400">{{ $s->biodata->nik ?? '-' }}</div>
                                </td>
                                <td class="p-4 text-gray-600 dark:text-gray-400">{{ $s->jenisSurat->nama }}</td>
                                <td class="p-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider {{ $color }}">
                                        {{ $label }}
                                    </span>
                                </td>
                                <td class="p-4 text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                    {{ $s->validated_at ? $s->validated_at->diffForHumans() : '-' }}
                                </td>
                                <td class="p-4 whitespace-nowrap text-right">
                                    <a href="{{ route('admin.kades.show', $s) }}"
                                        class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-xl text-xs font-bold text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all shadow-sm">
                                        @if ($s->status === 'validated')
                                            Tanda Tangani
                                        @else
                                            Lihat Detail
                                        @endif
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-16 text-center text-gray-400 font-bold text-sm">
                                    Tidak ada draf surat yang perlu ditandatangani.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{ $submissions->links() }}
    </div>
</x-app-layout>
