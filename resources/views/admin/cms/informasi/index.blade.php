<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-y-2">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Manajemen Informasi Desa
            </h2>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center"><a href="{{ route('dashboard') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white"><svg
                                class="w-3.5 h-3.5 me-2.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path
                                    d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                            </svg>Dashboard</a></li>
                    <li>
                        <div class="flex items-center"><svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg><span class="ms-1 text-sm font-medium text-gray-500 dark:text-gray-400">CMS</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center"><svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg><span class="ms-1 text-sm font-medium text-gray-500 dark:text-gray-400">Informasi
                                Desa</span></div>
                    </li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
        {{-- Header toolbar --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
            <div class="flex items-center gap-3">
                <form action="{{ route('admin.cms.informasi.index') }}" method="GET" class="flex gap-2">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"><svg
                                class="w-4 h-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg></div>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari judul..."
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-64 pl-9 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <select name="kategori"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">Semua Kategori</option>
                        <option value="pengumuman" {{ $kategori === 'pengumuman' ? 'selected' : '' }}>Pengumuman
                        </option>
                        <option value="berita" {{ $kategori === 'berita' ? 'selected' : '' }}>Berita</option>
                        <option value="profil" {{ $kategori === 'profil' ? 'selected' : '' }}>Profil</option>
                        <option value="layanan" {{ $kategori === 'layanan' ? 'selected' : '' }}>Layanan</option>
                        <option value="agenda" {{ $kategori === 'agenda' ? 'selected' : '' }}>Agenda</option>
                    </select>
                    <button type="submit"
                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-medium">Filter</button>
                </form>
            </div>
            <a href="{{ route('admin.cms.informasi.create') }}"
                class="inline-flex items-center gap-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
                Tulis Informasi
            </a>
        </div>

        <div class="overflow-x-auto rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Judul
                        </th>
                        <th class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                            Kategori</th>
                        <th class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Status
                        </th>
                        <th class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Tanggal
                        </th>
                        <th class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Views
                        </th>
                        <th class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    @forelse($informasi as $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="p-4 max-w-xs">
                                <div class="flex items-start gap-2">
                                    @if ($item->is_pinned)
                                        <span class="text-yellow-500 shrink-0 mt-0.5">📌</span>
                                    @endif
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white line-clamp-1">
                                            {{ $item->judul }}</p>
                                        <p class="text-xs text-gray-400 mt-0.5">{{ $item->penulis?->name ?? 'Admin' }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4">
                                <span
                                    class="px-2.5 py-1 text-xs font-semibold rounded-full
                                {{ match ($item->kategori) {'pengumuman' => 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400','berita' => 'bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400','agenda' => 'bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400',default => 'bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-400'} }}">
                                    {{ $item->kategori_label }}
                                </span>
                            </td>
                            <td class="p-4">
                                <span
                                    class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $item->is_published ? 'bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400' : 'bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400' }}">
                                    {{ $item->is_published ? 'Dipublish' : 'Draft' }}
                                </span>
                            </td>
                            <td class="p-4 text-sm text-gray-500 dark:text-gray-400">
                                {{ $item->published_at?->format('d M Y') ?? '-' }}</td>
                            <td class="p-4 text-sm text-gray-500 dark:text-gray-400">
                                {{ number_format($item->view_count) }}</td>
                            <td class="p-4 space-x-1 whitespace-nowrap">
                                <a href="{{ route('admin.cms.informasi.edit', $item) }}"
                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white rounded-lg bg-blue-700 hover:bg-blue-800 dark:bg-blue-600 dark:hover:bg-blue-700">Edit</a>
                                @if ($item->is_published)
                                    <a href="{{ route('public.informasi.show', $item->slug) }}" target="_blank"
                                        class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-300 rounded-lg bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600">Lihat</a>
                                @endif
                                <form action="{{ route('admin.cms.informasi.destroy', $item) }}" method="POST"
                                    class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus informasi ini?')"
                                        class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-red-700 rounded-lg hover:bg-red-800">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-500 dark:text-gray-400">Belum ada
                                informasi. <a href="{{ route('admin.cms.informasi.create') }}"
                                    class="text-blue-500 hover:underline">Tulis yang pertama!</a></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $informasi->links() }}</div>
    </div>
</x-app-layout>
