{{-- Shared form partial for create and edit --}}
<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div>
            <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Judul Informasi <span
                    class="text-red-500">*</span></label>
            <input type="text" name="judul" value="{{ old('judul', $informasi->judul ?? '') }}" required
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                placeholder="Masukkan judul yang menarik...">
        </div>

        <div>
            <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Isi Konten <span
                    class="text-red-500">*</span></label>
            <textarea name="konten" id="editor" rows="20"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('konten', $informasi->konten ?? '') }}</textarea>
            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400 italic">Gunakan editor di atas untuk menyusun
                artikel
                yang rapi & profesional.</p>
        </div>

        <div class="p-5 bg-gray-50 dark:bg-gray-900/50 rounded-2xl border border-gray-200 dark:border-gray-700">
            <h4 class="text-sm font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Galeri Gambar (Opsional)
            </h4>
            <div class="space-y-4">
                <input type="file" name="gallery[]" multiple accept="image/*"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900/30 dark:file:text-blue-400 transition-all">
                <p class="text-xs text-gray-400">Pilih beberapa foto sekaligus untuk ditampilkan sebagai galeri di bawah
                    artikel.</p>

                @if (!empty($informasi->gallery))
                    <div class="grid grid-cols-4 sm:grid-cols-6 gap-3 mt-4">
                        @foreach ($informasi->gallery as $index => $img)
                            <div
                                class="relative group aspect-square rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                                <img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-cover"
                                    alt="Gallery">
                                <div
                                    class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <label class="cursor-pointer">
                                        <input type="checkbox" name="remove_gallery[]" value="{{ $img }}"
                                            class="hidden peer">
                                        <span
                                            class="bg-red-500 text-white text-[10px] px-2 py-1 rounded peer-checked:bg-gray-500">Hapus?</span>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-[10px] text-red-500 mt-2">* Centang gambar dan simpan untuk menghapus dari galeri.
                    </p>
                @endif
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <div class="p-5 bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm">
            <div class="space-y-5">
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Kategori <span
                            class="text-red-500">*</span></label>
                    <select name="kategori" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all">
                        <option value="berita"
                            {{ old('kategori', $informasi->kategori ?? '') === 'berita' ? 'selected' : '' }}>Berita
                        </option>
                        <option value="pengumuman"
                            {{ old('kategori', $informasi->kategori ?? '') === 'pengumuman' ? 'selected' : '' }}>
                            Pengumuman</option>
                        <option value="profil"
                            {{ old('kategori', $informasi->kategori ?? '') === 'profil' ? 'selected' : '' }}>Profil Desa
                        </option>
                        <option value="layanan"
                            {{ old('kategori', $informasi->kategori ?? '') === 'layanan' ? 'selected' : '' }}>Informasi
                            Layanan</option>
                        <option value="agenda"
                            {{ old('kategori', $informasi->kategori ?? '') === 'agenda' ? 'selected' : '' }}>Agenda
                            Kegiatan</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Tags / Label</label>
                    <input type="text" name="tags" value="{{ old('tags', $informasi->tags ?? '') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        placeholder="Contoh: pembangunan, ekonomi, covid19">
                    <p class="mt-1 text-[10px] text-gray-500">Pisahkan dengan koma.</p>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Gambar Utama
                        (Thumbnail)</label>
                    @if (!empty($informasi->thumbnail))
                        <div class="relative group mb-3 rounded-xl overflow-hidden shadow-sm">
                            <img src="{{ asset('storage/' . $informasi->thumbnail) }}"
                                class="h-40 w-full object-cover transition-transform group-hover:scale-105"
                                alt="thumbnail">
                            <div class="absolute inset-0 bg-black/20"></div>
                        </div>
                    @endif
                    <input type="file" name="thumbnail" accept="image/*"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900/30 dark:file:text-blue-400 transition-all">
                    <p class="text-[10px] text-gray-400 mt-2">Format: JPG, PNG. Rekomendasi 16:9 (Max 2MB).</p>
                </div>

                <div class="pt-2 border-t border-gray-100 dark:border-gray-700">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <div class="relative flex items-center">
                            <input type="checkbox" name="is_pinned" value="1"
                                {{ old('is_pinned', $informasi->is_pinned ?? false) ? 'checked' : '' }}
                                class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded-lg focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600">
                        </div>
                        <span
                            class="text-sm font-bold text-gray-700 dark:text-gray-300 group-hover:text-blue-600 transition-colors">Sematkan
                            di Atas (Pin)</span>
                    </label>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div
                class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-2xl text-sm text-red-600 dark:text-red-400">
                <div class="flex items-center gap-2 mb-2 font-bold">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    Terdapat Kesalahan:
                </div>
                <ul class="list-disc list-inside space-y-1 ml-1">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>

@push('scripts')
    <script src="https://cdn.tiny.cloud/1/r37ixe0acxk5d5h6ad4k1ouxzoyi7nytgigpm2wb5pe4wkzt/tinymce/7/tinymce.min.js"
        referrerpolicy="origin" crossorigin="anonymous"></script>
    <script>
        tinymce.init({
            selector: '#editor',
            plugins: [
                'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media',
                'searchreplace', 'table', 'visualblocks', 'wordcount',
            ],
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Admin',
            mergetags_list: [{
                    value: 'First.Name',
                    title: 'First Name'
                },
                {
                    value: 'Email',
                    title: 'Email'
                },
            ],
            setup: function(editor) {
                editor.on('change', function() {
                    tinymce.triggerSave();
                });
            },
            ai_request: (request, respondWith) => respondWith.string(() => Promise.reject(
                "AI helper not available")),
            skin: (localStorage.getItem('color-theme') === 'dark' ? 'oxide-dark' : 'oxide'),
            content_css: (localStorage.getItem('color-theme') === 'dark' ? 'dark' : 'default'),
            branding: false,
            promotion: false,
        });
    </script>
@endpush
