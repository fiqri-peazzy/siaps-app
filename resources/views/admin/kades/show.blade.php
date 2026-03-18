<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-y-2">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Tinjauan Draf Surat: {{ $pengajuan->kode_pengajuan }}
            </h2>
            <nav class="flex">
                <ol class="inline-flex items-center space-x-1">
                    <li><a href="{{ route('dashboard') }}"
                            class="text-sm font-medium text-gray-500 hover:text-blue-600">Dashboard</a></li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <a href="{{ route('admin.kades.index') }}"
                                class="text-sm font-medium text-gray-500 hover:text-blue-600">Persetujuan Kades</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="text-sm font-medium text-gray-500">Detail</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Left: PDF Preview + Info --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Status Banner --}}
                @if ($pengajuan->status === 'validated')
                    <div
                        class="p-4 bg-sky-50 dark:bg-sky-900/20 border border-sky-200 dark:border-sky-800 rounded-2xl flex items-center gap-3">
                        <svg class="w-5 h-5 text-sky-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                        <p class="text-sm font-bold text-sky-800 dark:text-sky-400">Draf ini menunggu tanda tangan
                            Kepala Desa.</p>
                    </div>
                @elseif($pengajuan->status === 'approved')
                    <div
                        class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-2xl flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <p class="text-sm font-bold text-green-800 dark:text-green-400">Surat telah disetujui. Nomor:
                            <span class="font-black">{{ $pengajuan->nomor_surat }}</span></p>
                    </div>
                @endif

                {{-- PDF Embed --}}
                @if ($pengajuan->surat_path)
                    <div
                        class="p-6 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-sm">
                        <h3 class="text-sm font-black text-gray-400 uppercase tracking-widest mb-4">Preview Draf Surat
                        </h3>
                        <iframe src="{{ Storage::url($pengajuan->surat_path) }}"
                            class="w-full h-[600px] rounded-xl border border-gray-200 dark:border-gray-700"></iframe>
                        <div class="mt-4">
                            <a href="{{ Storage::url($pengajuan->surat_path) }}" target="_blank"
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-900 hover:bg-gray-800 text-white text-xs font-black rounded-xl transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Unduh PDF
                            </a>
                        </div>
                    </div>
                @endif

                {{-- Submission Data Summary --}}
                <div
                    class="p-6 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-sm">
                    <h3 class="text-sm font-black text-gray-400 uppercase tracking-widest mb-4">Data Pengajuan</h3>
                    @php $fieldData = $pengajuan->field_data ?? []; @endphp
                    @if (count($fieldData) > 0)
                        <dl class="space-y-3">
                            @foreach ($fieldData as $key => $value)
                                @php
                                    $label = ucwords(str_replace('_', ' ', $key));
                                    $field = collect($pengajuan->jenisSurat->fields)->firstWhere('field_key', $key);
                                    if ($field) {
                                        $label = $field->field_label;
                                    }
                                @endphp
                                <div class="flex gap-3 text-sm">
                                    <dt class="w-32 font-bold text-gray-500 dark:text-gray-400 flex-shrink-0">
                                        {{ $label }}</dt>
                                    <dd class="font-bold text-gray-900 dark:text-white">
                                        {{ is_array($value) ? implode(', ', $value) : $value }}</dd>
                                </div>
                            @endforeach
                        </dl>
                    @else
                        <p class="text-sm text-gray-400">Tidak ada data field tambahan.</p>
                    @endif
                </div>
            </div>

            {{-- Right: Actions Panel --}}
            <div class="space-y-6">
                {{-- Pemohon Card --}}
                <div
                    class="p-6 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-sm text-center">
                    @php $displayName = $pengajuan->biodata->nama_lengkap ?? $pengajuan->user->name; @endphp
                    <div
                        class="w-16 h-16 bg-gradient-to-tr from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white font-black text-xl shadow-xl mb-3 mx-auto">
                        {{ substr($displayName, 0, 2) }}
                    </div>
                    <h4 class="text-base font-black text-gray-900 dark:text-white">{{ $displayName }}</h4>
                    <p class="text-xs font-bold text-blue-600 dark:text-blue-400 mt-1">{{ $pengajuan->biodata->nik }}
                    </p>
                    <div class="mt-4 text-left space-y-2 border-t border-gray-100 dark:border-gray-700 pt-4">
                        <div class="flex justify-between text-xs">
                            <span class="text-gray-400 font-bold">Jenis Surat</span>
                            <span
                                class="text-gray-900 dark:text-white font-bold text-right">{{ $pengajuan->jenisSurat->nama }}</span>
                        </div>
                        <div class="flex justify-between text-xs">
                            <span class="text-gray-400 font-bold">Diajukan</span>
                            <span
                                class="text-gray-900 dark:text-white font-bold">{{ $pengajuan->submitted_at->isoFormat('D MMM Y') }}</span>
                        </div>
                        <div class="flex justify-between text-xs">
                            <span class="text-gray-400 font-bold">Divalidasi</span>
                            <span
                                class="text-gray-900 dark:text-white font-bold">{{ $pengajuan->validated_at?->isoFormat('D MMM Y') ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Approval Panel --}}
                @if ($pengajuan->status === 'validated')
                    <div
                        class="p-6 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-sm space-y-3">
                        <h3 class="text-sm font-black text-gray-400 uppercase tracking-widest">Keputusan Kepala Desa
                        </h3>

                        <form action="{{ route('admin.kades.approve', $pengajuan) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full py-4 bg-green-600 hover:bg-green-700 text-white rounded-xl shadow-lg shadow-green-200 dark:shadow-none transition-all active:scale-95 uppercase tracking-wider font-black text-sm"
                                onclick="return confirm('Setujui dan terbitkan surat ini?')">
                                ✓ Setujui & Terbitkan Surat
                            </button>
                        </form>

                        <button type="button" x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'reject-kades-modal')"
                            class="w-full py-3 bg-red-100 hover:bg-red-200 text-red-800 dark:bg-red-900/40 dark:text-red-400 dark:hover:bg-red-900/60 rounded-xl transition-all active:scale-95 uppercase tracking-wider font-black text-xs">
                            ✗ Tolak Draf
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Reject Modal --}}
    <x-modal name="reject-kades-modal" focusable>
        <form method="POST" action="{{ route('admin.kades.reject', $pengajuan) }}" class="p-8">
            @csrf
            <h2 class="text-xl font-black text-gray-900 dark:text-white tracking-tight uppercase">Tolak Draf Surat</h2>
            <p class="mt-2 text-sm font-bold text-gray-500 dark:text-gray-400">Berikan alasan penolakan agar Admin dapat
                memperbaiki draf surat.</p>
            <div class="mt-6">
                <textarea id="reason_kades" name="reason" rows="4" required
                    class="w-full px-4 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-4 focus:ring-red-500/10 focus:border-red-500 transition-all outline-none text-gray-900 dark:text-white"
                    placeholder="Contoh: Nama pemohon tidak sesuai dengan data KTP..."></textarea>
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
</x-app-layout>
