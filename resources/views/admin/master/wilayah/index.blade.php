<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-y-2">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Manajemen Wilayah Administrative') }}</h2>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                            <svg class="w-3.5 h-3.5 me-2.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path
                                    d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center"><svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg><span class="ms-1 text-sm font-medium text-gray-500 dark:text-gray-400">Master
                                Data</span></div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center"><svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg><span class="ms-1 text-sm font-medium text-gray-500 dark:text-gray-400">Wilayah</span>
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
            <svg class="shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
            </svg>
            <div class="ms-3 text-sm font-medium">{{ session('success') }}</div>
            <button type="button"
                class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
                data-dismiss-target="#alert-success"><svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg></button>
        </div>
    @endif
    @if (session('error'))
        <div id="alert-error"
            class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 border border-red-300 dark:border-red-800"
            role="alert">
            <svg class="shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z" />
            </svg>
            <div class="ms-3 text-sm font-medium">{{ session('error') }}</div>
            <button type="button"
                class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700"
                data-dismiss-target="#alert-error"><svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg></button>
        </div>
    @endif

    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
        <!-- Table Header -->
        <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
            <div class="flex items-center mb-4 sm:mb-0">
                <form class="sm:pr-3" action="{{ route('admin.master.wilayah.index') }}" method="GET">
                    <label for="wilayah-search" class="sr-only">Search</label>
                    <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="text" name="search" id="wilayah-search" value="{{ request('search') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-9 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Cari wilayah...">
                    </div>
                </form>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-500 dark:text-gray-400">Total: <span
                        class="font-semibold text-gray-900 dark:text-white">{{ $wilayahs->count() }}</span> data</span>
                <button type="button" data-modal-target="add-wilayah-modal" data-modal-toggle="add-wilayah-modal"
                    class="inline-flex items-center gap-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Tambah Wilayah
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="flex flex-col mt-6">
            <div class="overflow-x-auto rounded-lg">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden shadow sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Tipe</th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Nama Wilayah</th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Induk / Atasan</th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Kode</th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Status</th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @forelse($wilayahs as $w)
                                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <td
                                            class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                            <span
                                                class="px-2 py-1 text-xs font-bold uppercase rounded-md {{ $w->tipe == 'desa' ? 'bg-purple-100 text-purple-800' : ($w->tipe == 'dusun' ? 'bg-blue-100 text-blue-800' : ($w->tipe == 'rw' ? 'bg-orange-100 text-orange-800' : 'bg-gray-100 text-gray-800')) }}">
                                                {{ $w->tipe }}
                                            </span>
                                        </td>
                                        <td
                                            class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $w->nama }}</td>
                                        <td class="p-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                            {{ $w->parent ? $w->parent->nama . ' (' . $w->parent->tipe . ')' : '-' }}
                                        </td>
                                        <td
                                            class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $w->kode ?? '-' }}</td>
                                        <td
                                            class="p-4 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            <div class="flex items-center">
                                                <div
                                                    class="h-2.5 w-2.5 rounded-full {{ $w->is_active ? 'bg-green-400' : 'bg-red-400' }} mr-2">
                                                </div>
                                                {{ $w->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </div>
                                        </td>
                                        <td class="p-4 space-x-2 whitespace-nowrap">
                                            <button type="button"
                                                data-modal-target="edit-wilayah-modal-{{ $w->id }}"
                                                data-modal-toggle="edit-wilayah-modal-{{ $w->id }}"
                                                class="inline-flex items-center px-4 py-2 text-sm font-bold text-center text-white rounded-xl bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-all shadow-md hover:shadow-blue-500/20 active:scale-95">
                                                Edit
                                            </button>
                                            <form action="{{ route('admin.master.wilayah.destroy', $w) }}"
                                                method="POST" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" onclick="return confirm('Yakin hapus?')"
                                                    class="inline-flex items-center px-4 py-2 text-sm font-bold text-center text-white bg-red-500 rounded-xl hover:bg-red-600 focus:ring-4 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 transition-all shadow-md hover:shadow-red-500/20 active:scale-95">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="p-4 text-center text-gray-500 dark:text-gray-400">
                                            Data
                                            belum ada.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div id="add-wilayah-modal" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full transition-all duration-300 ease-out">
        <div class="relative w-full max-w-2xl max-h-full transition-transform duration-300 ease-out transform scale-95 opacity-0"
            data-modal-content>
            <div
                class="relative bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl dark:bg-gray-800/90 border border-white/20 dark:border-gray-700/30">
                <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-700">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Tambah Wilayah</h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-xl text-sm w-9 h-9 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-700 dark:hover:text-white transition-colors"
                        data-modal-hide="add-wilayah-modal">
                        <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
                <form action="{{ route('admin.master.wilayah.store') }}" method="POST">
                    @csrf
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Tipe
                                    Wilayah</label>
                                <select name="tipe"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all outline-none"
                                    required>
                                    <option value="desa">Desa</option>
                                    <option value="dusun">Dusun</option>
                                    <option value="rw">RW</option>
                                    <option value="rt">RT</option>
                                </select>
                            </div>
                            <div>
                                <label
                                    class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Wilayah
                                    Induk (Optional)</label>
                                <select name="parent_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all outline-none">
                                    <option value="">-- Tanpa Induk --</option>
                                    @foreach ($parents as $p)
                                        <option value="{{ $p->id }}">{{ $p->nama }}
                                            ({{ $p->tipe }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Nama
                                    Wilayah</label>
                                <input type="text" name="nama"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all outline-none"
                                    placeholder="Dusun I / RW 01 / RT 001" required>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Kode
                                    Wilayah</label>
                                <input type="text" name="kode"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all outline-none"
                                    placeholder="73.xx.xx.xxxx">
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex items-center p-6 space-x-3 border-t border-gray-200 rounded-b dark:border-gray-700">
                        <button type="submit"
                            class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-xl text-sm px-6 py-3 text-center dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800 transition-all shadow-lg hover:shadow-blue-500/30 shadow-blue-500/20">Simpan</button>
                        <button type="button" data-modal-hide="add-wilayah-modal"
                            class="py-3 px-6 text-sm font-bold text-gray-700 focus:outline-none bg-gray-100 rounded-xl border border-gray-200 hover:bg-gray-200 dark:focus:ring-gray-700 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-600 transition-all">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($wilayahs as $w)
        <!-- Edit Modal -->
        <div id="edit-wilayah-modal-{{ $w->id }}" tabindex="-1" aria-hidden="true"
            class="fixed top-0 left-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full transition-all duration-300 ease-out">
            <div class="relative w-full max-w-2xl max-h-full transition-transform duration-300 ease-out transform scale-95 opacity-0"
                data-modal-content>
                <div
                    class="relative bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl dark:bg-gray-800/90 border border-white/20 dark:border-gray-700/30">
                    <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-700">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Edit Wilayah</h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-xl text-sm w-9 h-9 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-700 dark:hover:text-white transition-colors"
                            data-modal-hide="edit-wilayah-modal-{{ $w->id }}">
                            <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>
                    <form action="{{ route('admin.master.wilayah.update', $w) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="p-6 space-y-6">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Tipe
                                        Wilayah</label>
                                    <select name="tipe"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all outline-none"
                                        required>
                                        <option value="desa" {{ $w->tipe == 'desa' ? 'selected' : '' }}>Desa
                                        </option>
                                        <option value="dusun" {{ $w->tipe == 'dusun' ? 'selected' : '' }}>Dusun
                                        </option>
                                        <option value="rw" {{ $w->tipe == 'rw' ? 'selected' : '' }}>RW</option>
                                        <option value="rt" {{ $w->tipe == 'rt' ? 'selected' : '' }}>RT</option>
                                    </select>
                                </div>
                                <div>
                                    <label
                                        class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Wilayah
                                        Induk</label>
                                    <select name="parent_id"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all outline-none">
                                        <option value="">-- Tanpa Induk --</option>
                                        @foreach ($parents as $p)
                                            @if ($p->id != $w->id)
                                                <option value="{{ $p->id }}"
                                                    {{ $w->parent_id == $p->id ? 'selected' : '' }}>
                                                    {{ $p->nama }} ({{ $p->tipe }})</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Nama
                                        Wilayah</label>
                                    <input type="text" name="nama" value="{{ $w->nama }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all outline-none"
                                        required>
                                </div>
                                <div>
                                    <label
                                        class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Kode
                                        Wilayah</label>
                                    <input type="text" name="kode" value="{{ $w->kode }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all outline-none">
                                </div>
                            </div>
                            <div>
                                <label
                                    class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Status</label>
                                <select name="is_active"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all outline-none">
                                    <option value="1" {{ $w->is_active ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ !$w->is_active ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                            </div>
                        </div>
                        <div
                            class="flex items-center p-6 space-x-3 border-t border-gray-200 rounded-b dark:border-gray-700">
                            <button type="submit"
                                class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-xl text-sm px-6 py-3 text-center dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800 transition-all shadow-lg hover:shadow-blue-500/30 shadow-blue-500/20">Update</button>
                            <button type="button" data-modal-hide="edit-wilayah-modal-{{ $w->id }}"
                                class="py-3 px-6 text-sm font-bold text-gray-700 focus:outline-none bg-gray-100 rounded-xl border border-gray-200 hover:bg-gray-200 dark:focus:ring-gray-700 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-600 transition-all">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @push('scripts')
        <script>
            // Premium Modal Animation
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
