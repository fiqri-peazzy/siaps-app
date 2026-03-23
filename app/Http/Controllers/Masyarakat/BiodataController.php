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
        $biodata = BiodataMasyarakat::firstOrNew(['user_id' => $user->id]);
        $isFotoKtpRequired = !$biodata->exists || !$biodata->foto_ktp;
        $isFotoKkRequired  = !$biodata->exists || !$biodata->foto_kk;

        $request->validate([
            'nik'               => 'required|digits:16',
            'no_kk'             => 'required|digits:16',
            'nama_lengkap'      => 'required|string|max:255',
            'tempat_lahir'      => 'required|string|max:100',
            'tanggal_lahir'     => 'required|date|before:today',
            'jenis_kelamin'     => 'required|in:L,P',
            'status_perkawinan' => 'required|in:belum_kawin,kawin,cerai_hidup,cerai_mati',
            'agama_id'          => 'required|exists:master_agama,id',
            'pekerjaan_id'      => 'required|exists:master_pekerjaan,id',
            'rt_id'             => 'required|exists:master_wilayah,id',
            'alamat_lengkap'    => 'required|string|min:10',
            'foto_ktp'          => ($isFotoKtpRequired ? 'required|' : 'nullable|') . 'image|mimes:jpg,jpeg,png|max:2048',
            'foto_kk'           => ($isFotoKkRequired  ? 'required|' : 'nullable|') . 'image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nik.digits'         => 'NIK harus terdiri dari 16 digit angka.',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini.',
            'foto_ktp.required'  => 'Foto KTP wajib diunggah.',
            'foto_kk.required'   => 'Foto KK wajib diunggah.',
            'foto_ktp.max'       => 'Ukuran foto KTP maksimal 2MB.',
            'foto_kk.max'        => 'Ukuran foto KK maksimal 2MB.',
        ]);

        $data = $request->except(['foto_ktp', 'foto_kk', '_token']);

        if ($request->hasFile('foto_ktp')) {
            if ($biodata->foto_ktp) Storage::disk('public')->delete($biodata->foto_ktp);
            $data['foto_ktp'] = $request->file('foto_ktp')->store('biodata/ktp', 'public');
        }

        if ($request->hasFile('foto_kk')) {
            if ($biodata->foto_kk) Storage::disk('public')->delete($biodata->foto_kk);
            $data['foto_kk'] = $request->file('foto_kk')->store('biodata/kk', 'public');
        }

        if ($biodata->verification_status !== 'verified') {
            $data['verification_status'] = 'pending';
        }

        $data['user_id'] = $user->id;
        $biodata->fill($data);
        $biodata->save();

        // Notify Admins
        $admins = \App\Models\User::where('role', 'admin')->get();
        \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\Admin\NewBiodataSubmittedNotification($biodata));

        return redirect()->route('masyarakat.profile')
            ->with('success', 'Biodata berhasil diperbarui dan sedang menunggu verifikasi Admin.');
    }
}
