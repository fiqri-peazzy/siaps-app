<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PejabatDesa;
use App\Models\User;
use App\Models\MasterJabatan;

class PejabatDesaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $pejabats = PejabatDesa::with(['user', 'jabatan'])
            ->when($search, fn($q) => $q->whereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"))
                ->orWhere('nip', 'like', "%{$search}%"))
            ->get();
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
            'periode_mulai' => 'required|date',
            'periode_selesai' => 'nullable|date',
        ]);

        PejabatDesa::create($validated);

        return redirect()->route('admin.master.pejabat-desa.index')
            ->with('success', 'Pejabat Desa berhasil ditambahkan.');
    }

    public function update(Request $request, PejabatDesa $pejabat_desa)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'jabatan_id' => 'required|exists:master_jabatan,id',
            'nip' => 'nullable|string|max:50',
            'sk_nomor' => 'nullable|string|max:100',
            'periode_mulai' => 'required|date',
            'periode_selesai' => 'nullable|date',
            'is_aktif' => 'required|boolean',
        ]);

        $pejabat_desa->update($validated);

        return redirect()->route('admin.master.pejabat-desa.index')
            ->with('success', 'Pejabat Desa berhasil diperbarui.');
    }

    public function destroy(PejabatDesa $pejabat_desa)
    {
        $pejabat_desa->delete();
        return redirect()->route('admin.master.pejabat-desa.index')
            ->with('success', 'Pejabat Desa berhasil dihapus.');
    }
}
