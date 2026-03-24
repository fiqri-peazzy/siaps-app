<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-y-2">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.master.jenis-surat.index') }}" class="text-blue-600 hover:text-blue-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Form Dinamis: {{ $jenisSurat->nama }}
                </h2>
            </div>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}"
                            class="text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400">Dashboard</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" viewBox="0 0 6 10"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <a href="{{ route('admin.master.jenis-surat.index') }}"
                                class="ms-1 text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400">Jenis
                                Surat</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" viewBox="0 0 6 10"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-sm font-medium text-gray-500 dark:text-gray-400">Form Dinamis</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </x-slot>

    @if (session('success'))
        <div id="alert-success"
            class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 border border-green-300 dark:border-green-800"
            role="alert">
            <div class="ms-3 text-sm font-medium">{{ session('success') }}</div>
            <button type="button"
                class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg p-1.5 hover:bg-green-200 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
                data-dismiss-target="#alert-success"><svg class="w-3 h-3" fill="none" viewBox="0 0 14 14"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg></button>
        </div>
    @endif

    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Daftar Field Kuesioner/Surat</h3>
            <button type="button" data-modal-target="add-field-modal" data-modal-toggle="add-field-modal"
                class="inline-flex items-center gap-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                        clip-rule="evenodd"></path>
                </svg>
                Tambah Field
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400 w-16">
                            Urutan</th>
                        <th class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Label /
                            Key</th>
                        <th class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Tipe
                        </th>
                        <th class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            Required</th>
                        <th class="p-4 text-xs font-medium text-gray-500 uppercase dark:text-gray-400 text-right">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    @forelse($fields as $field)
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <td
                                class="p-4 text-sm font-bold text-gray-900 whitespace-nowrap dark:text-white text-center">
                                {{ $field->urutan }}</td>
                            <td class="p-4 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <div class="font-bold">{{ $field->field_label }}</div>
                                <div class="text-xs text-blue-500 font-mono">{{ $field->field_key }}</div>
                            </td>
                            <td class="p-4 text-sm whitespace-nowrap">
                                <span
                                    class="px-2 py-1 text-xs font-bold rounded-lg bg-blue-100 text-blue-800 uppercase">{{ $field->field_type }}</span>
                            </td>
                            <td class="p-4 text-sm whitespace-nowrap">
                                <span
                                    class="px-2 py-1 text-xs font-bold rounded-lg {{ $field->is_required ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $field->is_required ? 'Wajib' : 'Opsional' }}
                                </span>
                            </td>
                            <td class="p-4 space-x-2 whitespace-nowrap text-right">
                                <button type="button" data-modal-target="edit-field-modal-{{ $field->id }}"
                                    data-modal-toggle="edit-field-modal-{{ $field->id }}"
                                    class="text-white bg-blue-600 hover:bg-blue-700 font-bold rounded-xl text-sm px-4 py-2 transition-all">Edit</button>
                                <form action="{{ route('admin.master.fields.destroy', [$jenisSurat, $field]) }}"
                                    method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin hapus?')"
                                        class="text-white bg-red-500 hover:bg-red-600 font-bold rounded-xl text-sm px-4 py-2 transition-all">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-500 dark:text-gray-400">Belum ada field
                                tambahan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Modal -->
    <div id="add-field-modal" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full transition-all duration-300">
        <div class="relative w-full max-w-2xl max-h-full" data-modal-content>
            <div
                class="relative bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl dark:bg-gray-800/90 border border-white/20 dark:border-gray-700/30">
                <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-700">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Tambah Field Dynamic</h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 rounded-xl text-sm w-9 h-9 ml-auto inline-flex justify-center items-center"
                        data-modal-hide="add-field-modal">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 14 14" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
                <form action="{{ route('admin.master.fields.store', $jenisSurat) }}" method="POST">
                    @csrf
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Label
                                    Field (Nama Field)</label>
                                <input type="text" name="field_label"
                                    class="js-field-label bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all"
                                    placeholder="Contoh: Nama Usaha" required>
                                <p class="mt-1 text-xs text-gray-500">Nama yang akan muncul di form masyarakat.</p>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">ID
                                    Field (Otomatis)</label>
                                <input type="text" name="field_key"
                                    class="js-field-key js-slug-target bg-gray-100 border border-gray-300 text-gray-500 text-sm rounded-xl block w-full p-3 dark:bg-gray-700/50 dark:border-gray-600 dark:text-gray-400"
                                    placeholder="nama_usaha" required>
                                <p class="mt-1 text-xs text-gray-400 italic">Terisi otomatis dari label.</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Tipe
                                    Input</label>
                                <select name="field_type"
                                    class="js-field-type bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="text">Teks Pendek</option>
                                    <option value="textarea">Teks Panjang (Paragraf)</option>
                                    <option value="number">Angka</option>
                                    <option value="date">Tanggal</option>
                                    <option value="select">Pilihan Dropdown</option>
                                    <option value="radio">Tombol Pilih Satu (Radio)</option>
                                    <option value="checkbox">Pilih Banyak (Checkbox)</option>
                                    <option value="file">Upload File Tambahan</option>
                                </select>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Urutan
                                    Tampil</label>
                                <input type="number" name="urutan" value="0"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    required>
                            </div>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Contoh Isi
                                (Placeholder)</label>
                            <input type="text" name="placeholder"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                placeholder="Masukkan nama usaha anda">
                        </div>

                        <!-- Options UI (Conditional) -->
                        <div
                            class="js-options-container hidden p-4 bg-blue-50/50 dark:bg-blue-900/20 rounded-2xl border border-blue-200 dark:border-blue-800/50">
                            <label class="block mb-3 text-sm font-bold text-blue-800 dark:text-blue-300">Daftar Pilihan
                                (Opsi)</label>
                            <div class="js-options-list space-y-2 mb-3">
                                <!-- Dynamic options here -->
                            </div>
                            <button type="button"
                                class="js-add-option text-sm text-blue-600 dark:text-blue-400 font-bold hover:underline flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" />
                                </svg>
                                Tambah Pilihan Baru
                            </button>
                        </div>

                        <!-- Validation UI (Simplified) -->
                        <div class="p-4 dark:bg-gray-900/40 rounded-2xl border border-gray-200 dark:border-gray-700">
                            <label class="block mb-3 text-sm font-bold text-gray-800 dark:text-gray-200">Aturan
                                Pengisian</label>
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="hidden" name="is_required" value="0">
                                    <input type="checkbox" name="is_required" value="1" checked
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-300">Wajib
                                        Diisi</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="val_numeric" value="1"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-300">Hanya
                                        Angka</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="val_email" value="1"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-300">Format
                                        Email</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="val_alphabet" value="1"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-300">Hanya
                                        Huruf</span>
                                </label>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block mb-1 text-xs font-semibold text-gray-500">Min Karakter</label>
                                    <input type="number" name="val_min"
                                        class="bg-white border border-gray-300 text-sm rounded-lg block w-full p-2 dark:bg-gray-600 dark:border-gray-500"
                                        placeholder="Contoh: 3">
                                </div>
                                <div>
                                    <label class="block mb-1 text-xs font-semibold text-gray-500">Max Karakter</label>
                                    <input type="number" name="val_max"
                                        class="bg-white border border-gray-300 text-sm rounded-lg block w-full p-2 dark:bg-gray-600 dark:border-gray-500"
                                        placeholder="Contoh: 100">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex items-center p-6 space-x-3 border-t border-gray-200 rounded-b dark:border-gray-700">
                        <button type="submit"
                            class="text-white bg-blue-600 hover:bg-blue-700 font-bold rounded-xl text-sm px-6 py-3 shadow-lg transition-all">Simpan
                            Field</button>
                        <button type="button" data-modal-hide="add-field-modal"
                            class="py-3 px-6 text-sm font-bold text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition-all">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($fields as $field)
        @php
            $rulesArray = explode('|', $field->validation_rules ?? '');
            $hasNumeric = in_array('numeric', $rulesArray);
            $hasEmail = in_array('email', $rulesArray);
            $hasAlpha = in_array('alpha', $rulesArray);
            $minVal = null;
            $maxVal = null;
            foreach ($rulesArray as $rule) {
                if (str_starts_with($rule, 'min:')) {
                    $minVal = str_replace('min:', '', $rule);
                }
                if (str_starts_with($rule, 'max:')) {
                    $maxVal = str_replace('max:', '', $rule);
                }
            }
        @endphp
        <!-- Edit Modal -->
        <div id="edit-field-modal-{{ $field->id }}" tabindex="-1" aria-hidden="true"
            class="fixed top-0 left-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full transition-all duration-300">
            <div class="relative w-full max-w-2xl max-h-full" data-modal-content>
                <div
                    class="relative bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl dark:bg-gray-800/90 border border-white/20 dark:border-gray-700/30">
                    <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-700">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Edit Field Dynamic</h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 rounded-xl text-sm w-9 h-9 ml-auto inline-flex justify-center items-center"
                            data-modal-hide="edit-field-modal-{{ $field->id }}">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 14 14" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>
                    <form action="{{ route('admin.master.fields.update', [$jenisSurat, $field]) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="p-6 space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Label
                                        Field</label>
                                    <input type="text" name="field_label" value="{{ $field->field_label }}"
                                        class="js-field-label bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        required>
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">ID
                                        Field (Read Only)</label>
                                    <input type="text" name="field_key" value="{{ $field->field_key }}"
                                        class="bg-gray-100 border border-gray-300 text-gray-500 text-sm rounded-xl block w-full p-3 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-400 cursor-not-allowed"
                                        readonly required>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Tipe
                                        Input</label>
                                    <select name="field_type"
                                        class="js-field-type bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <option value="text" {{ $field->field_type == 'text' ? 'selected' : '' }}>
                                            Teks Pendek</option>
                                        <option value="textarea"
                                            {{ $field->field_type == 'textarea' ? 'selected' : '' }}>Teks Panjang
                                        </option>
                                        <option value="number" {{ $field->field_type == 'number' ? 'selected' : '' }}>
                                            Angka</option>
                                        <option value="date" {{ $field->field_type == 'date' ? 'selected' : '' }}>
                                            Tanggal</option>
                                        <option value="select" {{ $field->field_type == 'select' ? 'selected' : '' }}>
                                            Pilihan Dropdown</option>
                                        <option value="radio" {{ $field->field_type == 'radio' ? 'selected' : '' }}>
                                            Tombol Pilih Satu</option>
                                        <option value="checkbox"
                                            {{ $field->field_type == 'checkbox' ? 'selected' : '' }}>Pilih Banyak
                                        </option>
                                        <option value="file" {{ $field->field_type == 'file' ? 'selected' : '' }}>
                                            Upload File</option>
                                    </select>
                                </div>
                                <div>
                                    <label
                                        class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Urutan</label>
                                    <input type="number" name="urutan" value="{{ $field->urutan }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        required>
                                </div>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Contoh
                                    Isi</label>
                                <input type="text" name="placeholder" value="{{ $field->placeholder }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>

                            <!-- Options UI (Conditional) -->
                            <div
                                class="js-options-container {{ in_array($field->field_type, ['select', 'radio', 'checkbox']) ? '' : 'hidden' }} p-4 bg-blue-50/50 dark:bg-blue-900/20 rounded-2xl border border-blue-200 dark:border-blue-800/50">
                                <label class="block mb-3 text-sm font-bold text-blue-800 dark:text-blue-300">Daftar
                                    Pilihan</label>
                                <div class="js-options-list space-y-2 mb-3">
                                    @if ($field->field_options)
                                        @foreach ($field->field_options as $opt)
                                            <div class="flex items-center gap-2">
                                                <input type="text" name="options[]" value="{{ $opt }}"
                                                    class="bg-white border border-gray-300 text-sm rounded-lg block w-full p-2 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                                                <button type="button"
                                                    class="js-remove-option text-red-500 hover:text-red-700"><svg
                                                        class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z"
                                                            clip-rule="evenodd" />
                                                    </svg></button>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <button type="button"
                                    class="js-add-option text-sm text-blue-600 dark:text-blue-400 font-bold hover:underline flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" />
                                    </svg>
                                    Tambah Pilihan Baru
                                </button>
                            </div>

                            <!-- Validation UI (Simplified) -->
                            <div
                                class="p-4 dark:bg-gray-700/50 rounded-2xl border border-gray-200 dark:border-gray-700">
                                <label class="block mb-3 text-sm font-bold text-gray-800 dark:text-gray-200">Aturan
                                    Pengisian</label>
                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="hidden" name="is_required" value="0">
                                        <input type="checkbox" name="is_required" value="1"
                                            {{ $field->is_required ? 'checked' : '' }}
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                        <span class="text-sm font-medium text-gray-900 dark:text-gray-300">Wajib
                                            Diisi</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" name="val_numeric" value="1"
                                            {{ $hasNumeric ? 'checked' : '' }}
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                        <span class="text-sm font-medium text-gray-900 dark:text-gray-300">Hanya
                                            Angka</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" name="val_email" value="1"
                                            {{ $hasEmail ? 'checked' : '' }}
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                        <span class="text-sm font-medium text-gray-900 dark:text-gray-300">Format
                                            Email</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" name="val_alphabet" value="1"
                                            {{ $hasAlpha ? 'checked' : '' }}
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                        <span class="text-sm font-medium text-gray-900 dark:text-gray-300">Hanya
                                            Huruf</span>
                                    </label>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block mb-1 text-xs font-semibold text-gray-500">Min
                                            Karakter</label>
                                        <input type="number" name="val_min" value="{{ $minVal }}"
                                            class="bg-white border border-gray-300 text-sm rounded-lg block w-full p-2 dark:bg-gray-600 dark:border-gray-500"
                                            placeholder="Contoh: 3">
                                    </div>
                                    <div>
                                        <label class="block mb-1 text-xs font-semibold text-gray-500">Max
                                            Karakter</label>
                                        <input type="number" name="val_max" value="{{ $maxVal }}"
                                            class="bg-white border border-gray-300 text-sm rounded-lg block w-full p-2 dark:bg-gray-600 dark:border-gray-500"
                                            placeholder="Contoh: 100">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="flex items-center p-6 space-x-3 border-t border-gray-200 rounded-b dark:border-gray-700">
                            <button type="submit"
                                class="text-white bg-blue-600 hover:bg-blue-700 font-bold rounded-xl text-sm px-6 py-3 shadow-lg transition-all">Update
                                Field</button>
                            <button type="button" data-modal-hide="edit-field-modal-{{ $field->id }}"
                                class="py-3 px-6 text-sm font-bold text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition-all">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Slugify function
                const slugify = (text) => {
                    return text.toString().toLowerCase()
                        .replace(/\s+/g, '_') // Replace spaces with _
                        .replace(/[^\w\-]+/g, '') // Remove all non-word chars
                        .replace(/\-\-+/g, '_') // Replace multiple - with single _
                        .replace(/^-+/, '') // Trim - from start of text
                        .replace(/-+$/, ''); // Trim - from end of text
                };

                // Handle Label to Key Auto-slugify
                document.querySelectorAll('.js-field-label').forEach(input => {
                    input.addEventListener('input', function() {
                        const form = this.closest('form');
                        const keyInput = form.querySelector('.js-field-key');
                        // Only auto-slugify if it's the ADD modal (we don't want to change keys in EDIT mode)
                        if (keyInput && keyInput.classList.contains('js-slug-target')) {
                            keyInput.value = slugify(this.value);
                        }
                    });
                });

                // Handle Field Type Change (Show/Hide Options)
                document.querySelectorAll('.js-field-type').forEach(select => {
                    select.addEventListener('change', function() {
                        const form = this.closest('form');
                        const optionsContainer = form.querySelector('.js-options-container');
                        const choiceTypes = ['select', 'radio', 'checkbox'];

                        if (choiceTypes.includes(this.value)) {
                            optionsContainer.classList.remove('hidden');
                            // Add an initial option if list is empty
                            const list = optionsContainer.querySelector('.js-options-list');
                            if (list.children.length === 0) {
                                addOption(list);
                            }
                        } else {
                            optionsContainer.classList.add('hidden');
                        }
                    });
                });

                // Dynamic Options Management
                const addOption = (list) => {
                    const div = document.createElement('div');
                    div.className = 'flex items-center gap-2';
                    div.innerHTML = `
                    <input type="text" name="options[]" class="bg-white border border-gray-300 text-sm rounded-lg block w-full p-2 dark:bg-gray-600 dark:border-gray-500 dark:text-white" placeholder="Masukkan pilihan">
                    <button type="button" class="js-remove-option text-red-500 hover:text-red-700">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/></svg>
                    </button>
                `;
                    list.appendChild(div);
                };

                document.addEventListener('click', function(e) {
                    if (e.target.closest('.js-add-option')) {
                        const list = e.target.closest('form').querySelector('.js-options-list');
                        addOption(list);
                    }
                    if (e.target.closest('.js-remove-option')) {
                        e.target.closest('.flex').remove();
                    }
                });

                // Modal Logic
                document.querySelectorAll('[data-modal-target]').forEach(button => {
                    button.addEventListener('click', () => {
                        const targetId = button.getAttribute('data-modal-target');
                        const modal = document.getElementById(targetId);
                        const content = modal?.querySelector('[data-modal-content]');
                        if (modal && content) {
                            setTimeout(() => {
                                content.classList.remove('scale-95', 'opacity-0');
                                content.classList.add('scale-100', 'opacity-100');
                            }, 10);
                        }
                    });
                });

                document.querySelectorAll('[data-modal-hide]').forEach(button => {
                    button.addEventListener('click', () => {
                        const targetId = button.getAttribute('data-modal-hide');
                        const modal = document.getElementById(targetId);
                        const content = modal?.querySelector('[data-modal-content]');
                        if (modal && content) {
                            content.classList.remove('scale-100', 'opacity-100');
                            content.classList.add('scale-95', 'opacity-0');
                        }
                    });
                });
            });
        </script>
    @endpush
</x-app-layout>
