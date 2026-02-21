<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PejabatDesa;
use App\Models\User;
use App\Models\MasterJabatan;

class PejabatDesaController extends Controller
{
    public function index()
    {
        $pejabats = PejabatDesa::with(['user', 'jabatan'])->get();
        $users = User::whereIn('role', ['admin', 'kepala_desa'])->orderBy('name')->get();
        $jabatans = MasterJabatan::orderBy('urutan')->get();

        return view('admin.master.pejabat-desa.index', compact('pejabats', 'users', 'jabatans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'jabatan_id' => 'required|exists:master_jabatan,id',
            'nip' => 'nullable|string|max:50',
            'sk_nomor' => 'nullable|string|max:100',
            'sk_tgl_mulai' => 'nullable|date',
            'sk_tgl_selesai' => 'nullable|date',
        ]);

        PejabatDesa::create($validated);

        return redirect()->route('admin.master.pejabat-desa.index')
            ->with('success', 'Pejabat Desa berhasil ditambahkan.');
    }

    public function update(Request $request, PejabatDesa $pejabatDesa)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'jabatan_id' => 'required|exists:master_jabatan,id',
            'nip' => 'nullable|string|max:50',
            'sk_nomor' => 'nullable|string|max:100',
            'sk_tgl_mulai' => 'nullable|date',
            'sk_tgl_selesai' => 'nullable|date',
            'is_active' => 'required|boolean',
        ]);

        $pejabatDesa->update($validated);

        return redirect()->route('admin.master.pejabat-desa.index')
            ->with('success', 'Pejabat Desa berhasil diperbarui.');
    }

    public function destroy(PejabatDesa $pejabatDesa)
    {
        $pejabatDesa->delete();
        return redirect()->route('admin.master.pejabat-desa.index')
            ->with('success', 'Pejabat Desa berhasil dihapus.');
    }
}
