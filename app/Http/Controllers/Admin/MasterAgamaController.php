<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\MasterAgama;

class MasterAgamaController extends Controller
{
    public function index()
    {
        $agamas = MasterAgama::orderBy('nama')->get();
        return view('admin.master.agama.index', compact('agamas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(['nama' => 'required|string|max:50|unique:master_agama']);
        MasterAgama::create($validated);
        return redirect()->route('admin.master.agama.index')->with('success', 'Agama berhasil ditambahkan.');
    }

    public function update(Request $request, MasterAgama $agama)
    {
        $validated = $request->validate(['nama' => 'required|string|max:50|unique:master_agama,nama,' . $agama->id]);
        $agama->update($validated);
        return redirect()->route('admin.master.agama.index')->with('success', 'Agama berhasil diperbarui.');
    }

    public function destroy(MasterAgama $agama)
    {
        $agama->delete();
        return redirect()->route('admin.master.agama.index')->with('success', 'Agama berhasil dihapus.');
    }
}
