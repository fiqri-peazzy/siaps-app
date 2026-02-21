<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\JenisSurat;

class JenisSuratController extends Controller
{
    public function index()
    {
        $jenisSurats = JenisSurat::orderBy('nama')->get();
        return view('admin.master.jenis-surat.index', compact('jenisSurats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:20|unique:jenis_surat',
            'nama' => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'base_priority' => 'required|integer|min:1|max:10',
            'sla_hari' => 'required|integer|min:1',
            'nomor_format' => 'nullable|string|max:100',
        ]);

        JenisSurat::create($validated);

        return redirect()->route('admin.master.jenis-surat.index')
            ->with('success', 'Jenis Surat berhasil ditambahkan.');
    }

    public function update(Request $request, JenisSurat $jenisSurat)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:20|unique:jenis_surat,kode,' . $jenisSurat->id,
            'nama' => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'base_priority' => 'required|integer|min:1|max:10',
            'sla_hari' => 'required|integer|min:1',
            'nomor_format' => 'nullable|string|max:100',
            'is_active' => 'required|boolean',
        ]);

        $jenisSurat->update($validated);

        return redirect()->route('admin.master.jenis-surat.index')
            ->with('success', 'Jenis Surat berhasil diperbarui.');
    }

    public function destroy(JenisSurat $jenisSurat)
    {
        $jenisSurat->delete();
        return redirect()->route('admin.master.jenis-surat.index')
            ->with('success', 'Jenis Surat berhasil dihapus.');
    }
}
