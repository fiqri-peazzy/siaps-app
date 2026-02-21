<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
        <h3 class="mb-4 text-xl font-semibold dark:text-white">Selamat Datang, {{ Auth::user()->name }}!</h3>
        <p class="text-gray-500 dark:text-gray-400">Anda masuk sebagai role: <span
                class="font-bold uppercase">{{ Auth::user()->role }}</span></p>
    </div>

    <div class="grid grid-cols-1 gap-4 mt-4 sm:grid-cols-2 lg:grid-cols-3">
        <div
            class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">5 Antrian</h5>
            <p class="font-normal text-gray-700 dark:text-gray-400">Total antrian surat yang perlu divalidasi hari ini.
            </p>
        </div>
        <div
            class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">12 Surat Terbit</h5>
            <p class="font-normal text-gray-700 dark:text-gray-400">Total surat yang telah selesai diproses bulan ini.
            </p>
        </div>
        <div
            class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">120 Penduduk</h5>
            <p class="font-normal text-gray-700 dark:text-gray-400">Total data penduduk yang terdaftar di sistem.</p>
        </div>
    </div>
</x-app-layout>
