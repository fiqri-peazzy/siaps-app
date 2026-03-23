<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BiodataMasyarakat;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BiodataValidationController extends Controller
{
    public function index()
    {
        $pendingBiodatas = BiodataMasyarakat::with('user')
            ->where('verification_status', 'pending')
            ->latest()
            ->paginate(10);

        return view('admin.biodata-validation.index', compact('pendingBiodatas'));
    }

    public function show(BiodataMasyarakat $biodata)
    {
        $biodata->load(['user', 'rt', 'agama', 'pekerjaan']);
        return view('admin.biodata-validation.show', compact('biodata'));
    }

    public function approve(Request $request, BiodataMasyarakat $biodata)
    {
        try {
            DB::beginTransaction();

            // 1. Create or Update Penduduk record
            $penduduk = Penduduk::updateOrCreate(
                ['nik' => $biodata->nik],
                [
                    'no_kk' => $biodata->no_kk ?? $biodata->nik,
                    'nama_lengkap' => $biodata->nama_lengkap,
                    'tempat_lahir' => $biodata->tempat_lahir,
                    'tanggal_lahir' => $biodata->tanggal_lahir,
                    'jenis_kelamin' => $biodata->jenis_kelamin,
                    'agama_id' => $biodata->agama_id,
                    'pekerjaan_id' => $biodata->pekerjaan_id,
                    'status_perkawinan' => $biodata->status_perkawinan,
                    'rt_id' => $biodata->rt_id,
                    'alamat_lengkap' => $biodata->alamat_lengkap,
                    'is_aktif' => true,
                    'status_penduduk' => 'tetap',
                ]
            );

            // 2. Link Biodata to Penduduk and mark as verified
            $biodata->update([
                'penduduk_id' => $penduduk->id,
                'verification_status' => 'verified',
                'verified_by' => Auth::id(),
                'verified_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('admin.biodata-validation.index')
                ->with('success', 'Biodata berhasil disetujui dan disinkronkan ke data penduduk.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyetujui biodata: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, BiodataMasyarakat $biodata)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $biodata->update([
            'verification_status' => 'rejected',
            'rejection_reason' => $request->reason,
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);

        return redirect()->route('admin.biodata-validation.index')
            ->with('info', 'Biodata telah ditolak.');
    }
}
