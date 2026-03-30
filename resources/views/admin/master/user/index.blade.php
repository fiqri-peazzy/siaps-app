<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-y-2">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Manajemen Semua User') }}</h2>
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
                            </svg><span class="ms-1 text-sm font-medium text-gray-500 dark:text-gray-400">Manajemen
                                User</span></div>
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
                <form class="flex items-center gap-2" action="{{ route('admin.master.users.index') }}" method="GET">
                    <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-9 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                            placeholder="Cari Nama / Username / Email...">
                    </div>
                    <select name="role" onchange="this.form.submit()"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">Semua Role</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="kepala_desa" {{ request('role') == 'kepala_desa' ? 'selected' : '' }}>Kades
                        </option>
                        <option value="masyarakat" {{ request('role') == 'masyarakat' ? 'selected' : '' }}>Masyarakat
                        </option>
                    </select>
                </form>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-500 dark:text-gray-400">Total: <span
                        class="font-semibold text-gray-900 dark:text-white">{{ $users->total() }}</span> data</span>
                <button type="button" data-modal-target="add-user-modal" data-modal-toggle="add-user-modal"
                    class="inline-flex items-center gap-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 transition-all shadow-lg active:scale-95">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Tambah User
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
                                        Nama / Role</th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Kontak (Email/Username)</th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        No. Telepon</th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Status</th>
                                    <th scope="col"
                                        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @forelse($users as $user)
                                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                        <td class="p-4 text-sm font-medium text-gray-900 dark:text-white">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="h-8 w-8 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-blue-600 dark:text-blue-300 font-bold uppercase">
                                                    {{ substr($user->name, 0, 1) }}
                                                </div>
                                                <div class="flex flex-col">
                                                    <span class="font-bold">{{ $user->name }}</span>
                                                    @if ($user->role === 'admin')
                                                        <span
                                                            class="text-[10px] text-red-600 dark:text-red-400 font-black uppercase tracking-wider">ADMINISTRATOR</span>
                                                    @elseif($user->role === 'kepala_desa')
                                                        <span
                                                            class="text-[10px] text-blue-600 dark:text-blue-400 font-black uppercase tracking-wider">KEPALA
                                                            DESA</span>
                                                    @else
                                                        <span
                                                            class="text-[10px] text-gray-500 dark:text-gray-400 font-black uppercase tracking-wider">MASYARAKAT</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="p-4 text-sm font-medium text-gray-900 dark:text-white">
                                            <div class="flex flex-col">
                                                <span class="font-medium">{{ $user->email }}</span>
                                                <span class="text-xs text-gray-500">@ {{ $user->username }}</span>
                                            </div>
                                        </td>
                                        <td class="p-4 text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $user->phone ?? '-' }}
                                        </td>
                                        <td class="p-4">
                                            @if ($user->status === 'active')
                                                <span
                                                    class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">AKTIF</span>
                                            @elseif($user->status === 'inactive')
                                                <span
                                                    class="bg-gray-100 text-gray-800 text-xs font-bold px-2.5 py-0.5 rounded-full dark:bg-gray-700 dark:text-gray-300">NONAKTIF</span>
                                            @else
                                                <span
                                                    class="bg-red-100 text-red-800 text-xs font-bold px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">SUSPENDED</span>
                                            @endif
                                        </td>
                                        <td class="p-4 space-x-2 whitespace-nowrap">
                                            <button type="button"
                                                data-modal-target="edit-user-modal-{{ $user->id }}"
                                                data-modal-toggle="edit-user-modal-{{ $user->id }}"
                                                class="inline-flex items-center px-4 py-2 text-sm font-bold text-center text-white rounded-xl bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 transition-all shadow-md hover:shadow-blue-500/20 active:scale-95">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                    <path fill-rule="evenodd"
                                                        d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Edit
                                            </button>
                                            <form action="{{ route('admin.master.users.destroy', $user) }}"
                                                method="POST" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Yakin hapus user ini?')"
                                                    class="inline-flex items-center px-4 py-2 text-sm font-bold text-center text-white bg-red-500 rounded-xl hover:bg-red-600 focus:ring-4 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 transition-all shadow-md hover:shadow-red-500/20 active:scale-95">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor"
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
                                        <td colspan="5"
                                            class="p-8 text-center text-gray-500 dark:text-gray-400 font-medium italic">
                                            Data user belum ada.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4">
            {{ $users->appends(request()->query())->links() }}
        </div>
    </div>

    <!-- Add Modal -->
    <div id="add-user-modal" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full">
            <div
                class="relative bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl dark:bg-gray-800/90 border border-white/20 dark:border-gray-700/30 overflow-hidden">
                <div
                    class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-700 bg-blue-600 dark:bg-blue-700">
                    <h3 class="text-xl font-bold text-white tracking-wide">Tambah User Baru</h3>
                    <button type="button"
                        class="text-white/70 hover:text-white bg-transparent hover:bg-white/10 rounded-xl text-sm w-9 h-9 ml-auto inline-flex justify-center items-center transition-all"
                        data-modal-hide="add-user-modal">
                        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
                <form action="{{ route('admin.master.users.store') }}" method="POST">
                    @csrf
                    <div class="p-8 space-y-6 bg-gray-50/50 dark:bg-gray-900/50">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label
                                    class="block mb-2 text-sm font-black text-gray-700 dark:text-gray-300 uppercase tracking-wider">Nama
                                    Lengkap</label>
                                <input type="text" name="name"
                                    class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5 dark:bg-gray-800 dark:border-gray-700 dark:text-white transition-all shadow-sm focus:shadow-blue-500/10"
                                    placeholder="Masukkan nama lengkap..." required>
                            </div>
                            <div>
                                <label
                                    class="block mb-2 text-sm font-black text-gray-700 dark:text-gray-300 uppercase tracking-wider">Username</label>
                                <input type="text" name="username"
                                    class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5 dark:bg-gray-800 dark:border-gray-700 dark:text-white transition-all shadow-sm focus:shadow-blue-500/10"
                                    placeholder="username_pengguna" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label
                                    class="block mb-2 text-sm font-black text-gray-700 dark:text-gray-300 uppercase tracking-wider">Email</label>
                                <input type="email" name="email"
                                    class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5 dark:bg-gray-800 dark:border-gray-700 dark:text-white transition-all shadow-sm focus:shadow-blue-500/10"
                                    placeholder="user@desa.id" required>
                            </div>
                            <div>
                                <label
                                    class="block mb-2 text-sm font-black text-gray-700 dark:text-gray-300 uppercase tracking-wider">Role
                                    / Peran</label>
                                <select name="role"
                                    class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5 dark:bg-gray-800 dark:border-gray-700 dark:text-white transition-all shadow-sm">
                                    <option value="masyarakat">Masyarakat</option>
                                    <option value="kepala_desa">Kepala Desa</option>
                                    <option value="admin">Administrator</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label
                                    class="block mb-2 text-sm font-black text-gray-700 dark:text-gray-300 uppercase tracking-wider">Password</label>
                                <input type="password" name="password"
                                    class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5 dark:bg-gray-800 dark:border-gray-700 dark:text-white transition-all shadow-sm"
                                    required>
                            </div>
                            <div>
                                <label
                                    class="block mb-2 text-sm font-black text-gray-700 dark:text-gray-300 uppercase tracking-wider">Konfirmasi
                                    Password</label>
                                <input type="password" name="password_confirmation"
                                    class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5 dark:bg-gray-800 dark:border-gray-700 dark:text-white transition-all shadow-sm"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex items-center p-6 space-x-3 border-t border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800">
                        <button type="submit"
                            class="flex-1 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-black rounded-xl text-sm px-6 py-4 text-center dark:bg-blue-500 dark:hover:bg-blue-600 transition-all shadow-lg hover:scale-[1.02] active:scale-[0.98] tracking-widest uppercase">
                            SIMPAN USER
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($users as $user)
        <!-- Edit Modal -->
        <div id="edit-user-modal-{{ $user->id }}" tabindex="-1" aria-hidden="true"
            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-2xl max-h-full">
                <div
                    class="relative bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl dark:bg-gray-800/90 border border-white/20 dark:border-gray-700/30 overflow-hidden">
                    <div
                        class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-700 bg-blue-600 dark:bg-blue-700">
                        <h3 class="text-xl font-bold text-white tracking-wide">Edit User: {{ $user->name }}</h3>
                        <button type="button"
                            class="text-white/70 hover:text-white bg-transparent hover:bg-white/10 rounded-xl text-sm w-9 h-9 ml-auto inline-flex justify-center items-center transition-all"
                            data-modal-hide="edit-user-modal-{{ $user->id }}">
                            <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>
                    <form action="{{ route('admin.master.users.update', $user) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="p-8 space-y-6 bg-gray-50/50 dark:bg-gray-900/50">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label
                                        class="block mb-2 text-sm font-black text-gray-700 dark:text-gray-300 uppercase tracking-wider">Nama
                                        Lengkap</label>
                                    <input type="text" name="name" value="{{ $user->name }}"
                                        class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5 dark:bg-gray-800 dark:border-gray-700 dark:text-white transition-all shadow-sm"
                                        required>
                                </div>
                                <div>
                                    <label
                                        class="block mb-2 text-sm font-black text-gray-700 dark:text-gray-300 uppercase tracking-wider">Username</label>
                                    <input type="text" name="username" value="{{ $user->username }}"
                                        class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5 dark:bg-gray-800 dark:border-gray-700 dark:text-white transition-all shadow-sm"
                                        required>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label
                                        class="block mb-2 text-sm font-black text-gray-700 dark:text-gray-300 uppercase tracking-wider">Email</label>
                                    <input type="email" name="email" value="{{ $user->email }}"
                                        class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5 dark:bg-gray-800 dark:border-gray-700 dark:text-white transition-all shadow-sm"
                                        required>
                                </div>
                                <div>
                                    <label
                                        class="block mb-2 text-sm font-black text-gray-700 dark:text-gray-300 uppercase tracking-wider">Role
                                        / Peran</label>
                                    <select name="role"
                                        class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5 dark:bg-gray-800 dark:border-gray-700 dark:text-white transition-all shadow-sm">
                                        <option value="masyarakat"
                                            {{ $user->role === 'masyarakat' ? 'selected' : '' }}>Masyarakat</option>
                                        <option value="kepala_desa"
                                            {{ $user->role === 'kepala_desa' ? 'selected' : '' }}>Kepala Desa</option>
                                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>
                                            Administrator</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label
                                        class="block mb-2 text-sm font-black text-gray-700 dark:text-gray-300 uppercase tracking-wider">Status
                                        Akun</label>
                                    <select name="status"
                                        class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3.5 dark:bg-gray-800 dark:border-gray-700 dark:text-white transition-all shadow-sm">
                                        <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>
                                            Aktif</option>
                                        <option value="inactive" {{ $user->status === 'inactive' ? 'selected' : '' }}>
                                            Nonaktif</option>
                                        <option value="suspended"
                                            {{ $user->status === 'suspended' ? 'selected' : '' }}>Suspended</option>
                                    </select>
                                </div>
                                <div>
                                    <label
                                        class="block mb-2 text-sm font-black text-gray-700 dark:text-gray-300 uppercase tracking-wider italic">No.
                                        Telepon</label>
                                    <input type="text" name="phone" value="{{ $user->phone }}"
                                        class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl block w-full p-3.5 dark:bg-gray-800 dark:border-gray-700 dark:text-white transition-all shadow-sm"
                                        placeholder="08xxxxxxxxxx">
                                </div>
                            </div>

                            <div
                                class="p-6 bg-amber-50 dark:bg-amber-900/10 rounded-2xl border border-amber-100 dark:border-amber-900/30">
                                <h5
                                    class="text-xs font-black text-amber-800 dark:text-amber-300 uppercase tracking-wider mb-2">
                                    Ubah Password?</h5>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label
                                            class="block mb-1 text-[10px] font-bold text-amber-700 dark:text-amber-400 uppercase">Password
                                            Baru</label>
                                        <input type="password" name="password"
                                            class="bg-white border border-amber-100 text-gray-900 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 block w-full p-3 dark:bg-gray-800 dark:border-amber-900/50 dark:text-white transition-all">
                                    </div>
                                    <div>
                                        <label
                                            class="block mb-1 text-[10px] font-bold text-amber-700 dark:text-amber-400 uppercase">Konfirmasi</label>
                                        <input type="password" name="password_confirmation"
                                            class="bg-white border border-amber-100 text-gray-900 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 block w-full p-3 dark:bg-gray-800 dark:border-amber-900/50 dark:text-white transition-all">
                                    </div>
                                </div>
                                <p class="mt-3 text-[10px] text-amber-600 dark:text-amber-400/80 font-medium">Kosongkan
                                    jika tidak ingin mengubah password.</p>
                            </div>
                        </div>
                        <div
                            class="flex items-center p-6 space-x-3 border-t border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800">
                            <button type="submit"
                                class="flex-1 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-black rounded-xl text-sm px-6 py-4 text-center dark:bg-blue-500 dark:hover:bg-blue-600 transition-all shadow-lg hover:scale-[1.02] active:scale-[0.98] tracking-widest uppercase">
                                PERBARUI DATA USER
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

</x-app-layout>
