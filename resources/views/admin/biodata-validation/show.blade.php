<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-y-2">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detail Validasi Biodata') }}
            </h2>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li><a href="{{ route('dashboard') }}" class="text-sm text-gray-500 hover:text-blue-600">Dashboard</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" stroke="currentColor"
                                viewBox="0 0 6 10">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <a href="{{ route('admin.biodata-validation.index') }}"
                                class="text-sm text-gray-500 hover:text-blue-600">Validasi Biodata</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" stroke="currentColor"
                                viewBox="0 0 6 10">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="text-sm font-medium text-gray-500">Detail</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="xl:col-span-2 space-y-6">
            <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 border-b pb-2">Informasi Identitas</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">NIK</p>
                        <p class="text-gray-900 dark:text-white font-mono text-lg font-bold">{{ $biodata->nik }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Nama Lengkap</p>
                        <p class="text-gray-900 dark:text-white font-semibold">{{ $biodata->nama_lengkap }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Tempat, Tanggal Lahir
                        </p>
                        <p class="text-gray-900 dark:text-white">{{ $biodata->tempat_lahir }},
                            {{ $biodata->tanggal_lahir->translatedFormat('d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Jenis Kelamin</p>
                        <p class="text-gray-900 dark:text-white">
                            {{ $biodata->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Agama</p>
                        <p class="text-gray-900 dark:text-white">{{ $biodata->agama->nama ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">RT / Wilayah</p>
                        <p class="text-gray-900 dark:text-white">{{ $biodata->rt->nama ?? '-' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Alamat Lengkap</p>
                        <p class="text-gray-900 dark:text-white">{{ $biodata->alamat_lengkap }}</p>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 border-b pb-2">Dokumen Pendukung</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-3">
                        <p class="text-sm font-bold text-gray-600 dark:text-gray-300">Foto KTP</p>
                        <div
                            class="relative group aspect-video rounded-xl overflow-hidden bg-gray-100 border dark:border-gray-600">
                            @if ($biodata->foto_ktp)
                                <img src="{{ asset('storage/' . $biodata->foto_ktp) }}"
                                    class="w-full h-full object-contain">
                                <a href="{{ asset('storage/' . $biodata->foto_ktp) }}" target="_blank"
                                    class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                                    <span class="text-white text-xs font-bold uppercase tracking-widest">Lihat Ukuran
                                        Penuh</span>
                                </a>
                            @else
                                <div class="flex items-center justify-center h-full">
                                    <span class="text-gray-400 text-xs italic">Tidak ada foto KTP</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="space-y-3">
                        <p class="text-sm font-bold text-gray-600 dark:text-gray-300">Foto KK</p>
                        <div
                            class="relative group aspect-video rounded-xl overflow-hidden bg-gray-100 border dark:border-gray-600">
                            @if ($biodata->foto_kk)
                                <img src="{{ asset('storage/' . $biodata->foto_kk) }}"
                                    class="w-full h-full object-contain">
                                <a href="{{ asset('storage/' . $biodata->foto_kk) }}" target="_blank"
                                    class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                                    <span class="text-white text-xs font-bold uppercase tracking-widest">Lihat Ukuran
                                        Penuh</span>
                                </a>
                            @else
                                <div class="flex items-center justify-center h-full">
                                    <span class="text-gray-400 text-xs italic">Tidak ada foto KK</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Card -->
        <div class="space-y-6">
            <div class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Aksi Validasi</h3>

                <div class="space-y-4">
                    <form action="{{ route('admin.biodata-validation.approve', $biodata) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label
                                class="block mb-2 text-sm font-medium text-gray-600 dark:text-gray-400 uppercase tracking-widest">Nomor
                                KK (Konfirmasi)</label>
                            <input type="text" name="no_kk" value="{{ $biodata->nik }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                placeholder="Input Manual jika berbeda dari NIK">
                            <p class="mt-1 text-[10px] text-gray-500 italic">*Jika tidak diisi, akan otomatis
                                menggunakan NIK (sementara)</p>
                        </div>
                        <button type="submit"
                            onclick="return confirm('Apakah Anda yakin data ini sudah sesuai dan ingin menyetujuinya?')"
                            class="w-full py-3 px-4 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition-colors flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Setujui & Verifikasi
                        </button>
                    </form>

                    <hr class="dark:border-gray-600">

                    <button data-modal-target="reject-modal" data-modal-toggle="reject-modal"
                        class="w-full py-3 px-4 border-2 border-red-500 text-red-500 hover:bg-red-500 hover:text-white font-bold rounded-xl transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Tolak Biodata
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="reject-modal" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-xl shadow dark:bg-gray-700">
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Alasan Penolakan</h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="reject-modal">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 14 14">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
                <form action="{{ route('admin.biodata-validation.reject', $biodata) }}" method="POST">
                    @csrf
                    <div class="p-6 space-y-4">
                        <label class="block text-sm font-medium text-gray-900 dark:text-white">Mohon berikan alasan
                            mengapa biodata ini ditolak agar masyarakat dapat memperbaikinya.</label>
                        <textarea name="reason" rows="4"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            placeholder="Contoh: Foto KTP tidak jelas, NIK tidak terdaftar, dll" required></textarea>
                    </div>
                    <div
                        class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button type="submit"
                            class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5">Kirim
                            Penolakan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
