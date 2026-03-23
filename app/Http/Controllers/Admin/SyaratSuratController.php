<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisSurat;
use App\Models\SyaratSurat;

class SyaratSuratController extends Controller
{
    public function index(JenisSurat $jenisSurat)
    {
        $syarats = $jenisSurat->syarat;
        return view('admin.master.syarat.index', compact('jenisSurat', 'syarats'));
    }

    public function store(Request $request, JenisSurat $jenisSurat)
    {
        $validated = $request->validate([
            'nama_syarat' => 'required|string|max:150',
            'deskripsi' => 'nullable|string|max:255',
            'is_required' => 'required|boolean',
            'max_size_kb' => 'required|integer|min:100',
            'allowed_types' => 'required|string|max:100',
        ]);

        $jenisSurat->syarat()->create($validated);

        return redirect()->route('admin.master.syarat.index', $jenisSurat)
            ->with('success', 'Syarat surat berhasil ditambahkan.');
    }

    public function update(Request $request, JenisSurat $jenisSurat, SyaratSurat $syarat)
    {
        $validated = $request->validate([
            'nama_syarat' => 'required|string|max:150',
            'deskripsi' => 'nullable|string|max:255',
            'is_required' => 'required|boolean',
            'max_size_kb' => 'required|integer|min:100',
            'allowed_types' => 'required|string|max:100',
        ]);

        $syarat->update($validated);

        return redirect()->route('admin.master.syarat.index', $jenisSurat)
            ->with('success', 'Syarat surat berhasil diperbarui.');
    }

    public function destroy(JenisSurat $jenisSurat, SyaratSurat $syarat)
    {
        $syarat->delete();
        return redirect()->route('admin.master.syarat.index', $jenisSurat)
            ->with('success', 'Syarat surat berhasil dihapus.');
    }
}
