<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\JenisSurat;
use App\Models\ProfilDesa;
use App\Models\PengajuanSurat;
use App\Models\BiodataMasyarakat;
use Illuminate\Support\Facades\Auth;
use App\Services\PengajuanService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PengajuanController extends Controller
{
    private function getProfilDesa(): ProfilDesa
    {
        return ProfilDesa::getSingleton();
    }

    protected $pengajuanService;

    public function __construct(PengajuanService $pengajuanService)
    {
        $this->pengajuanService = $pengajuanService;
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
        $user = Auth::user();
        $biodata = BiodataMasyarakat::where('user_id', $user->id)->first();

        if (!$biodata) {
            return redirect()->route('masyarakat.profile')->with('error', 'Silakan lengkapi biodata Anda terlebih dahulu.');
        }

        // 1. Validation Logic
        $rules = [
            'keperluan' => 'required|string|max:500',
        ];

        // Dynamic fields validation
        $jenis_surat->load('fields', 'syarat');
        foreach ($jenis_surat->fields as $field) {
            $fieldRules = $field->validation_rules ?? 'nullable';
            if ($field->is_required) {
                $fieldRules = 'required|' . $fieldRules;
            }
            $rules["fields.{$field->field_key}"] = $fieldRules;
        }

        // Syarat documents validation
        foreach ($jenis_surat->syarat as $s) {
            $syaratRules = 'file|mimes:' . $s->allowed_types . '|max:' . $s->max_size_kb;
            if ($s->is_required) {
                $syaratRules = 'required|' . $syaratRules;
            } else {
                $syaratRules = 'nullable|' . $syaratRules;
            }
            $rules["syarat.{$s->id}"] = $syaratRules;
        }

        $request->validate($rules);

        try {
            DB::beginTransaction();

            // 2. Calculate Priority
            $priorityData = $this->pengajuanService->calculatePriorityScore($biodata, $jenis_surat);

            // 3. Create Pengajuan
            $pengajuan = PengajuanSurat::create([
                'kode_pengajuan' => $this->pengajuanService->generateKodePengajuan($jenis_surat),
                'user_id' => $user->id,
                'biodata_id' => $biodata->id,
                'jenis_surat_id' => $jenis_surat->id,
                'keperluan' => $request->keperluan,
                'field_data' => $request->fields ?? [],
                'priority_score' => $priorityData['total_score'],
                'priority_breakdown' => $priorityData['breakdown'],
                'status' => 'submitted',
                'submitted_at' => now(),
            ]);

            // 4. Handle Uploads
            if ($request->hasFile('syarat')) {
                foreach ($request->file('syarat') as $syaratId => $file) {
                    $syarat = $jenis_surat->syarat->find($syaratId);
                    if ($syarat) {
                        $path = $file->store('pengajuan/documents', 'public');

                        \App\Models\PengajuanDokumen::create([
                            'pengajuan_id' => $pengajuan->id,
                            'syarat_id' => $syarat->id,
                            'nama_dokumen' => $syarat->nama_syarat,
                            'original_filename' => $file->getClientOriginalName(),
                            'file_path' => $path,
                            'file_size' => $file->getSize(),
                            'mime_type' => $file->getMimeType(),
                            'upload_status' => 'uploaded',
                            'uploaded_at' => now(),
                        ]);
                    }
                }
            }

            // 5. Create History
            \App\Models\PengajuanHistory::create([
                'pengajuan_id' => $pengajuan->id,
                'from_status' => null,
                'to_status' => 'submitted',
                'priority_score_saat_itu' => $priorityData['total_score'],
                'actor_id' => $user->id,
                'actor_role' => 'masyarakat',
                'catatan' => 'Pengajuan surat berhasil dikirim.',
                'created_at' => now(),
            ]);

            // 6. Notify Admin (To be handled by NewPengajuanNotification)
            // TODO: Dispatch notification

            DB::commit();

            return redirect()->route('masyarakat.pengajuan.index')
                ->with('success', 'Pengajuan ' . $jenis_surat->nama . ' berhasil dikirim. Kode: ' . $pengajuan->kode_pengajuan);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal simpan pengajuan: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan pengajuan. Silakan coba lagi.')->withInput();
        }
    }

    public function show(PengajuanSurat $pengajuan)
    {
        // Ensure user only sees their own pengajuan
        if ($pengajuan->user_id !== Auth::id()) {
            abort(403);
        }

        $profil = $this->getProfilDesa();
        $pengajuan->load(['jenisSurat', 'history.actor', 'dokumen']);

        return view('masyarakat.pengajuan.show', compact('profil', 'pengajuan'));
    }
}
