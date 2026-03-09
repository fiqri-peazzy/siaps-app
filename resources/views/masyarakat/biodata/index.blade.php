<x-public-layout>
    @section('title', 'Lengkapi Biodata')

    <div class="py-12 bg-gray-50/50 dark:bg-gray-950/50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header Section --}}
            <div class="mb-10 text-center md:text-left">
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl tracking-tight">
                    Validasi Biodata Masyarakat
                </h1>
                <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">
                    Lengkapi data diri Anda untuk memudahkan proses pengajuan surat dan verifikasi administratif.
                </p>
            </div>

            <div
                class="bg-white dark:bg-gray-900 rounded-3xl shadow-xl shadow-gray-200/50 dark:shadow-none border border-gray-100 dark:border-gray-800 overflow-hidden">
                {{-- Status Alert --}}
                @if ($biodata->verification_status === 'verified')
                    <div
                        class="p-6 bg-green-50 dark:bg-green-900/20 border-b border-green-100 dark:border-green-800/50 flex items-center gap-4">
                        <div class="p-2 bg-green-100 dark:bg-green-800 rounded-full text-green-600 dark:text-green-400">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-green-900 dark:text-green-400 uppercase tracking-widest text-xs">
                                Status: Terverifikasi</h3>
                            <p class="text-sm text-green-700 dark:text-green-500">Biodata Anda telah divalidasi oleh
                                Admin. Anda dapat melakukan pengajuan tanpa hambatan.</p>
                        </div>
                    </div>
                @elseif($biodata->verification_status === 'pending')
                    <div
                        class="p-6 bg-amber-50 dark:bg-amber-900/20 border-b border-amber-100 dark:border-amber-800/50 flex items-center gap-4">
                        <div
                            class="p-2 bg-amber-100 dark:bg-amber-800 rounded-full text-amber-600 dark:text-amber-400 text-sm font-bold">
                            <svg class="w-6 h-6 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-amber-900 dark:text-amber-400 uppercase tracking-widest text-xs">
                                Status: Menunggu Verifikasi</h3>
                            <p class="text-sm text-amber-700 dark:text-amber-500">Data Anda sedang dalam antrean
                                verifikasi Admin. Anda tetap bisa melakukan update jika diperlukan.</p>
                        </div>
                    </div>
                @else
                    <div
                        class="p-6 bg-blue-50 dark:bg-blue-900/20 border-b border-blue-100 dark:border-blue-800/50 flex items-center gap-4">
                        <div class="p-2 bg-blue-100 dark:bg-blue-800 rounded-full text-blue-600 dark:text-blue-400">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-blue-900 dark:text-blue-400 uppercase tracking-widest text-xs">
                                Aksi Diperlukan</h3>
                            <p class="text-sm text-blue-700 dark:text-blue-500">Silakan lengkapi biodata Anda agar
                                pengajuan surat dapat diproses lebih cepat.</p>
                        </div>
                    </div>
                @endif

                <form action="{{ route('masyarakat.profile.update') }}" method="POST" enctype="multipart/form-data"
                    class="p-8 space-y-10">
                    @csrf

                    {{-- Section 1: Data Identitas --}}
                    <div class="space-y-6">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs font-bold shadow-lg shadow-blue-200 dark:shadow-none">
                                1</div>
                            <h2 class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Data
                                Identitas</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="nik" class="text-sm font-bold text-gray-700 dark:text-gray-300">Nomor
                                    Induk Kependudukan (NIK) <span class="text-red-500">*</span></label>
                                <input type="text" name="nik" id="nik"
                                    value="{{ old('nik', $biodata->nik) }}" required
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all text-gray-900 dark:text-white"
                                    placeholder="16 Digit NIK Anda">
                                @error('nik')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="nama_lengkap"
                                    class="text-sm font-bold text-gray-700 dark:text-gray-300">Nama Lengkap (Sesuai KTP)
                                    <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_lengkap" id="nama_lengkap"
                                    value="{{ old('nama_lengkap', $biodata->nama_lengkap ?? Auth::user()->name) }}"
                                    required
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all text-gray-900 dark:text-white">
                                @error('nama_lengkap')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="tempat_lahir"
                                    class="text-sm font-bold text-gray-700 dark:text-gray-300">Tempat Lahir <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="tempat_lahir" id="tempat_lahir"
                                    value="{{ old('tempat_lahir', $biodata->tempat_lahir) }}" required
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all text-gray-900 dark:text-white">
                            </div>

                            <div class="space-y-2">
                                <label for="tanggal_lahir"
                                    class="text-sm font-bold text-gray-700 dark:text-gray-300">Tanggal Lahir <span
                                        class="text-red-500">*</span></label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                    value="{{ old('tanggal_lahir', $biodata->tanggal_lahir ? $biodata->tanggal_lahir->format('Y-m-d') : '') }}"
                                    required
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all text-gray-900 dark:text-white">
                            </div>

                            <div class="space-y-2">
                                <label for="jenis_kelamin"
                                    class="text-sm font-bold text-gray-700 dark:text-gray-300">Jenis Kelamin <span
                                        class="text-red-500">*</span></label>
                                <select name="jenis_kelamin" id="jenis_kelamin" required
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all text-gray-900 dark:text-white">
                                    <option value="">Pilih</option>
                                    <option value="L"
                                        {{ old('jenis_kelamin', $biodata->jenis_kelamin) == 'L' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="P"
                                        {{ old('jenis_kelamin', $biodata->jenis_kelamin) == 'P' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label for="agama_id" class="text-sm font-bold text-gray-700 dark:text-gray-300">Agama
                                    <span class="text-red-500">*</span></label>
                                <select name="agama_id" id="agama_id" required
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all text-gray-900 dark:text-white">
                                    <option value="">Pilih</option>
                                    @foreach ($agamas as $a)
                                        <option value="{{ $a->id }}"
                                            {{ old('agama_id', $biodata->agama_id) == $a->id ? 'selected' : '' }}>
                                            {{ $a->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label for="pekerjaan_id"
                                    class="text-sm font-bold text-gray-700 dark:text-gray-300">Pekerjaan <span
                                        class="text-red-500">*</span></label>
                                <select name="pekerjaan_id" id="pekerjaan_id" required
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all text-gray-900 dark:text-white">
                                    <option value="">Pilih</option>
                                    @foreach ($pekerjaans as $p)
                                        <option value="{{ $p->id }}"
                                            {{ old('pekerjaan_id', $biodata->pekerjaan_id) == $p->id ? 'selected' : '' }}>
                                            {{ $p->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label for="rt_id" class="text-sm font-bold text-gray-700 dark:text-gray-300">RT /
                                    Wilayah <span class="text-red-500">*</span></label>
                                <select name="rt_id" id="rt_id" required
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all text-gray-900 dark:text-white">
                                    <option value="">Pilih</option>
                                    @foreach ($rts as $rt)
                                        <option value="{{ $rt->id }}"
                                            {{ old('rt_id', $biodata->rt_id) == $rt->id ? 'selected' : '' }}>RT
                                            {{ $rt->nama }} - {{ $rt->parent->nama ?? '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="alamat_lengkap"
                                class="text-sm font-bold text-gray-700 dark:text-gray-300">Alamat Lengkap <span
                                    class="text-red-500">*</span></label>
                            <textarea name="alamat_lengkap" id="alamat_lengkap" rows="3" required
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all text-gray-900 dark:text-white"
                                placeholder="Dusun, Lorong, Nomor Rumah...">{{ old('alamat_lengkap', $biodata->alamat_lengkap) }}</textarea>
                        </div>
                    </div>

                    <hr class="border-gray-100 dark:border-gray-800">

                    {{-- Section 2: Dokumen Fisik --}}
                    <div class="space-y-6">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs font-bold shadow-lg shadow-blue-200 dark:shadow-none">
                                2</div>
                            <h2 class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tight">
                                Dokumen Foto</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            {{-- Foto KTP --}}
                            <div class="space-y-4">
                                <label class="text-sm font-bold text-gray-700 dark:text-gray-300">Foto KTP <span
                                        class="text-red-500">*</span></label>
                                <div class="relative group h-48">
                                    @if ($biodata->foto_ktp)
                                        <div
                                            class="absolute inset-0 rounded-2xl overflow-hidden border-2 border-blue-100 dark:border-blue-900 shadow-sm transition-transform group-hover:scale-[1.02]">
                                            <img src="{{ asset('storage/' . $biodata->foto_ktp) }}"
                                                class="w-full h-full object-cover">
                                            <div
                                                class="absolute inset-0 bg-blue-600/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                                                <span
                                                    class="text-white font-bold text-sm bg-blue-700 px-4 py-2 rounded-xl">Ganti
                                                    Foto</span>
                                            </div>
                                        </div>
                                    @endif
                                    <input type="file" name="foto_ktp" id="foto_ktp" accept="image/*"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                        @if (!$biodata->foto_ktp) required @endif>
                                    @if (!$biodata->foto_ktp)
                                        <div
                                            class="absolute inset-0 bg-gray-50 dark:bg-gray-800 border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-3xl flex flex-col items-center justify-center text-gray-400 gap-2 group-hover:bg-blue-50 dark:group-hover:bg-blue-900/10 group-hover:border-blue-400 transition-all">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span class="text-xs font-bold uppercase tracking-widest">Klik untuk Upload
                                                KTP</span>
                                        </div>
                                    @endif
                                </div>
                                <p
                                    class="text-[10px] text-gray-400 dark:text-gray-500 uppercase text-center tracking-tighter">
                                    PNG, JPG atau JPEG (Maks. 2MB)</p>
                            </div>

                            {{-- Foto KK --}}
                            <div class="space-y-4">
                                <label class="text-sm font-bold text-gray-700 dark:text-gray-300">Foto KK <span
                                        class="text-red-500">*</span></label>
                                <div class="relative group h-48">
                                    @if ($biodata->foto_kk)
                                        <div
                                            class="absolute inset-0 rounded-2xl overflow-hidden border-2 border-blue-100 dark:border-blue-900 shadow-sm transition-transform group-hover:scale-[1.02]">
                                            <img src="{{ asset('storage/' . $biodata->foto_kk) }}"
                                                class="w-full h-full object-cover">
                                            <div
                                                class="absolute inset-0 bg-blue-600/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                                                <span
                                                    class="text-white font-bold text-sm bg-blue-700 px-4 py-2 rounded-xl">Ganti
                                                    Foto</span>
                                            </div>
                                        </div>
                                    @endif
                                    <input type="file" name="foto_kk" id="foto_kk" accept="image/*"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                        @if (!$biodata->foto_kk) required @endif>
                                    @if (!$biodata->foto_kk)
                                        <div
                                            class="absolute inset-0 bg-gray-50 dark:bg-gray-800 border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-3xl flex flex-col items-center justify-center text-gray-400 gap-2 group-hover:bg-blue-50 dark:group-hover:bg-blue-900/10 group-hover:border-blue-400 transition-all">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.66-.9l.82-1.2A2 2 0 0110.07 4h3.86a2 2 0 011.66.9l.82 1.2a2 2 0 001.66.9H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span class="text-xs font-bold uppercase tracking-widest">Klik untuk Upload
                                                KK</span>
                                        </div>
                                    @endif
                                </div>
                                <p
                                    class="text-[10px] text-gray-400 dark:text-gray-500 uppercase text-center tracking-tighter">
                                    PNG, JPG atau JPEG (Maks. 2MB)</p>
                            </div>
                        </div>
                    </div>

                    {{-- Section 3: Kondisi Khusus (Opsional) --}}
                    <div class="space-y-6">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs font-bold shadow-lg shadow-blue-200 dark:shadow-none">
                                3</div>
                            <h2 class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tight">
                                Kondisi Khusus (Prioritas)</h2>
                        </div>

                        <div
                            class="grid grid-cols-1 sm:grid-cols-2 gap-6 bg-blue-50/30 dark:bg-blue-900/5 p-6 rounded-3xl border border-blue-100/50 dark:border-blue-800/30">
                            <div
                                class="flex items-center gap-4 p-4 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700">
                                <input type="checkbox" name="is_disabilitas" id="is_disabilitas" value="1"
                                    {{ old('is_disabilitas', $biodata->is_disabilitas) ? 'checked' : '' }}
                                    class="w-6 h-6 text-blue-600 border-gray-300 rounded-lg focus:ring-blue-500">
                                <label for="is_disabilitas"
                                    class="text-sm font-bold text-gray-700 dark:text-gray-300">Penyandang
                                    Disabilitas</label>
                            </div>
                            <div
                                class="flex items-center gap-4 p-4 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700">
                                <input type="checkbox" name="is_hamil" id="is_hamil" value="1"
                                    {{ old('is_hamil', $biodata->is_hamil) ? 'checked' : '' }}
                                    class="w-6 h-6 text-pink-600 border-gray-300 rounded-lg focus:ring-pink-500">
                                <label for="is_hamil"
                                    class="text-sm font-bold text-gray-700 dark:text-gray-300">Sedang Hamil /
                                    Menyusui</label>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 italic">* Mengisi kondisi khusus akan memberikan poin prioritas
                            tambahan pada sistem antrean.</p>
                    </div>

                    <div class="pt-8 flex flex-col sm:flex-row gap-4">
                        <button type="submit"
                            class="flex-1 px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-2xl shadow-xl shadow-blue-200 dark:shadow-none hover:shadow-2xl transition-all active:scale-95 disabled:opacity-50">
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('masyarakat.home') }}"
                            class="px-8 py-4 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 font-bold rounded-2xl hover:bg-gray-200 dark:hover:bg-gray-700 transition-all text-center">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-public-layout>
