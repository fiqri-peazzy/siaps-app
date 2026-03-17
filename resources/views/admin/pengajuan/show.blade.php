<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-y-2">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detail Pengajuan: ') . $pengajuan->kode_pengajuan }}
            </h2>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li><a href="{{ route('dashboard') }}"
                            class="text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400">Dashboard</a>
                    </li>
                    <li>
                        <div class="flex items-center"><svg class="w-3 h-3 text-gray-400 mx-1" fill="none"
                                viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg><a href="{{ route('admin.pengajuan.index') }}"
                                class="text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400">DPS</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center"><svg class="w-3 h-3 text-gray-400 mx-1" fill="none"
                                viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg><span class="text-sm font-medium text-gray-500">Detail</span></div>
                    </li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Left Column: Data Pengajuan --}}
        <div class="lg:col-span-2 space-y-8">
            {{-- 1. Status & Priority --}}
            <div
                class="p-8 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-6 mb-8">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-blue-600 rounded-xl text-white shadow-lg shadow-blue-200 dark:shadow-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-tight">
                                {{ $pengajuan->jenisSurat->nama }}</h3>
                            <p
                                class="text-xs font-bold text-blue-600 dark:text-blue-400 uppercase tracking-widest mt-0.5">
                                {{ $pengajuan->kode_pengajuan }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="text-right">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Status Saat
                                Ini</p>
                            @php
                                $statusColors = [
                                    'submitted' =>
                                        'bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-400',
                                    'in_process' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-400',
                                    'approved' =>
                                        'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-400',
                                    'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-400',
                                ];
                            @endphp
                            <span
                                class="inline-flex px-3 py-1.5 rounded-lg text-xs font-black uppercase tracking-wider {{ $statusColors[$pengajuan->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ str_replace('_', ' ', $pengajuan->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Priority Breakdown --}}
                <div class="p-6 bg-gray-50 dark:bg-gray-900/50 rounded-2xl border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-sm font-black text-gray-700 dark:text-gray-300 uppercase tracking-wider italic">
                            Anatomy of Priority Score</h4>
                        <span
                            class="text-2xl font-black text-blue-600 dark:text-blue-400">{{ number_format($pengajuan->priority_score, 1) }}</span>
                    </div>
                    <div class="space-y-3">
                        @foreach ($pengajuan->priority_breakdown as $item)
                            <div class="flex items-center justify-between text-xs font-bold">
                                <span class="text-gray-500 dark:text-gray-500">{{ $item['label'] }}</span>
                                <span
                                    class="text-gray-900 dark:text-white">+{{ number_format($item['score'], 1) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- 2. Form Data --}}
            <div
                class="p-8 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-sm">
                <h3
                    class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-tight mb-6 border-l-4 border-blue-600 pl-4">
                    Data Kebutuhan Surat</h3>

                <div class="grid grid-cols-1 gap-8">
                    <div>
                        <label
                            class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 italic">Keperluan</label>
                        <p class="text-sm text-gray-900 dark:text-white leading-relaxed font-semibold">
                            {{ $pengajuan->keperluan }}</p>
                    </div>

                    @foreach ($pengajuan->jenisSurat->fields as $field)
                        <div>
                            <label
                                class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 italic">{{ $field->field_label }}</label>
                            <p class="text-sm text-gray-900 dark:text-white font-semibold">
                                {{ $pengajuan->field_data[$field->field_key] ?? '-' }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- 3. Documents --}}
            <div
                class="p-8 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-sm">
                <h3
                    class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-tight mb-6 border-l-4 border-blue-600 pl-4">
                    Dokumen Pendukung</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($pengajuan->dokumen as $dok)
                        <div
                            class="group relative p-4 bg-gray-50 dark:bg-gray-900/50 rounded-2xl border border-gray-100 dark:border-gray-700 hover:border-blue-300 transition-all overflow-hidden flex flex-col justify-between">
                            <div class="flex items-start gap-4 mb-4">
                                {{-- Thumbnail/Icon --}}
                                <div
                                    class="w-16 h-16 rounded-xl overflow-hidden shadow-sm flex-shrink-0 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700">
                                    @if (str_starts_with($dok->mime_type, 'image/'))
                                        <img src="{{ asset('storage/' . $dok->file_path) }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <div
                                            class="w-full h-full flex items-center justify-center text-blue-600 dark:text-blue-400">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-black text-gray-900 dark:text-white truncate">
                                        {{ $dok->nama_dokumen }}</p>
                                    <p
                                        class="text-[10px] font-bold text-gray-500 dark:text-gray-500 uppercase tracking-widest leading-tight mt-1">
                                        {{ number_format($dok->file_size / 1024, 1) }} KB •
                                        {{ strtoupper(explode('/', $dok->mime_type)[1] ?? 'DOC') }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <button type="button"
                                    class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-xl text-[10px] font-black uppercase tracking-widest text-white hover:bg-blue-700 transition-all btn-preview-doc"
                                    data-path="{{ asset('storage/' . $dok->file_path) }}"
                                    data-mime="{{ $dok->mime_type }}" data-name="{{ $dok->nama_dokumen }}">
                                    <svg class="w-3.5 h-3.5 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Preview
                                </button>
                                <a href="{{ asset('storage/' . $dok->file_path) }}" target="_blank"
                                    class="p-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Right Column: Profil & Actions --}}
        <div class="space-y-8">
            {{-- Citizen Info --}}
            <div
                class="p-8 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-sm">
                <h3 class="text-sm font-black text-gray-400 uppercase tracking-widest mb-6 italic">Profil Pemohon</h3>
                <div class="flex flex-col items-center text-center">
                    @php
                        $displayName = $pengajuan->biodata->nama_lengkap ?? $pengajuan->user->name;
                    @endphp
                    <div
                        class="w-20 h-20 bg-gradient-to-tr from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white font-black text-2xl shadow-xl mb-4">
                        {{ substr($displayName, 0, 2) }}
                    </div>
                    <h4 class="text-xl font-black text-gray-900 dark:text-white">{{ $displayName }}</h4>
                    <p class="text-sm font-bold text-blue-600 dark:text-blue-400 mt-1">{{ $pengajuan->biodata->nik }}
                    </p>
                </div>

                <div class="mt-8 space-y-4 border-t border-gray-100 dark:border-gray-700 pt-6">
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-gray-500 dark:text-gray-500 font-bold uppercase tracking-tighter">Status
                            Profil</span>
                        <span
                            class="px-2 py-0.5 bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-400 rounded-full font-black text-[10px] uppercase tracking-wider">Terverifikasi</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-gray-500 dark:text-gray-500 font-bold uppercase tracking-tighter">Umur</span>
                        <span
                            class="text-gray-900 dark:text-white font-black whitespace-nowrap italic">{{ \Carbon\Carbon::parse($pengajuan->biodata->tanggal_lahir)->age }}
                            Tahun</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-gray-500 dark:text-gray-500 font-bold uppercase tracking-tighter">RT /
                            Lokasi</span>
                        <span
                            class="text-gray-900 dark:text-white font-black whitespace-nowrap italic">{{ $pengajuan->biodata->rt->nama ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div
                class="p-8 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-sm">
                <h3 class="text-sm font-black text-gray-400 uppercase tracking-widest mb-6 italic">Panel Eksekusi</h3>

                <div class="space-y-4 text-xs font-bold">
                    @if ($pengajuan->status === 'submitted' || $pengajuan->status === 'queued')
                        <form action="{{ route('admin.pengajuan.process', $pengajuan) }}" method="POST">
                            @csrf
                            <button
                                class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow-lg shadow-blue-200 dark:shadow-none transition-all active:scale-95 uppercase tracking-wider font-black">Mulai
                                Proses (Lock Data)</button>
                        </form>
                    @endif

                    @if ($pengajuan->status === 'in_process')
                        <form action="{{ route('admin.pengajuan.approve', $pengajuan) }}" method="POST">
                            @csrf
                            <button
                                class="w-full py-4 bg-green-600 hover:bg-green-700 text-white rounded-xl shadow-lg shadow-green-200 dark:shadow-none transition-all active:scale-95 uppercase tracking-wider font-black mb-1">Terbitkan
                                Surat (Approve)</button>
                        </form>

                        <x-danger-button x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'reject-submission-modal')"
                            class="w-full py-4 justify-center rounded-xl uppercase tracking-wider font-black">Tolak
                            Pengajuan</x-danger-button>
                    @endif

                    <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
                        <p class="text-[10px] text-gray-400 uppercase text-center italic">Aksi tambahan memerlukan
                            otorisasi kades</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Reject Modal --}}
    <x-modal name="reject-submission-modal" focusable>
        <form method="post" action="{{ route('admin.pengajuan.reject', $pengajuan) }}" class="p-8">
            @csrf
            <h2 class="text-xl font-black text-gray-900 dark:text-white tracking-tight uppercase">Tolak Pengajuan Surat
            </h2>
            <p class="mt-2 text-sm font-bold text-gray-500 dark:text-gray-400">Berikan alasan penolakan yang jelas agar
                masyarakat dapat memahami kendala pengajuannya.</p>

            <div class="mt-6">
                <x-input-label for="reason" value="Alasan Penolakan" class="sr-only" />
                <textarea id="reason" name="reason" rows="4" required
                    class="w-full px-4 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-4 focus:ring-red-500/10 focus:border-red-500 transition-all outline-none text-gray-900 dark:text-white"
                    placeholder="Contoh: Dokumen lampiran tidak terbaca atau NIK tidak sesuai dengan data kependudukan."></textarea>
                <x-input-error :messages="$errors->get('reason')" class="mt-2" />
            </div>

            <div class="mt-8 flex justify-end gap-4">
                <x-secondary-button x-on:click="$dispatch('close')"
                    class="rounded-xl font-black uppercase tracking-wider">Batal</x-secondary-button>
                <x-danger-button class="rounded-xl font-black uppercase tracking-wider">Konfirmasi
                    Tolak</x-danger-button>
            </div>
        </form>
    </x-modal>

    {{-- Doc Preview Modal --}}
    <x-modal name="preview-doc-modal" maxWidth="4xl">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4 border-b border-gray-100 dark:border-gray-800 pb-4">
                <h2 class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-tight"
                    id="preview-title">Preview Dokumen</h2>
                <button x-on:click="$dispatch('close')"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="bg-gray-50 dark:bg-gray-950 rounded-2xl overflow-hidden flex items-center justify-center min-h-[500px]"
                id="preview-content">
                {{-- Content injected via JS --}}
                <div class="animate-pulse text-gray-400 font-bold uppercase tracking-widest">Memuat Pratinjau...</div>
            </div>
        </div>
    </x-modal>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const previewBtns = document.querySelectorAll('.btn-preview-doc');
            const previewContent = document.getElementById('preview-content');
            const previewTitle = document.getElementById('preview-title');

            previewBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const path = this.getAttribute('data-path');
                    const mime = this.getAttribute('data-mime');
                    const name = this.getAttribute('data-name');

                    previewTitle.textContent = name;
                    previewContent.innerHTML = '';

                    if (mime.includes('image')) {
                        const img = document.createElement('img');
                        img.src = path;
                        img.className =
                            'max-w-full max-h-[70vh] object-contain shadow-2xl rounded-lg';
                        previewContent.appendChild(img);
                    } else if (mime.includes('pdf')) {
                        const embed = document.createElement('embed');
                        embed.src = path + '#toolbar=0';
                        embed.type = 'application/pdf';
                        embed.className = 'w-full h-[70vh] rounded-lg';
                        previewContent.appendChild(embed);
                    } else {
                        previewContent.innerHTML = `
                            <div class="text-center p-8">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <p class="text-gray-500 font-bold uppercase tracking-widest text-sm">Pratinjau tidak tersedia untuk format ini</p>
                                <a href="${path}" target="_blank" class="mt-4 inline-block text-blue-600 font-black uppercase tracking-tighter hover:underline">Download File Saja</a>
                            </div>
                        `;
                    }

                    window.dispatchEvent(new CustomEvent('open-modal', {
                        detail: 'preview-doc-modal'
                    }));
                });
            });
        });
    </script>
</x-app-layout>
