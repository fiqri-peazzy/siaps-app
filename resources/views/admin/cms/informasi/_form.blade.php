{{-- Shared form partial for create and edit --}}
<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-5">
        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul <span
                    class="text-red-500">*</span></label>
            <input type="text" name="judul" value="{{ old('judul', $informasi->judul ?? '') }}" required
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                placeholder="Judul informasi / berita...">
        </div>
        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Konten <span
                    class="text-red-500">*</span></label>
            <textarea name="konten" rows="15" required
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                placeholder="Tulis konten informasi di sini...">{{ old('konten', $informasi->konten ?? '') }}</textarea>
        </div>
    </div>

    <div class="space-y-5">
        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kategori <span
                    class="text-red-500">*</span></label>
            <select name="kategori" required
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <option value="pengumuman"
                    {{ old('kategori', $informasi->kategori ?? '') === 'pengumuman' ? 'selected' : '' }}>📢 Pengumuman
                </option>
                <option value="berita" {{ old('kategori', $informasi->kategori ?? '') === 'berita' ? 'selected' : '' }}>
                    📰 Berita</option>
                <option value="profil" {{ old('kategori', $informasi->kategori ?? '') === 'profil' ? 'selected' : '' }}>
                    🏛️ Profil</option>
                <option value="layanan"
                    {{ old('kategori', $informasi->kategori ?? '') === 'layanan' ? 'selected' : '' }}>🗂️ Layanan
                </option>
                <option value="agenda" {{ old('kategori', $informasi->kategori ?? '') === 'agenda' ? 'selected' : '' }}>
                    📅 Agenda</option>
            </select>
        </div>
        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Thumbnail</label>
            @if (!empty($informasi->thumbnail))
                <img src="{{ asset('storage/' . $informasi->thumbnail) }}"
                    class="h-24 rounded-lg object-cover mb-2 w-full" alt="thumbnail">
            @endif
            <input type="file" name="thumbnail" accept="image/*"
                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900/30 dark:file:text-blue-400">
            <p class="text-xs text-gray-400 mt-1">Max 2MB. Direkomendasikan 16:9</p>
        </div>
        <div class="flex items-center gap-3 pt-2">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_pinned" value="1"
                    {{ old('is_pinned', $informasi->is_pinned ?? false) ? 'checked' : '' }}
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">📌 Pin di atas</span>
            </label>
        </div>
        @if ($errors->any())
            <div
                class="p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg text-sm text-red-600 dark:text-red-400">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>
