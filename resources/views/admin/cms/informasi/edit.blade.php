<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-y-2">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit Informasi</h2>
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
                                fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg><a href="{{ route('admin.cms.informasi.index') }}"
                                class="ms-1 text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">Informasi</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center"><svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1"
                                fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg><span class="ms-1 text-sm text-gray-500 dark:text-gray-400">Edit</span></div>
                    </li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
        <form action="{{ route('admin.cms.informasi.update', $informasi) }}" method="POST"
            enctype="multipart/form-data" class="space-y-6">
            @csrf @method('PUT')
            @include('admin.cms.informasi._form')
            <div class="flex items-center gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                <button type="submit" name="is_published" value="1"
                    class="inline-flex items-center gap-2 text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-6 py-2.5 dark:bg-blue-600">
                    {{ $informasi->is_published ? '💾 Update' : '🚀 Publish' }}
                </button>
                @if ($informasi->is_published)
                    <button type="submit" name="is_published" value="0"
                        class="inline-flex items-center gap-2 text-gray-700 dark:text-gray-300 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 font-medium rounded-lg text-sm px-6 py-2.5">
                        Simpan sebagai Draft
                    </button>
                @else
                    <button type="submit" name="is_published" value="0"
                        class="inline-flex items-center gap-2 text-gray-700 dark:text-gray-300 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 font-medium rounded-lg text-sm px-6 py-2.5">
                        💾 Update Draft
                    </button>
                @endif
                <a href="{{ route('admin.cms.informasi.index') }}"
                    class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>
