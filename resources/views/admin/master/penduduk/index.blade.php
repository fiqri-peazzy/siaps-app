<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-y-2">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Manajemen Data Penduduk') }}</h2>
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
                            </svg><span
                                class="ms-1 text-sm font-medium text-gray-500 dark:text-gray-400">Penduduk</span></div>
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
                <form class="sm:pr-3" action="{{ route('admin.master.penduduk.index') }}" method="GET">
                    <label for="penduduk-search" class="sr-only">Search</label>
                    <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="text" name="search" id="penduduk-search" value="{{ request('search') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-9 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Cari NIK / Nama...">
                    </div>
                </form>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-500 dark:text-gray-400">Total: <span
                        class="font-semibold text-gray-900 dark:text-white">{{ $penduduks->total() }}</span> data</span>
                <button type="button" data-modal-target="add-penduduk-modal" data-modal-toggle="add-penduduk-modal"
                    class="inline-flex items-center gap-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Tambah Penduduk
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
                                        NIK / No KK</th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Nama Lengkap</th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        L/P</th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        RT</th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Status</th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Sumber Data</th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @forelse($penduduks as $p)
                                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                        <td class="p-4 text-sm font-medium text-gray-900 dark:text-white">
                                            <div class="flex flex-col">
                                                <span class="font-bold">{{ $p->nik }}</span>
                                                <span class="text-xs text-gray-500">{{ $p->no_kk }}</span>
                                            </div>
                                        </td>
                                        <td class="p-4 text-sm font-medium text-gray-900 dark:text-white">
                                            <div class="flex flex-col gap-1">
                                                <span>{{ $p->nama_lengkap }}</span>
                                                <div class="flex flex-wrap gap-1 mt-1">
                                                    @if ($p->is_aktif)
                                                        <span
                                                            class="bg-green-100 text-green-800 text-[10px] font-bold px-1.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300 uppercase">AKTIF</span>
                                                    @else
                                                        <span
                                                            class="bg-red-100 text-red-800 text-[10px] font-bold px-1.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300 uppercase">NONAKTIF</span>
                                                    @endif

                                                    @if ($p->biodata)
                                                        @if ($p->biodata->is_disabilitas)
                                                            <span
                                                                class="bg-purple-100 text-purple-800 text-[10px] font-bold px-1.5 py-0.5 rounded dark:bg-purple-900 dark:text-purple-300">DISABILITAS</span>
                                                        @endif
                                                        @if ($p->biodata->is_hamil)
                                                            <span
                                                                class="bg-pink-100 text-pink-800 text-[10px] font-bold px-1.5 py-0.5 rounded dark:bg-pink-900 dark:text-pink-300">HAMIL</span>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td
                                            class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $p->jenis_kelamin }}</td>
                                        <td
                                            class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $p->rt ? $p->rt->nama : '-' }}</td>
                                        <td
                                            class="p-4 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            @if ($p->biodata)
                                                <span
                                                    class="inline-flex items-center bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">
                                                    <svg class="w-2.5 h-2.5 me-1.5" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z" />
                                                    </svg>
                                                    System (Verified)
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-gray-700 dark:text-gray-300">
                                                    <svg class="w-2.5 h-2.5 me-1.5" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.707 11.707a1 1 0 0 1-1.414 0L10 9.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 8l-2.293-2.293a1 1 0 0 1 1.414-1.414L10 6.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 8l2.293 2.293Z" />
                                                    </svg>
                                                    Manual (Admin)
                                                </span>
                                            @endif
                                        </td>
                                        <td class="p-4 space-x-2 whitespace-nowrap">
                                            <button type="button"
                                                data-modal-target="detail-penduduk-modal-{{ $p->id }}"
                                                data-modal-toggle="detail-penduduk-modal-{{ $p->id }}"
                                                class="inline-flex items-center px-4 py-2 text-sm font-bold text-center text-gray-900 bg-white border border-gray-300 rounded-xl hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 transition-all shadow-sm active:scale-95">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                Detail
                                            </button>
                                            <button type="button"
                                                data-modal-target="edit-penduduk-modal-{{ $p->id }}"
                                                data-modal-toggle="edit-penduduk-modal-{{ $p->id }}"
                                                class="inline-flex items-center px-4 py-2 text-sm font-bold text-center text-white rounded-xl bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 transition-all shadow-md hover:shadow-blue-500/20 active:scale-95">
                                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                    <path fill-rule="evenodd"
                                                        d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Edit
                                            </button>
                                            <form action="{{ route('admin.master.penduduk.destroy', $p) }}"
                                                method="POST" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" onclick="return confirm('Yakin hapus?')"
                                                    class="inline-flex items-center px-4 py-2 text-sm font-bold text-center text-white bg-red-500 rounded-xl hover:bg-red-600 focus:ring-4 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 transition-all shadow-md hover:shadow-red-500/20 active:scale-95">
                                                    <svg class="w-4 h-4 mr-2" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                            clip-rule="evenodd" />
                                                    </svg>
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
        <div class="mt-4">
            {{ $penduduks->links() }}
        </div>
    </div>

    <!-- Add Modal -->
    <div id="add-penduduk-modal" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-4xl max-h-full">
            <div
                class="relative bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl dark:bg-gray-800/90 border border-white/20 dark:border-gray-700/30">
                <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-700">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Tambah Data Penduduk</h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-xl text-sm w-9 h-9 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-700 dark:hover:text-white transition-colors"
                        data-modal-hide="add-penduduk-modal">
                        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
                <form action="{{ route('admin.master.penduduk.store') }}" method="POST">
                    @csrf
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label
                                    class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">NIK</label>
                                <input type="text" name="nik" maxlength="16"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all"
                                    required>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">No
                                    KK</label>
                                <input type="text" name="no_kk" maxlength="16"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all"
                                    required>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Nama
                                    Lengkap</label>
                                <input type="text" name="nama_lengkap"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all"
                                    required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Tempat
                                    Lahir</label>
                                <input type="text" name="tempat_lahir"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all"
                                    required>
                            </div>
                            <div>
                                <label
                                    class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Tanggal
                                    Lahir</label>
                                <input type="date" name="tanggal_lahir"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all"
                                    required>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Jenis
                                    Kelamin</label>
                                <select name="jenis_kelamin"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all"
                                    required>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label
                                    class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Agama</label>
                                <select name="agama_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all"
                                    required>
                                    @foreach ($agamas as $a)
                                        <option value="{{ $a->id }}">{{ $a->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label
                                    class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Pekerjaan</label>
                                <select name="pekerjaan_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all"
                                    required>
                                    @foreach ($pekerjaans as $pk)
                                        <option value="{{ $pk->id }}">{{ $pk->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Status
                                    Perkawinan</label>
                                <select name="status_perkawinan"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all"
                                    required>
                                    <option value="belum_kawin">Belum Kawin</option>
                                    <option value="kawin">Kawin</option>
                                    <option value="cerai_hidup">Cerai Hidup</option>
                                    <option value="cerai_mati">Cerai Mati</option>
                                </select>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Status
                                    Dalam KK</label>
                                <select name="status_dalam_kk"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all"
                                    required>
                                    <option value="kepala_keluarga">Kepala Keluarga</option>
                                    <option value="istri">Istri</option>
                                    <option value="anak">Anak</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label
                                    class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">RT</label>
                                <select name="rt_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all"
                                    required>
                                    @foreach ($rts as $rt)
                                        <option value="{{ $rt->id }}">{{ $rt->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Status
                                    Penduduk</label>
                                <select name="status_penduduk"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all"
                                    required>
                                    <option value="tetap">Tetap</option>
                                    <option value="sementara">Sementara</option>
                                    <option value="tinggal">Tinggal</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Status
                                    Aktif</label>
                                <select name="is_aktif"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all">
                                    <option value="1">Aktif</option>
                                    <option value="0">Nonaktif</option>
                                </select>
                            </div>
                            <div>
                                <label
                                    class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Golongan
                                    Darah</label>
                                <select name="golongan_darah"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all">
                                    <option value="tidak_tahu">Tidak Tahu</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="AB">AB</option>
                                    <option value="O">O</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label
                                class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Kewarganegaraan</label>
                            <input type="text" name="kewarganegaraan" value="WNI"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all"
                                required>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Alamat
                                Lengkap</label>
                            <textarea name="alamat_lengkap" rows="3"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all"
                                required></textarea>
                        </div>
                    </div>
                    <div
                        class="flex items-center p-6 space-x-3 border-t border-gray-200 rounded-b dark:border-gray-700">
                        <button type="submit"
                            class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-xl text-sm px-6 py-3 text-center dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800 transition-all shadow-lg hover:shadow-blue-500/30 shadow-blue-500/20">Simpan</button>
                        <button type="button" data-modal-hide="add-penduduk-modal"
                            class="py-3 px-6 text-sm font-bold text-gray-700 focus:outline-none bg-gray-100 rounded-xl border border-gray-200 hover:bg-gray-200 dark:focus:ring-gray-700 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-600 transition-all">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($penduduks as $p)
        <!-- Edit Modal similar to Add Modal with values -->
        <div id="edit-penduduk-modal-{{ $p->id }}" tabindex="-1" aria-hidden="true"
            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-4xl max-h-full">
                <div
                    class="relative bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl dark:bg-gray-800/90 border border-white/20 dark:border-gray-700/30">
                    <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-700">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Edit Data Penduduk</h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-xl text-sm w-9 h-9 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-700 dark:hover:text-white transition-colors"
                            data-modal-hide="edit-penduduk-modal-{{ $p->id }}">
                            <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>
                    <form action="{{ route('admin.master.penduduk.update', $p) }}" method="POST">
                        @csrf @method('PUT')
                        <!-- ... (same fields as Add Modal but with values) ... -->
                        <div class="p-6 space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label
                                        class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">NIK</label>
                                    <input type="text" name="nik" value="{{ $p->nik }}" maxlength="16"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all"
                                        required>
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">No
                                        KK</label>
                                    <input type="text" name="no_kk" value="{{ $p->no_kk }}" maxlength="16"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all"
                                        required>
                                </div>
                                <div>
                                    <label
                                        class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Nama
                                        Lengkap</label>
                                    <input type="text" name="nama_lengkap" value="{{ $p->nama_lengkap }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all"
                                        required>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label
                                        class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Tempat
                                        Lahir</label>
                                    <input type="text" name="tempat_lahir" value="{{ $p->tempat_lahir }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all"
                                        required>
                                </div>
                                <div>
                                    <label
                                        class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Tanggal
                                        Lahir</label>
                                    <input type="date" name="tanggal_lahir"
                                        value="{{ $p->tanggal_lahir->format('Y-m-d') }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all"
                                        required>
                                </div>
                                <div>
                                    <label
                                        class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Jenis
                                        Kelamin</label>
                                    <select name="jenis_kelamin"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all"
                                        required>
                                        <option value="L" {{ $p->jenis_kelamin == 'L' ? 'selected' : '' }}>
                                            Laki-laki</option>
                                        <option value="P" {{ $p->jenis_kelamin == 'P' ? 'selected' : '' }}>
                                            Perempuan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label
                                        class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Agama</label>
                                    <select name="agama_id"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all"
                                        required>
                                        @foreach ($agamas as $a)
                                            <option value="{{ $a->id }}"
                                                {{ $p->agama_id == $a->id ? 'selected' : '' }}>{{ $a->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label
                                        class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Pekerjaan</label>
                                    <select name="pekerjaan_id"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all"
                                        required>
                                        @foreach ($pekerjaans as $pk)
                                            <option value="{{ $pk->id }}"
                                                {{ $p->pekerjaan_id == $pk->id ? 'selected' : '' }}>
                                                {{ $pk->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label
                                        class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Status
                                        Perkawinan</label>
                                    <select name="status_perkawinan"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all"
                                        required>
                                        <option value="belum_kawin"
                                            {{ $p->status_perkawinan == 'belum_kawin' ? 'selected' : '' }}>Belum Kawin
                                        </option>
                                        <option value="kawin"
                                            {{ $p->status_perkawinan == 'kawin' ? 'selected' : '' }}>Kawin</option>
                                        <option value="cerai_hidup"
                                            {{ $p->status_perkawinan == 'cerai_hidup' ? 'selected' : '' }}>Cerai Hidup
                                        </option>
                                        <option value="cerai_mati"
                                            {{ $p->status_perkawinan == 'cerai_mati' ? 'selected' : '' }}>Cerai Mati
                                        </option>
                                    </select>
                                </div>
                                <div>
                                    <label
                                        class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Status
                                        Dalam KK</label>
                                    <select name="status_dalam_kk"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all"
                                        required>
                                        <option value="kepala_keluarga"
                                            {{ $p->status_dalam_kk == 'kepala_keluarga' ? 'selected' : '' }}>Kepala
                                            Keluarga</option>
                                        <option value="istri" {{ $p->status_dalam_kk == 'istri' ? 'selected' : '' }}>
                                            Istri</option>
                                        <option value="anak" {{ $p->status_dalam_kk == 'anak' ? 'selected' : '' }}>
                                            Anak</option>
                                        <option value="lainnya"
                                            {{ $p->status_dalam_kk == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label
                                        class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">RT</label>
                                    <select name="rt_id"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all"
                                        required>
                                        @foreach ($rts as $rt)
                                            <option value="{{ $rt->id }}"
                                                {{ $p->rt_id == $rt->id ? 'selected' : '' }}>{{ $rt->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label
                                        class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Status
                                        Penduduk</label>
                                    <select name="status_penduduk"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all"
                                        required>
                                        <option value="tetap" {{ $p->status_penduduk == 'tetap' ? 'selected' : '' }}>
                                            Tetap</option>
                                        <option value="sementara"
                                            {{ $p->status_penduduk == 'sementara' ? 'selected' : '' }}>Sementara
                                        </option>
                                        <option value="tinggal"
                                            {{ $p->status_penduduk == 'tinggal' ? 'selected' : '' }}>Tinggal</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label
                                        class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Status
                                        Aktif</label>
                                    <select name="is_aktif"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all">
                                        <option value="1" {{ $p->is_aktif ? 'selected' : '' }}>Aktif</option>
                                        <option value="0" {{ !$p->is_aktif ? 'selected' : '' }}>Nonaktif</option>
                                    </select>
                                </div>
                                <div>
                                    <label
                                        class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Golongan
                                        Darah</label>
                                    <select name="golongan_darah"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all">
                                        <option value="tidak_tahu"
                                            {{ $p->golongan_darah == 'tidak_tahu' ? 'selected' : '' }}>Tidak Tahu
                                        </option>
                                        <option value="A" {{ $p->golongan_darah == 'A' ? 'selected' : '' }}>A
                                        </option>
                                        <option value="B" {{ $p->golongan_darah == 'B' ? 'selected' : '' }}>B
                                        </option>
                                        <option value="AB" {{ $p->golongan_darah == 'AB' ? 'selected' : '' }}>AB
                                        </option>
                                        <option value="O" {{ $p->golongan_darah == 'O' ? 'selected' : '' }}>O
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label
                                    class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Kewarganegaraan</label>
                                <input type="text" name="kewarganegaraan" value="{{ $p->kewarganegaraan }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all"
                                    required>
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-gray-200">Alamat
                                    Lengkap</label>
                                <textarea name="alamat_lengkap" rows="3"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all"
                                    required>{{ $p->alamat_lengkap }}</textarea>
                            </div>
                        </div>
                        <div
                            class="flex items-center p-6 space-x-3 border-t border-gray-200 rounded-b dark:border-gray-700">
                            <button type="submit"
                                class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-xl text-sm px-6 py-3 text-center dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800 transition-all shadow-lg hover:shadow-blue-500/30 shadow-blue-500/20">Update</button>
                            <button type="button" data-modal-hide="edit-penduduk-modal-{{ $p->id }}"
                                class="py-3 px-6 text-sm font-bold text-gray-700 focus:outline-none bg-gray-100 rounded-xl border border-gray-200 hover:bg-gray-200 dark:focus:ring-gray-700 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-600 transition-all">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Detail Modal -->
        <div id="detail-penduduk-modal-{{ $p->id }}" tabindex="-1" aria-hidden="true"
            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-4xl max-h-full text-left">
                <div
                    class="relative bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl dark:bg-gray-800/90 border border-white/20 dark:border-gray-700/30 overflow-hidden">
                    <div
                        class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-700 bg-blue-600 dark:bg-blue-700">
                        <h3 class="text-xl font-bold text-white">Detail Data Penduduk</h3>
                        <button type="button"
                            class="text-white bg-transparent hover:bg-white/20 rounded-xl text-sm w-9 h-9 ml-auto inline-flex justify-center items-center transition-colors"
                            data-modal-hide="detail-penduduk-modal-{{ $p->id }}">
                            <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>
                    <div class="p-6 space-y-6 bg-gray-50/50 dark:bg-gray-900/50">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Basic Info -->
                            <div class="space-y-4">
                                <h4
                                    class="text-sm font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">
                                    Informasi Dasar</h4>
                                <div class="grid grid-cols-3 gap-2">
                                    <div class="text-xs text-gray-500 dark:text-gray-400">NIK</div>
                                    <div class="col-span-2 text-sm font-bold text-gray-900 dark:text-white">
                                        {{ $p->nik }}</div>

                                    <div class="text-xs text-gray-500 dark:text-gray-400">No KK</div>
                                    <div class="col-span-2 text-sm font-bold text-gray-900 dark:text-white">
                                        {{ $p->no_kk }}</div>

                                    <div class="text-xs text-gray-500 dark:text-gray-400">Nama</div>
                                    <div class="col-span-2 text-sm font-bold text-gray-900 dark:text-white">
                                        {{ $p->nama_lengkap }}</div>

                                    <div class="text-xs text-gray-500 dark:text-gray-400">TTL</div>
                                    <div class="col-span-2 text-sm text-gray-900 dark:text-white">
                                        {{ $p->tempat_lahir }}, {{ $p->tanggal_lahir->format('d F Y') }}</div>

                                    <div class="text-xs text-gray-500 dark:text-gray-400">Gender</div>
                                    <div class="col-span-2 text-sm text-gray-900 dark:text-white">
                                        {{ $p->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</div>

                                    <div class="text-xs text-gray-500 dark:text-gray-400">Agama</div>
                                    <div class="col-span-2 text-sm text-gray-900 dark:text-white">
                                        {{ $p->agama ? $p->agama->nama : '-' }}</div>

                                    <div class="text-xs text-gray-500 dark:text-gray-400">Status</div>
                                    <div class="col-span-2">
                                        @if ($p->is_aktif)
                                            <span
                                                class="bg-green-100 text-green-800 text-[10px] font-bold px-2 py-0.5 rounded dark:bg-green-900 dark:text-green-300">AKTIF</span>
                                        @else
                                            <span
                                                class="bg-red-100 text-red-800 text-[10px] font-bold px-2 py-0.5 rounded dark:bg-red-900 dark:text-red-300">NONAKTIF</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Info -->
                            <div class="space-y-4">
                                <h4
                                    class="text-sm font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">
                                    Pekerjaan & Status</h4>
                                <div class="grid grid-cols-3 gap-2">
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Pekerjaan</div>
                                    <div class="col-span-2 text-sm text-gray-900 dark:text-white">
                                        {{ $p->pekerjaan ? $p->pekerjaan->nama : '-' }}</div>

                                    <div class="text-xs text-gray-500 dark:text-gray-400">Pernikahan</div>
                                    <div class="col-span-2 text-sm text-gray-900 dark:text-white">
                                        {{ str_replace('_', ' ', ucwords($p->status_perkawinan)) }}</div>

                                    <div class="text-xs text-gray-500 dark:text-gray-400">Status Penduduk</div>
                                    <div class="col-span-2 text-sm text-gray-900 dark:text-white">
                                        {{ ucfirst($p->status_penduduk) }}</div>

                                    <div class="text-xs text-gray-500 dark:text-gray-400">RT</div>
                                    <div class="col-span-2 text-sm text-gray-900 dark:text-white">
                                        {{ $p->rt ? $p->rt->nama : '-' }}</div>

                                    <div class="text-xs text-gray-500 dark:text-gray-400">Darah</div>
                                    <div class="col-span-2 text-sm text-gray-900 dark:text-white">
                                        {{ strtoupper(str_replace('_', ' ', $p->golongan_darah)) }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="border-t pt-6 dark:border-gray-700">
                            <h4
                                class="text-sm font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider mb-4">
                                Alamat</h4>
                            <p
                                class="text-sm text-gray-900 dark:text-white leading-relaxed bg-white dark:bg-gray-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700">
                                {{ $p->alamat_lengkap }}
                            </p>
                        </div>

                        @if ($p->biodata)
                            <div class="border-t pt-6 dark:border-gray-700">
                                <h4
                                    class="text-sm font-bold text-purple-600 dark:text-purple-400 uppercase tracking-wider mb-4">
                                    Informasi Tambahan (User System)</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-xl">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-xs text-gray-500 dark:text-gray-400">Disabilitas</span>
                                            <span
                                                class="text-sm font-bold {{ $p->biodata->is_disabilitas ? 'text-red-500' : 'text-green-500' }}">{{ $p->biodata->is_disabilitas ? 'YA' : 'TIDAK' }}</span>
                                        </div>
                                        @if ($p->biodata->is_disabilitas)
                                            <p class="text-xs text-gray-600 dark:text-gray-300">Jenis:
                                                {{ $p->biodata->jenis_disabilitas }}</p>
                                        @endif
                                    </div>
                                    <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-xl">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-xs text-gray-500 dark:text-gray-400">Hamil</span>
                                            <span
                                                class="text-sm font-bold {{ $p->biodata->is_hamil ? 'text-pink-500' : 'text-green-500' }}">{{ $p->biodata->is_hamil ? 'YA' : 'TIDAK' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 grid grid-cols-2 gap-4">
                                    @if ($p->biodata->foto_ktp)
                                        <div class="space-y-2">
                                            <span class="text-xs text-gray-500 dark:text-gray-400">Foto KTP</span>
                                            <a href="{{ asset('storage/' . $p->biodata->foto_ktp) }}" target="_blank"
                                                class="block group relative overflow-hidden rounded-xl border-2 border-gray-200 dark:border-gray-700">
                                                <img src="{{ asset('storage/' . $p->biodata->foto_ktp) }}"
                                                    class="h-32 w-full object-cover transition-transform group-hover:scale-110"
                                                    alt="KTP">
                                                <div
                                                    class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <span class="text-white text-xs font-bold">Lihat</span>
                                                </div>
                                            </a>
                                        </div>
                                    @endif
                                    @if ($p->biodata->foto_kk)
                                        <div class="space-y-2">
                                            <span class="text-xs text-gray-500 dark:text-gray-400">Foto KK</span>
                                            <a href="{{ asset('storage/' . $p->biodata->foto_kk) }}" target="_blank"
                                                class="block group relative overflow-hidden rounded-xl border-2 border-gray-200 dark:border-gray-700">
                                                <img src="{{ asset('storage/' . $p->biodata->foto_kk) }}"
                                                    class="h-32 w-full object-cover transition-transform group-hover:scale-110"
                                                    alt="KK">
                                                <div
                                                    class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <span class="text-white text-xs font-bold">Lihat</span>
                                                </div>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</x-app-layout>
