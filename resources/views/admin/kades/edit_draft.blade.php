<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-y-2">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Edit Draf Surat: {{ $pengajuan->kode_pengajuan }}
            </h2>
            <nav class="flex">
                <ol class="inline-flex items-center space-x-1">
                    <li><a href="{{ route('dashboard') }}"
                            class="text-sm font-medium text-gray-500 hover:text-blue-600">Dashboard</a></li>
                    <li>
                        <div class="flex items-center"><svg class="w-3 h-3 text-gray-400 mx-1" fill="none"
                                viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg><a href="{{ route('admin.kades.index') }}"
                                class="text-sm font-medium text-gray-500 hover:text-blue-600">Persetujuan Kades</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center"><svg class="w-3 h-3 text-gray-400 mx-1" fill="none"
                                viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg><a href="{{ route('admin.kades.show', $pengajuan) }}"
                                class="text-sm font-medium text-gray-500 hover:text-blue-600">Detail</a></div>
                    </li>
                    <li>
                        <div class="flex items-center"><svg class="w-3 h-3 text-gray-400 mx-1" fill="none"
                                viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg><span class="text-sm font-medium text-gray-500">Edit Draf</span></div>
                    </li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Flash Messages --}}
        @if (session('error'))
            <div
                class="p-4 mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-2xl text-red-800 dark:text-red-400 font-bold text-sm">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.kades.update-draft', $pengajuan) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">

                {{-- Header Info Card --}}
                <div
                    class="p-6 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-2xl flex items-start gap-3">
                    <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    <div>
                        <p class="text-sm font-black text-amber-800 dark:text-amber-400 uppercase tracking-wide">Mode
                            Edit Draf</p>
                        <p class="text-xs text-amber-700 dark:text-amber-500 mt-0.5">
                            Perubahan di sini akan langsung memperbarui konten PDF. Gunakan fitur ini untuk koreksi
                            sebelum persetujuan Kepala Desa.
                        </p>
                    </div>
                </div>

                {{-- Nomor Surat --}}
                <div
                    class="p-6 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-sm">
                    <h3 class="text-sm font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-5">
                        Informasi Surat
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label for="nomor_surat"
                                class="block text-xs font-black text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-2">
                                Nomor Surat
                            </label>
                            <input type="text" id="nomor_surat" name="nomor_surat"
                                value="{{ old('nomor_surat', $pengajuan->nomor_surat) }}"
                                placeholder="Contoh: 001/SKD/DS.BATURATA/03/2026"
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-bold text-gray-900 dark:text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                            <p class="mt-1.5 text-xs text-gray-400">Kosongkan jika nomor surat akan ditetapkan saat
                                Kepala Desa menyetujui.</p>
                        </div>
                    </div>
                </div>

                {{-- Dynamic Field Data --}}
                @php
                    $fieldData = $pengajuan->field_data ?? [];
                    $fieldMeta = collect($pengajuan->jenisSurat->fields ?? []);
                @endphp

                @if (count($fieldData) > 0)
                    <div
                        class="p-6 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-sm">
                        <h3 class="text-sm font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-5">
                            Isian Surat — {{ $pengajuan->jenisSurat->nama }}
                        </h3>
                        <div class="space-y-4">
                            @foreach ($fieldData as $key => $value)
                                @php
                                    $meta = $fieldMeta->firstWhere('field_key', $key);
                                    $label = $meta?->field_label ?? ucwords(str_replace('_', ' ', $key));
                                    $type = $meta?->field_type ?? 'text';
                                    $inputName = 'field_' . $key;
                                @endphp
                                <div>
                                    <label for="{{ $inputName }}"
                                        class="block text-xs font-black text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-2">
                                        {{ $label }}
                                    </label>
                                    @if ($type === 'textarea')
                                        <textarea id="{{ $inputName }}" name="{{ $inputName }}" rows="3"
                                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-bold text-gray-900 dark:text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">{{ old($inputName, is_array($value) ? implode(', ', $value) : $value) }}</textarea>
                                    @else
                                        <input type="text" id="{{ $inputName }}" name="{{ $inputName }}"
                                            value="{{ old($inputName, is_array($value) ? implode(', ', $value) : $value) }}"
                                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-bold text-gray-900 dark:text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Pemohon Info (readonly) --}}
                <div class="p-6 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl">
                    <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Data Pemohon (Hanya
                        Baca)</h3>
                    @php $biodata = $pengajuan->biodata; @endphp
                    <div class="grid grid-cols-2 gap-x-6 gap-y-2 text-xs">
                        <div><span class="text-gray-400 font-bold">Nama</span><br><span
                                class="text-gray-900 dark:text-white font-black">{{ $biodata->nama_lengkap ?? $biodata->user->name }}</span>
                        </div>
                        <div><span class="text-gray-400 font-bold">NIK</span><br><span
                                class="text-gray-900 dark:text-white font-black">{{ $biodata->nik }}</span></div>
                        <div><span class="text-gray-400 font-bold">Tempat, Tgl Lahir</span><br><span
                                class="text-gray-900 dark:text-white font-black">{{ $biodata->tempat_lahir }},
                                {{ \Carbon\Carbon::parse($biodata->tanggal_lahir)->isoFormat('D MMMM Y') }}</span>
                        </div>
                        <div><span class="text-gray-400 font-bold">Jenis Kelamin</span><br><span
                                class="text-gray-900 dark:text-white font-black">{{ $biodata->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center gap-4 justify-end">
                    <a href="{{ route('admin.kades.show', $pengajuan) }}"
                        class="px-6 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl text-sm font-black uppercase tracking-wider transition-all">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow-lg shadow-blue-200 dark:shadow-none text-sm font-black uppercase tracking-wider transition-all active:scale-95">
                        💾 Simpan & Regenerate PDF
                    </button>
                </div>

            </div>
        </form>
    </div>
</x-app-layout>
