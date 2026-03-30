<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Penduduk;
use App\Models\MasterAgama;
use App\Models\MasterPekerjaan;
use App\Models\MasterWilayah;

class PendudukController extends Controller
{
    public function index()
    {
        $penduduks = Penduduk::with(['agama', 'pekerjaan', 'rt', 'biodata'])->latest()->paginate(10);
        $agamas = MasterAgama::orderBy('nama')->get();
        $pekerjaans = MasterPekerjaan::orderBy('nama')->get();
        $rts = MasterWilayah::where('tipe', 'rt')->orderBy('nama')->get();

        return view('admin.master.penduduk.index', compact('penduduks', 'agamas', 'pekerjaans', 'rts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string|size:16|unique:penduduk',
            'no_kk' => 'required|string|size:16',
            'nama_lengkap' => 'required|string|max:150',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'agama_id' => 'required|exists:master_agama,id',
            'pekerjaan_id' => 'required|exists:master_pekerjaan,id',
            'status_perkawinan' => 'required|in:belum_kawin,kawin,cerai_hidup,cerai_mati',
            'golongan_darah' => 'nullable|in:A,B,AB,O,tidak_tahu',
            'kewarganegaraan' => 'required|string|max:10',
            'status_dalam_kk' => 'required|in:kepala_keluarga,istri,anak,lainnya',
            'rt_id' => 'required|exists:master_wilayah,id',
            'alamat_lengkap' => 'required|string',
            'status_penduduk' => 'required|in:tetap,sementara,tinggal',
            'is_aktif' => 'required|boolean',
        ]);

        Penduduk::create($validated);

        return redirect()->route('admin.master.penduduk.index')
            ->with('success', 'Data Penduduk berhasil ditambahkan.');
    }

    public function update(Request $request, Penduduk $penduduk)
    {
        $validated = $request->validate([
            'nik' => 'required|string|size:16|unique:penduduk,nik,' . $penduduk->id,
            'no_kk' => 'required|string|size:16',
            'nama_lengkap' => 'required|string|max:150',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'agama_id' => 'required|exists:master_agama,id',
            'pekerjaan_id' => 'required|exists:master_pekerjaan,id',
            'status_perkawinan' => 'required|in:belum_kawin,kawin,cerai_hidup,cerai_mati',
            'golongan_darah' => 'nullable|in:A,B,AB,O,tidak_tahu',
            'kewarganegaraan' => 'required|string|max:10',
            'status_dalam_kk' => 'required|in:kepala_keluarga,istri,anak,lainnya',
            'rt_id' => 'required|exists:master_wilayah,id',
            'alamat_lengkap' => 'required|string',
            'status_penduduk' => 'required|in:tetap,sementara,tinggal',
            'is_aktif' => 'required|boolean',
        ]);

        $penduduk->update($validated);

        return redirect()->route('admin.master.penduduk.index')
            ->with('success', 'Data Penduduk berhasil diperbarui.');
    }

    public function destroy(Penduduk $penduduk)
    {
        $penduduk->delete();
        return redirect()->route('admin.master.penduduk.index')
            ->with('success', 'Data Penduduk berhasil dihapus.');
    }
}
