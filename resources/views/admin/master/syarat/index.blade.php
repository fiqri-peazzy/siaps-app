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
                    Syarat Surat: {{ $jenisSurat->nama }}
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
                            <span class="ms-1 text-sm font-medium text-gray-500 dark:text-gray-400">Syarat</span>
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
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Daftar Syarat Dokumen</h3>
            <button type="button" data-modal-target="add-syarat-modal" data-modal-toggle="add-syarat-modal"
                class="inline-flex items-center gap-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                        clip-rule="evenodd"></path>
                </svg>
                Tambah Syarat
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Nama
                            Syarat</th>
                        <th class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            Required</th>
                        <th class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Max
                            Size</th>
                        <th class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Allowed
                            Types</th>
                        <th class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    @forelse($syarats as $syarat)
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <td class="p-4 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <div class="font-bold text-gray-900 dark:text-white">{{ $syarat->nama_syarat }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $syarat->deskripsi }}</div>
                            </td>
                            <td class="p-4 text-sm whitespace-nowrap">
                                <span
                                    class="px-2 py-1 text-xs font-bold rounded-lg {{ $syarat->is_required ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $syarat->is_required ? 'Wajib' : 'Opsional' }}
                                </span>
                            </td>
                            <td class="p-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                {{ $syarat->max_size_kb }} KB</td>
                            <td class="p-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                {{ $syarat->allowed_types }}</td>
                            <td class="p-4 space-x-2 whitespace-nowrap">
                                <button type="button" data-modal-target="edit-syarat-modal-{{ $syarat->id }}"
                                    data-modal-toggle="edit-syarat-modal-{{ $syarat->id }}"
                                    class="text-white bg-blue-600 hover:bg-blue-700 font-bold rounded-xl text-sm px-4 py-2 transition-all">Edit</button>
                                <form action="{{ route('admin.master.syarat.destroy', [$jenisSurat, $syarat]) }}"
                                    method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin hapus?')"
                                        class="text-white bg-red-500 hover:bg-red-600 font-bold rounded-xl text-sm px-4 py-2 transition-all">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-500 dark:text-gray-400">Belum ada syarat
                                dokumen.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Modal -->
    <div id="add-syarat-modal" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full transition-all duration-300">
        <div class="relative w-full max-w-2xl max-h-full" data-modal-content>
            <div
                class="relative bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl dark:bg-gray-800/90 border border-white/20 dark:border-gray-700/30">
                <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-700">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Tambah Syarat Surat</h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 rounded-xl text-sm w-9 h-9 ml-auto inline-flex justify-center items-center"
                        data-modal-hide="add-syarat-modal">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 14 14" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
                <form action="{{ route('admin.master.syarat.store', $jenisSurat) }}" method="POST">
                    @csrf
                    <div class="p-6 space-y-4 bg-white dark:bg-gray-800 rounded-b-2xl">
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Nama
                                Syarat</label>
                            <input type="text" name="nama_syarat"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                placeholder="Contoh: Fotocopy KTP" required>
                        </div>
                        <div>
                            <label
                                class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Deskripsi</label>
                            <textarea name="deskripsi" rows="2"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Wajib
                                    Diupload?</label>
                                <select name="is_required"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="1">Wajib</option>
                                    <option value="0">Opsional</option>
                                </select>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Max
                                    Size (KB)</label>
                                <input type="number" name="max_size_kb" value="2048"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    required>
                            </div>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Format
                                File (pisah koma)</label>
                            <input type="text" name="allowed_types" value="pdf,jpg,png,jpeg"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                required>
                        </div>
                    </div>
                    <div
                        class="flex items-center p-6 space-x-3 border-t border-gray-200 rounded-b dark:border-gray-700">
                        <button type="submit"
                            class="text-white bg-blue-600 hover:bg-blue-700 font-bold rounded-xl text-sm px-6 py-3 shadow-lg transition-all">Simpan</button>
                        <button type="button" data-modal-hide="add-syarat-modal"
                            class="py-3 px-6 text-sm font-bold text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition-all">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($syarats as $syarat)
        <!-- Edit Modal -->
        <div id="edit-syarat-modal-{{ $syarat->id }}" tabindex="-1" aria-hidden="true"
            class="fixed top-0 left-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full transition-all duration-300">
            <div class="relative w-full max-w-2xl max-h-full" data-modal-content>
                <div
                    class="relative bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl dark:bg-gray-800/90 border border-white/20 dark:border-gray-700/30">
                    <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-700">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Edit Syarat Surat</h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 rounded-xl text-sm w-9 h-9 ml-auto inline-flex justify-center items-center"
                            data-modal-hide="edit-syarat-modal-{{ $syarat->id }}">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 14 14" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>
                    <form action="{{ route('admin.master.syarat.update', [$jenisSurat, $syarat]) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="p-6 space-y-4 bg-white dark:bg-gray-800 rounded-b-2xl">
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Nama
                                    Syarat</label>
                                <input type="text" name="nama_syarat" value="{{ $syarat->nama_syarat }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    required>
                            </div>
                            <div>
                                <label
                                    class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Deskripsi</label>
                                <textarea name="deskripsi" rows="2"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ $syarat->deskripsi }}</textarea>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Wajib
                                        Diupload?</label>
                                    <select name="is_required"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        <option value="1" {{ $syarat->is_required ? 'selected' : '' }}>Wajib
                                        </option>
                                        <option value="0" {{ !$syarat->is_required ? 'selected' : '' }}>Opsional
                                        </option>
                                    </select>
                                </div>
                                <div>
                                    <label
                                        class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Max
                                        Size (KB)</label>
                                    <input type="number" name="max_size_kb" value="{{ $syarat->max_size_kb }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        required>
                                </div>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Format
                                    File (pisah koma)</label>
                                <input type="text" name="allowed_types" value="{{ $syarat->allowed_types }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    required>
                            </div>
                        </div>
                        <div
                            class="flex items-center p-6 space-x-3 border-t border-gray-200 rounded-b dark:border-gray-700">
                            <button type="submit"
                                class="text-white bg-blue-600 hover:bg-blue-700 font-bold rounded-xl text-sm px-6 py-3 shadow-lg transition-all">Update</button>
                            <button type="button" data-modal-hide="edit-syarat-modal-{{ $syarat->id }}"
                                class="py-3 px-6 text-sm font-bold text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition-all">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @push('scripts')
        <script>
            // Use the same modal logic as the main index
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
        </script>
    @endpush
</x-app-layout>
