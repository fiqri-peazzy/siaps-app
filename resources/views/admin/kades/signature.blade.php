<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-y-2">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Pengaturan Tanda Tangan & Stempel') }}</h2>
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
                    <li aria-current="page">
                        <div class="flex items-center"><svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg><span class="ms-1 text-sm font-medium text-gray-500 dark:text-gray-400">Pengaturan
                                TTD</span></div>
                    </li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 border border-green-200 dark:border-green-800"
                    role="alert">
                    <span class="font-bold">Berhasil!</span> {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 border border-red-200 dark:border-red-800"
                    role="alert">
                    <span class="font-bold">Gagal!</span> {{ session('error') }}
                </div>
            @endif

            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-2xl border border-gray-200 dark:border-gray-700">
                <div class="p-8">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-xl">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Kelola Tanda Tangan Digital</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Pastikan gambar tanda tangan dan stempel
                                menggunakan format PNG transparan untuk hasil terbaik.</p>
                        </div>
                    </div>

                    <form action="{{ route('admin.kades.signature.update') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                            <!-- Tanda Tangan -->
                            <div class="space-y-4">
                                <label
                                    class="block text-sm font-black text-gray-700 dark:text-gray-300 uppercase tracking-wider">Tanda
                                    Tangan (PNG)</label>
                                <div
                                    class="relative group cursor-pointer border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-2xl p-4 flex flex-col items-center justify-center min-h-[200px] hover:border-blue-500 dark:hover:border-blue-400 transition-all bg-gray-50/50 dark:bg-gray-900/10">
                                    @if ($pejabat->tanda_tangan)
                                        <img src="{{ asset('storage/' . $pejabat->tanda_tangan) }}"
                                            class="max-h-40 object-contain mb-4" id="preview-ttd">
                                    @else
                                        <div class="text-gray-400 text-center" id="placeholder-ttd">
                                            <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <p class="text-xs uppercase font-bold tracking-widest">Klik Untuk Upload TTD
                                            </p>
                                        </div>
                                    @endif
                                    <input type="file" name="tanda_tangan"
                                        class="absolute inset-0 opacity-0 cursor-pointer"
                                        onchange="previewImage(this, 'preview-ttd')">
                                </div>
                            </div>

                            <!-- Stempel -->
                            <div class="space-y-4">
                                <label
                                    class="block text-sm font-black text-gray-700 dark:text-gray-300 uppercase tracking-wider">Stempel
                                    Desa (PNG)</label>
                                <div
                                    class="relative group cursor-pointer border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-2xl p-4 flex flex-col items-center justify-center min-h-[200px] hover:border-blue-500 dark:hover:border-blue-400 transition-all bg-gray-50/50 dark:bg-gray-900/10">
                                    @if ($pejabat->stempel_path)
                                        <img src="{{ asset('storage/' . $pejabat->stempel_path) }}"
                                            class="max-h-40 object-contain mb-4" id="preview-stempel">
                                    @else
                                        <div class="text-gray-400 text-center" id="placeholder-stempel">
                                            <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                            </svg>
                                            <p class="text-xs uppercase font-bold tracking-widest">Klik Untuk Upload
                                                Stempel</p>
                                        </div>
                                    @endif
                                    <input type="file" name="stempel_path"
                                        class="absolute inset-0 opacity-0 cursor-pointer"
                                        onchange="previewImage(this, 'preview-stempel')">
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <label
                                    class="block mb-2 text-sm font-black text-gray-700 dark:text-gray-300 uppercase tracking-wider">NIP
                                    Kepala Desa</label>
                                <input type="text" name="nip" value="{{ old('nip', $pejabat->nip) }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-4 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                    placeholder="Masukkan NIP (jika ada)...">
                            </div>
                            <div>
                                <label
                                    class="block mb-2 text-sm font-black text-gray-700 dark:text-gray-300 uppercase tracking-wider">Nama
                                    Pejabat</label>
                                <input type="text" value="{{ Auth::user()->name }}" disabled
                                    class="bg-gray-100 border border-gray-300 text-gray-500 text-sm rounded-xl block w-full p-4 cursor-not-allowed">
                            </div>
                        </div>

                        <div class="flex justify-end p-6 border-t border-gray-100 dark:border-gray-700">
                            <button type="submit"
                                class="w-full md:w-auto text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-black rounded-xl text-sm px-10 py-4 text-center dark:bg-blue-500 dark:hover:bg-blue-600 transition-all shadow-lg hover:scale-[1.02] active:scale-[0.98] tracking-widest uppercase">
                                SIMPAN PERUBAHAN
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function previewImage(input, previewId) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        let img = document.getElementById(previewId);
                        if (!img) {
                            img = document.createElement('img');
                            img.id = previewId;
                            img.className = "max-h-40 object-contain mb-4";
                            input.parentElement.insertBefore(img, input.parentElement.firstChild);
                            let placeholder = input.parentElement.querySelector('div');
                            if (placeholder) placeholder.style.display = 'none';
                        }
                        img.src = e.target.result;
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
    @endpush
</x-app-layout>
