<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\MasterPekerjaan;

class MasterPekerjaanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $pekerjaans = MasterPekerjaan::when($search, fn($q) => $q->where('nama', 'like', "%{$search}%")
            ->orWhere('kode', 'like', "%{$search}%"))
            ->orderBy('nama')->get();
        return view('admin.master.pekerjaan.index', compact('pekerjaans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:master_pekerjaan',
            'kode' => 'nullable|string|max:20',
        ]);
        MasterPekerjaan::create($validated);
        return redirect()->route('admin.master.pekerjaan.index')->with('success', 'Pekerjaan berhasil ditambahkan.');
    }

    public function update(Request $request, MasterPekerjaan $pekerjaan)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:master_pekerjaan,nama,' . $pekerjaan->id,
            'kode' => 'nullable|string|max:20',
        ]);
        $pekerjaan->update($validated);
        return redirect()->route('admin.master.pekerjaan.index')->with('success', 'Pekerjaan berhasil diperbarui.');
    }

    public function destroy(MasterPekerjaan $pekerjaan)
    {
        $pekerjaan->delete();
        return redirect()->route('admin.master.pekerjaan.index')->with('success', 'Pekerjaan berhasil dihapus.');
    }
}
