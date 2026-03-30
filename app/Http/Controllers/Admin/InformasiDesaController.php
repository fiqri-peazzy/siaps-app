<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InformasiDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InformasiDesaController extends Controller
{
    public function index(Request $request)
    {
        $search   = $request->get('search');
        $kategori = $request->get('kategori');

        $informasi = InformasiDesa::with('penulis')
            ->when($search, fn($q) => $q->where('judul', 'like', "%{$search}%"))
            ->when($kategori, fn($q) => $q->where('kategori', $kategori))
            ->latest()
            ->paginate(15);

        return view('admin.cms.informasi.index', compact('informasi', 'search', 'kategori'));
    }

    public function create()
    {
        return view('admin.cms.informasi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori'     => 'required|in:pengumuman,berita,profil,layanan,agenda',
            'judul'        => 'required|string|max:200',
            'konten'       => 'required|string',
            'tags'         => 'nullable|string|max:255',
            'thumbnail'    => 'nullable|image|max:2048',
            'gallery.*'    => 'nullable|image|max:2048',
            'is_published' => 'boolean',
            'is_pinned'    => 'boolean',
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('informasi', 'public');
        }

        if ($request->hasFile('gallery')) {
            $galleryPaths = [];
            foreach ($request->file('gallery') as $file) {
                $galleryPaths[] = $file->store('informasi/gallery', 'public');
            }
            $validated['gallery'] = $galleryPaths;
        }

        $validated['slug']         = Str::slug($validated['judul']) . '-' . Str::random(5);
        $validated['created_by']   = Auth::id();
        $validated['is_published'] = $request->boolean('is_published');
        $validated['is_pinned']    = $request->boolean('is_pinned');
        $validated['published_at'] = $validated['is_published'] ? now() : null;

        InformasiDesa::create($validated);

        return redirect()->route('admin.cms.informasi.index')
            ->with('success', 'Informasi berhasil dipublikasikan.');
    }

    public function edit(InformasiDesa $informasi)
    {
        return view('admin.cms.informasi.edit', compact('informasi'));
    }

    public function update(Request $request, InformasiDesa $informasi)
    {
        $validated = $request->validate([
            'kategori'     => 'required|in:pengumuman,berita,profil,layanan,agenda',
            'judul'        => 'required|string|max:200',
            'konten'       => 'required|string',
            'tags'         => 'nullable|string|max:255',
            'thumbnail'    => 'nullable|image|max:2048',
            'gallery.*'    => 'nullable|image|max:2048',
            'remove_gallery.*' => 'nullable|string',
            'is_published' => 'boolean',
            'is_pinned'    => 'boolean',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($informasi->thumbnail) Storage::disk('public')->delete($informasi->thumbnail);
            $validated['thumbnail'] = $request->file('thumbnail')->store('informasi', 'public');
        }

        // Handle Gallery Removal
        $currentGallery = $informasi->gallery ?? [];
        if ($request->has('remove_gallery')) {
            foreach ($request->remove_gallery as $path) {
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
                $currentGallery = array_diff($currentGallery, [$path]);
            }
        }

        // Handle New Gallery Uploads
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $currentGallery[] = $file->store('informasi/gallery', 'public');
            }
        }
        $validated['gallery'] = array_values($currentGallery);

        $validated['updated_by']   = Auth::id();
        $validated['is_published'] = $request->boolean('is_published');
        $validated['is_pinned']    = $request->boolean('is_pinned');
        if ($validated['is_published'] && !$informasi->published_at) {
            $validated['published_at'] = now();
        }

        $informasi->update($validated);

        return redirect()->route('admin.cms.informasi.index')
            ->with('success', 'Informasi berhasil diperbarui.');
    }

    public function destroy(InformasiDesa $informasi)
    {
        if ($informasi->thumbnail) {
            Storage::disk('public')->delete($informasi->thumbnail);
        }
        if ($informasi->gallery) {
            foreach ($informasi->gallery as $path) {
                Storage::disk('public')->delete($path);
            }
        }
        $informasi->delete();
        return redirect()->route('admin.cms.informasi.index')
            ->with('success', 'Informasi berhasil dihapus.');
    }
}
