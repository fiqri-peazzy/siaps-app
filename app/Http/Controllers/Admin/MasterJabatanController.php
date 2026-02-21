<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\MasterJabatan;

class MasterJabatanController extends Controller
{
    public function index()
    {
        $jabatans = MasterJabatan::orderBy('urutan')->get();
        return view('admin.master.jabatan.index', compact('jabatans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_jabatan' => 'required|string|max:100|unique:master_jabatan',
            'singkatan' => 'nullable|string|max:20',
            'is_penandatangan' => 'required|boolean',
            'urutan' => 'required|integer',
        ]);

        MasterJabatan::create($validated);

        return redirect()->route('admin.master.jabatan.index')
            ->with('success', 'Jabatan berhasil ditambahkan.');
    }

    public function update(Request $request, MasterJabatan $jabatan)
    {
        $validated = $request->validate([
            'nama_jabatan' => 'required|string|max:100|unique:master_jabatan,nama_jabatan,' . $jabatan->id,
            'singkatan' => 'nullable|string|max:20',
            'is_penandatangan' => 'required|boolean',
            'urutan' => 'required|integer',
        ]);

        $jabatan->update($validated);

        return redirect()->route('admin.master.jabatan.index')
            ->with('success', 'Jabatan berhasil diperbarui.');
    }

    public function destroy(MasterJabatan $jabatan)
    {
        $jabatan->delete();
        return redirect()->route('admin.master.jabatan.index')
            ->with('success', 'Jabatan berhasil dihapus.');
    }
}
