<x-public-layout>
    @section('title', 'Lengkapi Biodata')

    {{-- Determine initial step based on validation errors --}}
    @php
        $errorFields = $errors->keys();
        $step2Fields = ['foto_ktp', 'foto_kk'];
        $initialStep = 1;
        if ($errors->any()) {
            if (
                count(array_intersect($errorFields, $step2Fields)) > 0 &&
                count(array_diff($errorFields, $step2Fields)) === 0
            ) {
                $initialStep = 2;
            }
        }
    @endphp

    <div class="py-10 bg-gray-50/50 dark:bg-gray-950/50 min-h-screen" x-data="{
        step: {{ $initialStep }},
        totalSteps: 3,
        nik: '{{ old('nik', $biodata->nik) }}',
        no_kk: '{{ old('no_kk', $biodata->no_kk) }}',
        nama_lengkap: '{{ old('nama_lengkap', $biodata->nama_lengkap ?? Auth::user()->name) }}',
        tempat_lahir: '{{ old('tempat_lahir', $biodata->tempat_lahir) }}',
        tanggal_lahir: '{{ old('tanggal_lahir', $biodata->tanggal_lahir?->format('Y-m-d')) }}',
        jenis_kelamin: '{{ old('jenis_kelamin', $biodata->jenis_kelamin) }}',
        status_perkawinan: '{{ old('status_perkawinan', $biodata->status_perkawinan) }}',
        agama_id: '{{ old('agama_id', $biodata->agama_id) }}',
        pekerjaan_id: '{{ old('pekerjaan_id', $biodata->pekerjaan_id) }}',
        rt_id: '{{ old('rt_id', $biodata->rt_id) }}',
        alamat_lengkap: '{{ old('alamat_lengkap', $biodata->alamat_lengkap) }}',
        ktpPreview: '{{ $biodata->foto_ktp ? asset('storage/' . $biodata->foto_ktp) : '' }}',
        kkPreview: '{{ $biodata->foto_kk ? asset('storage/' . $biodata->foto_kk) : '' }}',
        ktpName: '',
        kkName: '',
        get formattedTtl() {
            if (!this.tempat_lahir && !this.tanggal_lahir) return '—';
            let ttl = this.tempat_lahir || '';
            if (this.tanggal_lahir) {
                const date = new Date(this.tanggal_lahir);
                if (!isNaN(date)) {
                    const formattedDate = date.toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });
                    ttl += (ttl ? ', ' : '') + formattedDate;
                }
            }
            return ttl || '—';
        },
        get jkLabel() {
            if (this.jenis_kelamin === 'L') return 'Laki-laki';
            if (this.jenis_kelamin === 'P') return 'Perempuan';
            return '—';
        },
        handleKtp(event) {
            const file = event.target.files[0];
            if (!file) return;
            this.ktpName = file.name;
            const reader = new FileReader();
            reader.onload = (e) => {
                this.ktpPreview = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        handleKk(event) {
            const file = event.target.files[0];
            if (!file) return;
            this.kkName = file.name;
            const reader = new FileReader();
            reader.onload = (e) => {
                this.kkPreview = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }">

        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Success Toast --}}
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="mb-6 flex items-center gap-3 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-2xl">
                    <svg class="w-5 h-5 text-green-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <p class="text-sm font-semibold text-green-800 dark:text-green-400">{{ session('success') }}</p>
                    <button @click="show = false" class="ml-auto text-green-500 hover:text-green-700">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            @endif

            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white">Biodata & Validasi Identitas</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Lengkapi data diri untuk dapat mengajukan surat
                    secara online.</p>
            </div>

            {{-- Status Banner --}}
            @if ($biodata->exists)
                <div
                    class="mb-6 flex items-center gap-3 px-4 py-3 rounded-xl border
                {{ $biodata->verification_status === 'verified'
                    ? 'bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-800'
                    : ($biodata->verification_status === 'pending'
                        ? 'bg-amber-50 dark:bg-amber-900/20 border-amber-200 dark:border-amber-800'
                        : 'bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800') }}">
                    @if ($biodata->verification_status === 'verified')
                        <span class="w-2 h-2 rounded-full bg-green-500 shrink-0"></span>
                        <p class="text-sm font-bold text-green-800 dark:text-green-400">Status: <span
                                class="font-black">Terverifikasi ✓</span></p>
                    @elseif($biodata->verification_status === 'pending')
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse shrink-0"></span>
                        <p class="text-sm font-bold text-amber-800 dark:text-amber-400">Status: <span
                                class="font-black">Menunggu Verifikasi Admin</span></p>
                    @else
                        <span class="w-2 h-2 rounded-full bg-blue-500 shrink-0"></span>
                        <p class="text-sm font-bold text-blue-800 dark:text-blue-400">Status: <span
                                class="font-black">Belum Divalidasi</span> — Mohon lengkapi data di bawah.</p>
                    @endif
                </div>
            @endif

            {{-- Progress Stepper --}}
            <div class="mb-8">
                <div class="flex items-center justify-between relative">
                    <div class="absolute top-4 left-0 right-0 h-0.5 bg-gray-200 dark:bg-gray-700 z-0">
                        <div class="h-full bg-blue-600 transition-all duration-500"
                            :style="`width: ${((step - 1) / (totalSteps - 1)) * 100}%`"></div>
                    </div>

                    <template x-for="s in [1, 2, 3]" :key="s">
                        <div class="relative z-10 flex flex-col items-center">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold border-2 transition-all duration-300"
                                :class="step >= s ?
                                    'bg-blue-600 border-blue-600 text-white shadow-lg shadow-blue-200 dark:shadow-none' :
                                    'bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-600 text-gray-400'">
                                <span x-show="step > s" class="text-xs">✓</span>
                                <span x-show="step <= s" x-text="s"></span>
                            </div>
                            <span class="mt-2 text-xs font-semibold hidden sm:block"
                                :class="step >= s ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400'">
                                <span x-text="['Data Diri','Dokumen','Konfirmasi'][s-1]"></span>
                            </span>
                        </div>
                    </template>
                </div>
            </div>

            <form action="{{ route('masyarakat.profile.update') }}" method="POST" enctype="multipart/form-data"
                id="biodata-form">
                @csrf

                {{-- ======================== STEP 1: Data Identitas ======================== --}}
                <div x-show="step === 1" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-x-4"
                    x-transition:enter-end="opacity-100 translate-x-0">
                    <div
                        class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-xl shadow-gray-100/50 dark:shadow-none p-8 space-y-6">
                        <h2 class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-wide">Data
                            Identitas Diri</h2>

                        @if ($errors->any() && $initialStep === 1)
                            <div
                                class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl">
                                <p class="text-sm font-bold text-red-800 dark:text-red-400">Terdapat kesalahan, mohon
                                    periksa kembali:</p>
                                <ul class="mt-2 text-xs text-red-600 dark:text-red-400 list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        @if (!in_array($error, $errors->get('foto_ktp') ?? []) && !in_array($error, $errors->get('foto_kk') ?? []))
                                            <li>{{ $error }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            {{-- NIK --}}
                            <div class="space-y-1.5">
                                <label for="nik"
                                    class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-widest">NIK
                                    <span class="text-red-500">*</span></label>
                                <input type="text" name="nik" id="nik" x-model="nik"
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border rounded-xl outline-none transition-all text-gray-900 dark:text-white text-sm
                                    {{ $errors->has('nik') ? 'border-red-400 focus:ring-red-500/20 focus:border-red-500' : 'border-gray-200 dark:border-gray-700 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500' }}"
                                    placeholder="16 Digit NIK Anda">
                                @error('nik')
                                    <p class="text-xs text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- No KK --}}
                            <div class="space-y-1.5">
                                <label for="no_kk"
                                    class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-widest">Nomor
                                    KK
                                    <span class="text-red-500">*</span></label>
                                <input type="text" name="no_kk" id="no_kk" x-model="no_kk"
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border rounded-xl outline-none transition-all text-gray-900 dark:text-white text-sm
                                    {{ $errors->has('no_kk') ? 'border-red-400 focus:ring-red-500/20 focus:border-red-500' : 'border-gray-200 dark:border-gray-700 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500' }}"
                                    placeholder="16 Digit Nomor KK Anda">
                                @error('no_kk')
                                    <p class="text-xs text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Nama Lengkap --}}
                            <div class="md:col-span-2 space-y-1.5">
                                <label for="nama_lengkap"
                                    class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-widest">Nama
                                    Lengkap (Sesuai KTP) <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_lengkap" id="nama_lengkap" x-model="nama_lengkap"
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border rounded-xl outline-none transition-all text-gray-900 dark:text-white text-sm
                                    {{ $errors->has('nama_lengkap') ? 'border-red-400 focus:ring-red-500/20 focus:border-red-500' : 'border-gray-200 dark:border-gray-700 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500' }}">
                                @error('nama_lengkap')
                                    <p class="text-xs text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Tempat Lahir --}}
                            <div class="space-y-1.5">
                                <label for="tempat_lahir"
                                    class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-widest">Tempat
                                    Lahir <span class="text-red-500">*</span></label>
                                <input type="text" name="tempat_lahir" id="tempat_lahir" x-model="tempat_lahir"
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border rounded-xl outline-none transition-all text-gray-900 dark:text-white text-sm
                                    {{ $errors->has('tempat_lahir') ? 'border-red-400' : 'border-gray-200 dark:border-gray-700 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500' }}">
                                @error('tempat_lahir')
                                    <p class="text-xs text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Tanggal Lahir --}}
                            <div class="space-y-1.5">
                                <label for="tanggal_lahir"
                                    class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-widest">Tanggal
                                    Lahir <span class="text-red-500">*</span></label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                    x-model="tanggal_lahir" max="{{ now()->subDay()->format('Y-m-d') }}"
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border rounded-xl outline-none transition-all text-gray-900 dark:text-white text-sm
                                    {{ $errors->has('tanggal_lahir') ? 'border-red-400' : 'border-gray-200 dark:border-gray-700 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500' }}">
                                @error('tanggal_lahir')
                                    <p class="text-xs text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Jenis Kelamin --}}
                            <div class="space-y-1.5">
                                <label for="jenis_kelamin"
                                    class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-widest">Jenis
                                    Kelamin <span class="text-red-500">*</span></label>
                                <select name="jenis_kelamin" id="jenis_kelamin" x-model="jenis_kelamin"
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border rounded-xl outline-none transition-all text-gray-900 dark:text-white text-sm
                                    {{ $errors->has('jenis_kelamin') ? 'border-red-400' : 'border-gray-200 dark:border-gray-700 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500' }}">
                                    <option value="">Pilih...</option>
                                    <option value="L"
                                        {{ old('jenis_kelamin', $biodata->jenis_kelamin) == 'L' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="P"
                                        {{ old('jenis_kelamin', $biodata->jenis_kelamin) == 'P' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <p class="text-xs text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Status Perkawinan --}}
                            <div class="space-y-1.5">
                                <label for="status_perkawinan"
                                    class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-widest">Status
                                    Perkawinan <span class="text-red-500">*</span></label>
                                <select name="status_perkawinan" id="status_perkawinan" x-model="status_perkawinan"
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border rounded-xl outline-none transition-all text-gray-900 dark:text-white text-sm
                                    {{ $errors->has('status_perkawinan') ? 'border-red-400' : 'border-gray-200 dark:border-gray-700 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500' }}">
                                    <option value="">Pilih...</option>
                                    <option value="belum_kawin"
                                        {{ old('status_perkawinan', $biodata->status_perkawinan) == 'belum_kawin' ? 'selected' : '' }}>
                                        Belum Kawin</option>
                                    <option value="kawin"
                                        {{ old('status_perkawinan', $biodata->status_perkawinan) == 'kawin' ? 'selected' : '' }}>
                                        Kawin</option>
                                    <option value="cerai_hidup"
                                        {{ old('status_perkawinan', $biodata->status_perkawinan) == 'cerai_hidup' ? 'selected' : '' }}>
                                        Cerai Hidup</option>
                                    <option value="cerai_mati"
                                        {{ old('status_perkawinan', $biodata->status_perkawinan) == 'cerai_mati' ? 'selected' : '' }}>
                                        Cerai Mati</option>
                                </select>
                                @error('status_perkawinan')
                                    <p class="text-xs text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Agama --}}
                            <div class="space-y-1.5">
                                <label for="agama_id"
                                    class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-widest">Agama
                                    <span class="text-red-500">*</span></label>
                                <select name="agama_id" id="agama_id" x-model="agama_id"
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border rounded-xl outline-none transition-all text-gray-900 dark:text-white text-sm
                                    {{ $errors->has('agama_id') ? 'border-red-400' : 'border-gray-200 dark:border-gray-700 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500' }}">
                                    <option value="">Pilih...</option>
                                    @foreach ($agamas as $a)
                                        <option value="{{ $a->id }}"
                                            {{ old('agama_id', $biodata->agama_id) == $a->id ? 'selected' : '' }}>
                                            {{ $a->nama }}</option>
                                    @endforeach
                                </select>
                                @error('agama_id')
                                    <p class="text-xs text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Pekerjaan --}}
                            <div class="space-y-1.5">
                                <label for="pekerjaan_id"
                                    class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-widest">Pekerjaan
                                    <span class="text-red-500">*</span></label>
                                <select name="pekerjaan_id" id="pekerjaan_id" x-model="pekerjaan_id"
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border rounded-xl outline-none transition-all text-gray-900 dark:text-white text-sm
                                    {{ $errors->has('pekerjaan_id') ? 'border-red-400' : 'border-gray-200 dark:border-gray-700 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500' }}">
                                    <option value="">Pilih...</option>
                                    @foreach ($pekerjaans as $p)
                                        <option value="{{ $p->id }}"
                                            {{ old('pekerjaan_id', $biodata->pekerjaan_id) == $p->id ? 'selected' : '' }}>
                                            {{ $p->nama }}</option>
                                    @endforeach
                                </select>
                                @error('pekerjaan_id')
                                    <p class="text-xs text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- RT / RW --}}
                            <div class="space-y-1.5">
                                <label for="rt_id"
                                    class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-widest">RT
                                    / Wilayah <span class="text-red-500">*</span></label>
                                <select name="rt_id" id="rt_id" x-model="rt_id"
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border rounded-xl outline-none transition-all text-gray-900 dark:text-white text-sm
                                    {{ $errors->has('rt_id') ? 'border-red-400' : 'border-gray-200 dark:border-gray-700 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500' }}">
                                    <option value="">Pilih RT...</option>
                                    @foreach ($rts as $rt)
                                        <option value="{{ $rt->id }}"
                                            {{ old('rt_id', $biodata->rt_id) == $rt->id ? 'selected' : '' }}>
                                            RT {{ $rt->nama }} / RW {{ $rt->parent->nama ?? '-' }}
                                            @if ($rt->parent?->parent)
                                                — {{ $rt->parent->parent->nama }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('rt_id')
                                    <p class="text-xs text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Alamat --}}
                            <div class="md:col-span-2 space-y-1.5">
                                <label for="alamat_lengkap"
                                    class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-widest">Alamat
                                    Lengkap <span class="text-red-500">*</span></label>
                                <textarea name="alamat_lengkap" id="alamat_lengkap" rows="3" x-model="alamat_lengkap"
                                    placeholder="Dusun, Lorong/Jalan, Nomor Rumah..."
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border rounded-xl outline-none transition-all text-gray-900 dark:text-white text-sm resize-none
                                    {{ $errors->has('alamat_lengkap') ? 'border-red-400' : 'border-gray-200 dark:border-gray-700 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500' }}"></textarea>
                                @error('alamat_lengkap')
                                    <p class="text-xs text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Kondisi Khusus --}}
                            <div class="md:col-span-2">
                                <p
                                    class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-widest mb-3">
                                    Kondisi Khusus (Opsional)</p>
                                <div class="flex gap-4 flex-wrap">
                                    <label
                                        class="flex items-center gap-2.5 cursor-pointer px-4 py-3 bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-blue-400 transition-colors">
                                        <input type="checkbox" name="is_disabilitas" value="1"
                                            {{ old('is_disabilitas', $biodata->is_disabilitas) ? 'checked' : '' }}
                                            class="w-4 h-4 text-blue-600 border-gray-300 rounded">
                                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Penyandang
                                            Disabilitas</span>
                                    </label>
                                    <label
                                        class="flex items-center gap-2.5 cursor-pointer px-4 py-3 bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-pink-400 transition-colors">
                                        <input type="checkbox" name="is_hamil" value="1"
                                            {{ old('is_hamil', $biodata->is_hamil) ? 'checked' : '' }}
                                            class="w-4 h-4 text-pink-600 border-gray-300 rounded">
                                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Sedang
                                            Hamil / Menyusui</span>
                                    </label>
                                </div>
                                <p class="text-xs text-gray-400 mt-2">* Akan memberikan poin prioritas tambahan pada
                                    sistem antrean.</p>
                            </div>
                        </div>

                        {{-- Next Button --}}
                        <div class="flex justify-end pt-4">
                            <button type="button" @click="step = 2"
                                class="inline-flex items-center gap-2 px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-200 dark:shadow-none transition-all active:scale-95">
                                Selanjutnya
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- ======================== STEP 2: Upload Dokumen ======================== --}}
                <div x-show="step === 2" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-x-4"
                    x-transition:enter-end="opacity-100 translate-x-0">
                    <div
                        class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-xl shadow-gray-100/50 dark:shadow-none p-8 space-y-8">
                        <div>
                            <h2 class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-wide">Upload
                                Dokumen</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Upload foto KTP dan Kartu Keluarga
                                (KK) dalam format JPG, JPEG, atau PNG, maksimal 2MB.</p>
                        </div>

                        @if ($errors->hasAny(['foto_ktp', 'foto_kk']))
                            <div
                                class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl">
                                <p class="text-sm font-bold text-red-800 dark:text-red-400">Terdapat masalah pada
                                    dokumen:</p>
                                <ul
                                    class="mt-1 text-xs text-red-600 dark:text-red-400 list-disc list-inside space-y-1">
                                    @error('foto_ktp')
                                        <li>{{ $message }}</li>
                                    @enderror
                                    @error('foto_kk')
                                        <li>{{ $message }}</li>
                                    @enderror
                                </ul>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                            {{-- KTP Upload --}}
                            <div class="space-y-3">
                                <label
                                    class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-widest">
                                    Foto KTP <span class="text-red-500">*</span>
                                    @if ($biodata->foto_ktp)
                                        <span class="text-green-500 ml-1">(Sudah Ada)</span>
                                    @endif
                                </label>

                                {{-- Preview Area --}}
                                <div class="relative rounded-2xl overflow-hidden border-2 transition-colors"
                                    :class="ktpPreview ? 'border-blue-200 dark:border-blue-800' :
                                        'border-dashed border-gray-200 dark:border-gray-700 {{ $errors->has('foto_ktp') ? 'border-red-400' : '' }}'">
                                    <template x-if="ktpPreview">
                                        <div class="relative aspect-video">
                                            <img :src="ktpPreview" class="w-full h-full object-cover"
                                                alt="Preview KTP">
                                            <div
                                                class="absolute inset-0 bg-black/30 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                                                <label for="foto_ktp"
                                                    class="cursor-pointer px-4 py-2 bg-white text-gray-900 text-xs font-bold rounded-xl">
                                                    Ganti Foto
                                                </label>
                                            </div>
                                        </div>
                                    </template>
                                    <template x-if="!ktpPreview">
                                        <label for="foto_ktp"
                                            class="flex flex-col items-center justify-center py-12 cursor-pointer hover:bg-blue-50 dark:hover:bg-blue-900/10 transition-colors">
                                            <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-3"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span class="text-sm font-bold text-gray-500 dark:text-gray-400">Klik untuk
                                                upload KTP</span>
                                            <span class="text-xs text-gray-400 mt-1">JPG, PNG • Maks. 2MB</span>
                                        </label>
                                    </template>
                                </div>

                                <input type="file" name="foto_ktp" id="foto_ktp"
                                    accept="image/jpg,image/jpeg,image/png" @change="handleKtp($event)"
                                    class="hidden" x-ref="ktpInput">

                                <div x-show="ktpName"
                                    class="flex items-center gap-2 text-xs text-blue-600 dark:text-blue-400 font-semibold">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span x-text="ktpName" class="truncate"></span>
                                </div>

                                @error('foto_ktp')
                                    <p class="text-xs text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- KK Upload --}}
                            <div class="space-y-3">
                                <label
                                    class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-widest">
                                    Foto Kartu Keluarga (KK) <span class="text-red-500">*</span>
                                    @if ($biodata->foto_kk)
                                        <span class="text-green-500 ml-1">(Sudah Ada)</span>
                                    @endif
                                </label>

                                <div class="relative rounded-2xl overflow-hidden border-2 transition-colors"
                                    :class="kkPreview ? 'border-blue-200 dark:border-blue-800' :
                                        'border-dashed border-gray-200 dark:border-gray-700'">
                                    <template x-if="kkPreview">
                                        <div class="relative aspect-video">
                                            <img :src="kkPreview" class="w-full h-full object-cover"
                                                alt="Preview KK">
                                            <div
                                                class="absolute inset-0 bg-black/30 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                                                <label for="foto_kk"
                                                    class="cursor-pointer px-4 py-2 bg-white text-gray-900 text-xs font-bold rounded-xl">
                                                    Ganti Foto
                                                </label>
                                            </div>
                                        </div>
                                    </template>
                                    <template x-if="!kkPreview">
                                        <label for="foto_kk"
                                            class="flex flex-col items-center justify-center py-12 cursor-pointer hover:bg-blue-50 dark:hover:bg-blue-900/10 transition-colors">
                                            <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-3"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span class="text-sm font-bold text-gray-500 dark:text-gray-400">Klik untuk
                                                upload KK</span>
                                            <span class="text-xs text-gray-400 mt-1">JPG, PNG • Maks. 2MB</span>
                                        </label>
                                    </template>
                                </div>

                                <input type="file" name="foto_kk" id="foto_kk"
                                    accept="image/jpg,image/jpeg,image/png" @change="handleKk($event)" class="hidden"
                                    x-ref="kkInput">

                                <div x-show="kkName"
                                    class="flex items-center gap-2 text-xs text-blue-600 dark:text-blue-400 font-semibold">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span x-text="kkName" class="truncate"></span>
                                </div>

                                @error('foto_kk')
                                    <p class="text-xs text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Navigation Buttons --}}
                        <div class="flex items-center justify-between pt-4">
                            <button type="button" @click="step = 1"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 font-bold rounded-xl hover:bg-gray-200 dark:hover:bg-gray-700 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                                </svg>
                                Sebelumnya
                            </button>
                            <button type="button" @click="step = 3"
                                class="inline-flex items-center gap-2 px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-200 dark:shadow-none transition-all active:scale-95">
                                Selanjutnya
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- ======================== STEP 3: Konfirmasi ======================== --}}
                <div x-show="step === 3" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-x-4"
                    x-transition:enter-end="opacity-100 translate-x-0">
                    <div
                        class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-xl shadow-gray-100/50 dark:shadow-none p-8 space-y-6">
                        <div>
                            <h2 class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-wide">
                                Konfirmasi & Submit</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Periksa kembali data Anda sebelum
                                menyimpan. Setelah disimpan, Admin akan memverifikasi biodata Anda.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div
                                class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-700">
                                <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-1">NIK</p>
                                <p class="text-gray-900 dark:text-white font-black text-base" x-text="nik || '—'"></p>
                            </div>
                            <div
                                class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-700">
                                <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-1">No KK</p>
                                <p class="text-gray-900 dark:text-white font-black text-base" x-text="no_kk || '—'">
                                </p>
                            </div>
                            <div
                                class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-700">
                                <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-1">Nama
                                    Lengkap</p>
                                <p class="text-gray-900 dark:text-white font-semibold text-sm"
                                    x-text="nama_lengkap || '—'"></p>
                            </div>
                            <div
                                class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-700">
                                <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-1">Tempat,
                                    Tanggal Lahir</p>
                                <p class="text-gray-900 dark:text-white font-semibold text-sm" x-text="formattedTtl">
                                </p>
                            </div>
                            <div
                                class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-700">
                                <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-1">Jenis
                                    Kelamin</p>
                                <p class="text-gray-900 dark:text-white font-semibold text-sm" x-text="jkLabel"></p>
                            </div>
                        </div>

                        {{-- Photo Previews --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-widest font-bold mb-2">KTP</p>
                                <div
                                    class="aspect-video rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                                    <img :src="ktpPreview || ''" :class="ktpPreview ? 'opacity-100' : 'opacity-0'"
                                        class="w-full h-full object-cover" alt="KTP">
                                    <div x-show="!ktpPreview" class="w-full h-full flex items-center justify-center">
                                        <span class="text-xs text-gray-400">Belum diupload</span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-widest font-bold mb-2">Kartu
                                    Keluarga</p>
                                <div
                                    class="aspect-video rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                                    <img :src="kkPreview || ''" :class="kkPreview ? 'opacity-100' : 'opacity-0'"
                                        class="w-full h-full object-cover" alt="KK">
                                    <div x-show="!kkPreview" class="w-full h-full flex items-center justify-center">
                                        <span class="text-xs text-gray-400">Belum diupload</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Info Disclaimer --}}
                        <div
                            class="flex gap-3 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-100 dark:border-blue-800">
                            <svg class="w-5 h-5 text-blue-500 shrink-0 mt-0.5" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd" />
                            </svg>
                            <p class="text-sm text-blue-700 dark:text-blue-400">Setelah submit, data Anda akan
                                diperiksa oleh Admin Desa dan statusnya akan diperbarui. Pengajuan surat dapat segera
                                dilakukan sementara menunggu verifikasi.</p>
                        </div>

                        {{-- Navigation Buttons --}}
                        <div class="flex items-center justify-between pt-2">
                            <button type="button" @click="step = 2"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 font-bold rounded-xl hover:bg-gray-200 dark:hover:bg-gray-700 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                                </svg>
                                Sebelumnya
                            </button>
                            <button type="submit" id="btn-submit"
                                class="inline-flex items-center gap-2 px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-black rounded-xl shadow-lg shadow-green-200 dark:shadow-none transition-all active:scale-95">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Simpan Biodata
                            </button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            // Handle form submission UX
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('biodata-form');

                // prevent double submit
                form?.addEventListener('submit', function() {
                    const btn = document.getElementById('btn-submit');
                    btn.disabled = true;
                    btn.innerHTML =
                        '<svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Menyimpan...';
                });
            });
        </script>
    @endpush
</x-public-layout>
