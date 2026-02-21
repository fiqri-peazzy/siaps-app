<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\MasterWilayah;

class MasterWilayahController extends Controller
{
    public function index()
    {
        $wilayahs = MasterWilayah::with('parent')->orderBy('tipe')->orderBy('nama')->get();
        $parents = MasterWilayah::whereIn('tipe', ['desa', 'dusun', 'rw'])->orderBy('nama')->get();

        return view('admin.master.wilayah.index', compact('wilayahs', 'parents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'parent_id' => 'nullable|exists:master_wilayah,id',
            'tipe' => 'required|in:desa,dusun,rw,rt',
            'kode' => 'nullable|string|max:20',
            'nama' => 'required|string|max:100',
        ]);

        MasterWilayah::create($validated);

        return redirect()->route('admin.master.wilayah.index')
            ->with('success', 'Wilayah berhasil ditambahkan.');
    }

    public function update(Request $request, MasterWilayah $wilayah)
    {
        $validated = $request->validate([
            'parent_id' => 'nullable|exists:master_wilayah,id',
            'tipe' => 'required|in:desa,dusun,rw,rt',
            'kode' => 'nullable|string|max:20',
            'nama' => 'required|string|max:100',
            'is_active' => 'required|boolean',
        ]);

        $wilayah->update($validated);

        return redirect()->route('admin.master.wilayah.index')
            ->with('success', 'Wilayah berhasil diperbarui.');
    }

    public function destroy(MasterWilayah $wilayah)
    {
        $wilayah->delete();
        return redirect()->route('admin.master.wilayah.index')
            ->with('success', 'Wilayah berhasil dihapus.');
    }
}
