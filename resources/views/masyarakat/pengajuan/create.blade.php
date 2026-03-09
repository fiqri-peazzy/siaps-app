<x-public-layout>
    @section('title', 'Form Pengajuan ' . $jenis_surat->nama)

    <div class="py-12 bg-gray-50/50 dark:bg-gray-950/50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Breadcrumb & Header --}}
            <nav class="flex mb-8" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('masyarakat.pengajuan.index') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                            </svg>
                            Layanan
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="ml-1 text-sm font-bold text-gray-900 dark:text-white md:ml-2">Form
                                {{ $jenis_surat->nama }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div
                class="bg-white dark:bg-gray-900 rounded-3xl shadow-xl shadow-gray-200/50 dark:shadow-none border border-gray-100 dark:border-gray-800 overflow-hidden">
                {{-- Form Header --}}
                <div
                    class="p-8 border-b border-gray-100 dark:border-gray-800 bg-gradient-to-br from-white to-gray-50/50 dark:from-gray-900 dark:to-gray-800/50">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div class="flex items-center gap-5">
                            <div
                                class="p-4 bg-blue-600 rounded-2xl shadow-lg shadow-blue-200 dark:shadow-none text-white">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">
                                    {{ $jenis_surat->nama }}</h2>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Lengkapi formulir di bawah ini
                                    dengan data yang benar.</p>
                            </div>
                        </div>
                        <div
                            class="flex items-center gap-3 px-4 py-2 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-100 dark:border-blue-800/50">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="text-sm font-bold text-blue-700 dark:text-blue-300">Estimasi:
                                {{ $jenis_surat->sla_hari }} Hari Kerja</span>
                        </div>
                    </div>
                </div>

                <form action="{{ route('masyarakat.pengajuan.store', $jenis_surat->kode) }}" method="POST"
                    enctype="multipart/form-data" class="p-8 space-y-10" id="submission-form">
                    @csrf

                    {{-- Section 1: Data Dasar (Read Only dari Profile) --}}
                    <section class="space-y-6">
                        <div class="flex items-center gap-3 mb-2">
                            <span
                                class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 font-bold text-sm">1</span>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Informasi Dasar Pemohon</h3>
                        </div>
                        <div
                            class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 bg-gray-50 dark:bg-gray-800/50 rounded-2xl border border-gray-100 dark:border-gray-800">
                            <div>
                                <label
                                    class="block text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1">Nama
                                    Lengkap</label>
                                <p class="text-gray-900 dark:text-white font-semibold">{{ Auth::user()->name }}</p>
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1">NIK</label>
                                <p class="text-gray-900 dark:text-white font-semibold">{{ $biodata->nik ?? '-' }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <label
                                    class="block text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1">Alamat
                                    Domisili</label>
                                <p class="text-gray-900 dark:text-white font-semibold">
                                    {{ $biodata->alamat_lengkap ?? '-' }}</p>
                            </div>
                        </div>
                        @if (!$biodata || $biodata->verification_status !== 'verified')
                            <div
                                class="flex items-start gap-4 p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl">
                                <svg class="w-6 h-6 text-amber-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div>
                                    <p class="text-sm font-bold text-amber-800 dark:text-amber-400">Peringatan
                                        Verifikasi Biodata</p>
                                    <p class="text-sm text-amber-700 dark:text-amber-500">Biodata Anda belum
                                        terverifikasi oleh Admin. Anda tetap bisa mengajukan surat, namun proses
                                        validasi baru dilakukan setelah biodata Anda dinyatakan VALID.</p>
                                    <a href="{{ route('masyarakat.profile') }}"
                                        class="inline-flex items-center text-xs font-bold text-amber-600 hover:text-amber-700 underline mt-2">
                                        Lengkapi & Validasi Biodata Sekarang
                                        <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endif
                    </section>

                    <hr class="border-gray-100 dark:border-gray-800">

                    {{-- Section 2: Form Dinamis --}}
                    <section class="space-y-6">
                        <div class="flex items-center gap-3 mb-2">
                            <span
                                class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 font-bold text-sm">2</span>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Detail Kebutuhan Surat</h3>
                        </div>

                        <div class="grid grid-cols-1 gap-8">
                            {{-- Field Keperluan (Standard) --}}
                            <div>
                                <label for="keperluan"
                                    class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Alasan /
                                    Keperluan Pengajuan <span class="text-red-500">*</span></label>
                                <textarea id="keperluan" name="keperluan" rows="3" required
                                    class="w-full px-4 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 dark:focus:border-blue-600 transition-all outline-none text-gray-900 dark:text-white placeholder:text-gray-400"
                                    placeholder="Contoh: Untuk persyaratan pendaftaran beasiswa pendidikan tinggi."></textarea>
                            </div>

                            {{-- Dynamic Fields --}}
                            @foreach ($jenis_surat->fields as $field)
                                <div>
                                    <label for="{{ $field->field_key }}"
                                        class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                        {{ $field->field_label }}
                                        @if ($field->is_required)
                                            <span class="text-red-500">*</span>
                                        @endif
                                    </label>

                                    @if ($field->field_type === 'textarea')
                                        <textarea id="{{ $field->field_key }}" name="fields[{{ $field->field_key }}]" rows="3"
                                            @if ($field->is_required) required @endif
                                            class="w-full px-4 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none text-gray-900 dark:text-white"
                                            placeholder="{{ $field->placeholder }}"></textarea>
                                    @elseif($field->field_type === 'select')
                                        <select id="{{ $field->field_key }}" name="fields[{{ $field->field_key }}]"
                                            @if ($field->is_required) required @endif
                                            class="w-full px-4 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none text-gray-900 dark:text-white">
                                            <option value="">Pilih {{ $field->field_label }}</option>
                                            @foreach ($field->field_options as $option)
                                                <option value="{{ $option }}">{{ $option }}</option>
                                            @endforeach
                                        </select>
                                    @elseif($field->field_type === 'date')
                                        <input type="date" id="{{ $field->field_key }}"
                                            name="fields[{{ $field->field_key }}]"
                                            @if ($field->is_required) required @endif
                                            class="w-full px-4 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none text-gray-900 dark:text-white">
                                    @else
                                        <input type="{{ $field->field_type ?? 'text' }}"
                                            id="{{ $field->field_key }}" name="fields[{{ $field->field_key }}]"
                                            @if ($field->is_required) required @endif
                                            placeholder="{{ $field->placeholder }}"
                                            class="w-full px-4 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none text-gray-900 dark:text-white">
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <hr class="border-gray-100 dark:border-gray-800">

                    {{-- Section 3: Upload Dokumen --}}
                    <section class="space-y-6">
                        <div class="flex items-center gap-3 mb-2">
                            <span
                                class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 font-bold text-sm">3</span>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Dokumen Pendukung</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            @foreach ($jenis_surat->syarat as $s)
                                <div class="space-y-3">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ $s->nama_syarat }}
                                            @if ($s->is_required)
                                                <span class="text-red-500">*</span>
                                            @endif
                                        </span>
                                        @if ($s->deskripsi)
                                            <span
                                                class="text-xs text-gray-500 dark:text-gray-500">{{ $s->deskripsi }}</span>
                                        @endif
                                    </div>
                                    <div class="relative group">
                                        <input type="file" name="syarat[{{ $s->id }}]"
                                            id="file-{{ $s->id }}"
                                            accept="{{ str_replace(',', '|', '.' . str_replace(',', ',.', $s->allowed_types)) }}"
                                            @if ($s->is_required) required @endif
                                            class="hidden file-input" data-syarat="{{ $s->nama_syarat }}">
                                        <label for="file-{{ $s->id }}"
                                            class="flex items-center gap-4 px-6 py-4 bg-gray-50 dark:bg-gray-800 border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-2xl cursor-pointer hover:bg-blue-50 dark:hover:bg-blue-900/10 hover:border-blue-400 transition-all duration-300">
                                            <div
                                                class="p-2 bg-white dark:bg-gray-700 rounded-xl shadow-sm group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                                </svg>
                                            </div>
                                            <div class="flex-1 overflow-hidden">
                                                <span
                                                    class="block text-sm font-semibold text-gray-600 dark:text-gray-400 truncate file-label-name">Pilih
                                                    file...</span>
                                                <span
                                                    class="block text-[10px] text-gray-400 uppercase tracking-tighter">Maks
                                                    {{ $s->max_size_kb }} KB ({{ $s->allowed_types }})</span>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="error-msg text-xs text-red-500 hidden mt-1"></div>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    {{-- Actions --}}
                    <div class="pt-10 flex flex-col md:flex-row gap-4 items-center">
                        <button type="submit" id="btn-submit"
                            class="w-full md:w-auto px-10 py-4 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-2xl shadow-xl shadow-blue-200 dark:shadow-none hover:shadow-2xl transition-all active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed">
                            Kirim Pengajuan Sekarang
                        </button>
                        <a href="{{ route('masyarakat.pengajuan.index') }}"
                            class="w-full md:w-auto px-8 py-4 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 font-bold rounded-2xl hover:bg-gray-200 dark:hover:bg-gray-700 transition-all text-center">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const inputs = document.querySelectorAll('.file-input');
                const submitBtn = document.getElementById('btn-submit');

                inputs.forEach(input => {
                    input.addEventListener('change', function() {
                        const labelName = this.parentElement.querySelector('.file-label-name');
                        const errorMsg = this.parentElement.parentElement.querySelector('.error-msg');
                        const labelCont = this.nextElementSibling;

                        if (this.files && this.files.length > 0) {
                            const file = this.files[0];
                            const maxSize = parseInt(this.getAttribute('data-max-size')) || 2048; // KB
                            const allowedTypes = this.getAttribute('accept').toLowerCase();
                            const fileName = file.name;
                            const fileSize = file.size / 1024; // KB
                            const fileExt = '.' + fileName.split('.').pop().toLowerCase();

                            let isValid = true;
                            let message = '';

                            if (fileSize > maxSize) {
                                isValid = false;
                                message = `File terlalu besar (Maks ${maxSize} KB)`;
                            } else if (!allowedTypes.includes(fileExt)) {
                                isValid = false;
                                message = `Format file tidak diizinkan (${fileExt})`;
                            }

                            if (!isValid) {
                                errorMsg.textContent = message;
                                errorMsg.classList.remove('hidden');
                                labelCont.classList.add('border-red-400', 'bg-red-50',
                                    'dark:bg-red-900/10');
                                labelCont.classList.remove('border-gray-200', 'hover:border-blue-400');
                                labelName.textContent = 'Gagal upload';
                                this.value = ''; // Reset
                            } else {
                                errorMsg.classList.add('hidden');
                                labelCont.classList.remove('border-red-400', 'bg-red-50',
                                    'dark:bg-red-900/10');
                                labelCont.classList.add('border-blue-500', 'bg-blue-50',
                                    'dark:bg-blue-900/10');
                                labelName.textContent = fileName;
                                labelName.classList.add('text-blue-600', 'dark:text-blue-400');
                            }
                        } else {
                            labelName.textContent = 'Pilih file...';
                            labelName.classList.remove('text-blue-600', 'dark:text-blue-400');
                        }
                    });
                });

                // Prevent double submission
                document.getElementById('submission-form').addEventListener('submit', function() {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML =
                        '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...';
                });
            });
        </script>
    @endpush
</x-public-layout>
