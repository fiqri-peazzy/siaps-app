<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfilDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilDesaController extends Controller
{
    public function index()
    {
        $profil = ProfilDesa::getSingleton();
        return view('admin.cms.profil-desa.index', compact('profil'));
    }

    public function update(Request $request)
    {
        $profil = ProfilDesa::getSingleton();

        $validated = $request->validate([
            'nama_desa'      => 'required|string|max:100',
            'kode_desa'      => 'nullable|string|max:20',
            'kecamatan'      => 'nullable|string|max:100',
            'kabupaten'      => 'nullable|string|max:100',
            'provinsi'       => 'nullable|string|max:100',
            'kode_pos'       => 'nullable|string|max:10',
            'alamat_kantor'  => 'nullable|string',
            'telepon'        => 'nullable|string|max:20',
            'email'          => 'nullable|email|max:100',
            'website'        => 'nullable|url|max:150',
            'visi'           => 'nullable|string',
            'misi'           => 'nullable|string',
            'luas_wilayah'   => 'nullable|numeric',
            'jumlah_penduduk' => 'nullable|integer',
            'logo'           => 'nullable|image|max:2048',
            'kop_surat'      => 'nullable|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        if ($request->hasFile('logo')) {
            if ($profil->logo_path) Storage::disk('public')->delete($profil->logo_path);
            $validated['logo_path'] = $request->file('logo')->store('profil-desa', 'public');
        }
        if ($request->hasFile('kop_surat')) {
            if ($profil->kop_surat_path) Storage::disk('public')->delete($profil->kop_surat_path);
            $validated['kop_surat_path'] = $request->file('kop_surat')->store('profil-desa', 'public');
        }

        unset($validated['logo'], $validated['kop_surat']);
        $profil->update($validated);

        return redirect()->route('admin.cms.profil-desa.index')
            ->with('success', 'Profil desa berhasil diperbarui.');
    }
}
