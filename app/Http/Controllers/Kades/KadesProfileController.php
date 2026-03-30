<?php

namespace App\Http\Controllers\Kades;

use App\Http\Controllers\Controller;
use App\Models\PejabatDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KadesProfileController extends Controller
{
    public function signature()
    {
        $pejabat = PejabatDesa::where('user_id', Auth::id())->first();

        if (!$pejabat) {
            return redirect()->route('dashboard')->with('error', 'Data Pejabat Desa tidak ditemukan untuk akun Anda.');
        }

        return view('admin.kades.signature', compact('pejabat'));
    }

    public function updateSignature(Request $request)
    {
        $pejabat = PejabatDesa::where('user_id', Auth::id())->first();

        if (!$pejabat) {
            return back()->with('error', 'Data Pejabat Desa tidak ditemukan.');
        }

        $request->validate([
            'tanda_tangan' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'stempel_path' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'nip'          => 'nullable|string|max:50',
        ]);

        if ($request->hasFile('tanda_tangan')) {
            if ($pejabat->tanda_tangan) {
                Storage::disk('public')->delete($pejabat->tanda_tangan);
            }
            $pejabat->tanda_tangan = $request->file('tanda_tangan')->store('signatures', 'public');
        }

        if ($request->hasFile('stempel_path')) {
            if ($pejabat->stempel_path) {
                Storage::disk('public')->delete($pejabat->stempel_path);
            }
            $pejabat->stempel_path = $request->file('stempel_path')->store('stamps', 'public');
        }

        if ($request->has('nip')) {
            $pejabat->nip = $request->nip;
        }

        $pejabat->save();

        return back()->with('success', 'Tanda tangan dan stempel berhasil diperbarui.');
    }
}
