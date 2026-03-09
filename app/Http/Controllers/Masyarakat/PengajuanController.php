<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\JenisSurat;
use App\Models\ProfilDesa;
use App\Models\PengajuanSurat;
use App\Models\BiodataMasyarakat;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    private function getProfilDesa(): ProfilDesa
    {
        return ProfilDesa::getSingleton();
    }

    public function index()
    {
        $profil = $this->getProfilDesa();
        $layanan = JenisSurat::where('is_active', true)->get();

        // Cek pengajuan aktif
        $activeSubmissions = PengajuanSurat::where('user_id', Auth::id())
            ->whereNotIn('status', ['completed', 'rejected', 'cancelled'])
            ->with('jenisSurat')
            ->get();

        return view('masyarakat.pengajuan.index', compact('profil', 'layanan', 'activeSubmissions'));
    }

    public function create(JenisSurat $jenis_surat)
    {
        $profil = $this->getProfilDesa();

        // Pre-fetch related data for dynamic form and syarat
        $jenis_surat->load(['fields', 'syarat']);

        $biodata = BiodataMasyarakat::where('user_id', Auth::id())->first();

        // Check for duplicate active submission of same type
        $duplicate = PengajuanSurat::where('user_id', Auth::id())
            ->where('jenis_surat_id', $jenis_surat->id)
            ->whereNotIn('status', ['completed', 'rejected', 'cancelled'])
            ->first();

        if ($duplicate) {
            return redirect()->route('masyarakat.pengajuan.index')
                ->with('info', 'Anda memiliki pengajuan ' . $jenis_surat->nama . ' yang sedang diproses. Harap tunggu hingga selesai.');
        }

        return view('masyarakat.pengajuan.create', compact('profil', 'jenis_surat', 'biodata'));
    }

    public function store(Request $request, JenisSurat $jenis_surat)
    {
        // To be implemented in Stage 3
    }
}
