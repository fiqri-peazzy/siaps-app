<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\BiodataMasyarakat;
use App\Models\MasterAgama;
use App\Models\MasterPekerjaan;
use App\Models\MasterWilayah;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BiodataController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $biodata = BiodataMasyarakat::where('user_id', $user->id)->first() ?? new BiodataMasyarakat();
        $agamas = MasterAgama::orderBy('nama')->get();
        $pekerjaans = MasterPekerjaan::orderBy('nama')->get();
        $rts = MasterWilayah::where('tipe', 'rt')->orderBy('nama')->get();

        return view('masyarakat.biodata.index', compact('biodata', 'agamas', 'pekerjaans', 'rts'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'nik' => 'required|digits:16',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'agama_id' => 'required|exists:master_agama,id',
            'pekerjaan_id' => 'required|exists:master_pekerjaan,id',
            'rt_id' => 'required|exists:master_wilayah,id',
            'alamat_lengkap' => 'required|string',
            'foto_ktp' => 'nullable|image|max:2048',
            'foto_kk' => 'nullable|image|max:2048',
        ]);

        $biodata = BiodataMasyarakat::firstOrNew(['user_id' => $user->id]);
        $data = $request->except(['foto_ktp', 'foto_kk']);

        if ($request->hasFile('foto_ktp')) {
            if ($biodata->foto_ktp) Storage::disk('public')->delete($biodata->foto_ktp);
            $data['foto_ktp'] = $request->file('foto_ktp')->store('biodata/ktp', 'public');
        }

        if ($request->hasFile('foto_kk')) {
            if ($biodata->foto_kk) Storage::disk('public')->delete($biodata->foto_kk);
            $data['foto_kk'] = $request->file('foto_kk')->store('biodata/kk', 'public');
        }

        // Jika data lengkap, set status ke pending agar divalidasi admin
        if ($biodata->verification_status !== 'verified') {
            $data['verification_status'] = 'pending';
        }

        $biodata->fill($data);
        $biodata->save();

        return redirect()->back()->with('success', 'Biodata berhasil diperbarui dan sedang menunggu verifikasi.');
    }
}
