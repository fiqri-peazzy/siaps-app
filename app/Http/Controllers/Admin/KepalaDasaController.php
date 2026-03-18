<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanSurat;
use App\Models\PengajuanHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KepalaDasaController extends Controller
{
    /**
     * Show list of validated submissions awaiting Kepala Desa approval
     */
    public function index()
    {
        $submissions = PengajuanSurat::with(['biodata', 'jenisSurat', 'user'])
            ->whereIn('status', ['validated', 'approved', 'rejected'])
            ->orderByRaw("FIELD(status, 'validated', 'approved', 'rejected')")
            ->orderByDesc('validated_at')
            ->paginate(20);

        return view('admin.kades.index', compact('submissions'));
    }

    /**
     * Show the preview of a specific submission + draft PDF
     */
    public function show(PengajuanSurat $pengajuan)
    {
        $pengajuan->load(['biodata.user', 'jenisSurat.fields', 'dokumen.syarat', 'history.actor']);
        return view('admin.kades.show', compact('pengajuan'));
    }

    /**
     * Kepala Desa Approves the draft — changes status to approved -> ready
     */
    public function approve(PengajuanSurat $pengajuan)
    {
        if ($pengajuan->status !== 'validated') {
            return back()->with('error', 'Status pengajuan tidak valid untuk disetujui.');
        }

        // Generate nomor surat
        $year = now()->year;
        $month = now()->month;
        $count = PengajuanSurat::whereYear('approved_at', $year)
            ->whereMonth('approved_at', $month)
            ->where('status', 'approved')
            ->count() + 1;

        $nomorSurat = sprintf(
            '%03d/%s/%s/%02d/%d',
            $count,
            strtoupper($pengajuan->jenisSurat->kode),
            'DS.CIPAMUJUHAN',
            $month,
            $year
        );

        try {
            DB::beginTransaction();

            $pengajuan->update([
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => Auth::id(),
                'nomor_surat' => $nomorSurat,
            ]);

            PengajuanHistory::create([
                'pengajuan_id' => $pengajuan->id,
                'from_status' => 'validated',
                'to_status' => 'approved',
                'priority_score_saat_itu' => $pengajuan->priority_score,
                'actor_id' => Auth::id(),
                'actor_role' => 'kades',
                'catatan' => 'Surat disetujui oleh Kepala Desa. Nomor surat: ' . $nomorSurat,
                'created_at' => now()
            ]);

            // Regenerate PDF with nomor surat
            $pengajuan->refresh();
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.draft.default', compact('pengajuan'));
            $filename = 'surat_' . $pengajuan->kode_pengajuan . '.pdf';
            $path = 'surat_draft/' . $filename;
            \Illuminate\Support\Facades\Storage::disk('public')->put($path, $pdf->output());

            $pengajuan->update([
                'surat_path' => $path,
                'surat_generated_at' => now(),
            ]);

            DB::commit();
            return redirect()->route('admin.kades.index')->with('success', 'Surat berhasil disetujui. Nomor: ' . $nomorSurat);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyetujui surat: ' . $e->getMessage());
        }
    }

    /**
     * Kepala Desa Rejects the draft — moves back to in_process or sets rejected
     */
    public function reject(Request $request, PengajuanSurat $pengajuan)
    {
        if ($pengajuan->status !== 'validated') {
            return back()->with('error', 'Status pengajuan tidak valid untuk ditolak.');
        }

        $request->validate(['reason' => 'required|string|max:500']);

        try {
            DB::beginTransaction();

            $pengajuan->update([
                'status' => 'rejected',
            ]);

            PengajuanHistory::create([
                'pengajuan_id' => $pengajuan->id,
                'from_status' => 'validated',
                'to_status' => 'rejected',
                'priority_score_saat_itu' => $pengajuan->priority_score,
                'actor_id' => Auth::id(),
                'actor_role' => 'kades',
                'catatan' => 'Ditolak oleh Kepala Desa. Alasan: ' . $request->reason,
                'created_at' => now()
            ]);

            DB::commit();
            return redirect()->route('admin.kades.index')->with('success', 'Surat telah ditolak.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menolak surat: ' . $e->getMessage());
        }
    }
}
