<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanSurat;
use App\Models\PengajuanHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengajuanAdminController extends Controller
{
    /**
     * Display the DPS (Daftar Prioritas Surat) Dashboard
     */
    public function index()
    {
        // Get all active submissions sorted by priority score
        $submissions = PengajuanSurat::with(['user', 'jenisSurat', 'biodata'])
            ->whereNotIn('status', ['completed', 'rejected', 'cancelled'])
            ->orderBy('priority_score', 'desc')
            ->orderBy('submitted_at', 'asc')
            ->paginate(15);

        return view('admin.pengajuan.index', compact('submissions'));
    }

    /**
     * Display submission detail
     */
    public function show(PengajuanSurat $pengajuan)
    {
        $pengajuan->load(['user', 'jenisSurat', 'biodata', 'dokumen.syarat', 'history.actor']);

        return view('admin.pengajuan.show', compact('pengajuan'));
    }

    /**
     * Mark submission as "Processing"
     */
    public function process(PengajuanSurat $pengajuan)
    {
        if ($pengajuan->status !== 'submitted' && $pengajuan->status !== 'queued') {
            return back()->with('error', 'Status pengajuan tidak valid untuk diproses.');
        }

        try {
            DB::beginTransaction();

            $oldStatus = $pengajuan->status;
            $pengajuan->update([
                'status' => 'in_process',
                'process_started_at' => now(),
                'handled_by_admin' => Auth::id()
            ]);

            PengajuanHistory::create([
                'pengajuan_id' => $pengajuan->id,
                'from_status' => $oldStatus,
                'to_status' => 'in_process',
                'priority_score_saat_itu' => $pengajuan->priority_score,
                'actor_id' => Auth::id(),
                'actor_role' => 'admin',
                'catatan' => 'Pengajuan mulai diproses oleh admin.',
                'created_at' => now()
            ]);

            DB::commit();
            return back()->with('success', 'Pengajuan sedang diproses.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses pengajuan: ' . $e->getMessage());
        }
    }

    /**
     * Approve submission
     */
    public function approve(PengajuanSurat $pengajuan)
    {
        // Check lock
        if ($pengajuan->handled_by_admin && $pengajuan->handled_by_admin !== Auth::id()) {
            abort(403, 'Aksi tidak diizinkan. Pengajuan ini sedang ditangani oleh Admin lain.');
        }

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            $oldStatus = $pengajuan->status;

            // Generate PDF Draft
            $pengajuan->load([
                'biodata.user',
                'biodata.agama',
                'biodata.pekerjaan',
                'biodata.rt.parent.parent',
                'jenisSurat.fields',
            ]);

            // Check if directory exists
            if (!\Illuminate\Support\Facades\Storage::disk('public')->exists('surat_draft')) {
                \Illuminate\Support\Facades\Storage::disk('public')->makeDirectory('surat_draft');
            }

            // Load PDF view
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.draft.default', compact('pengajuan'));

            $filename = 'draft_' . $pengajuan->kode_pengajuan . '_' . time() . '.pdf';
            $path = 'surat_draft/' . $filename;

            // Save PDF
            \Illuminate\Support\Facades\Storage::disk('public')->put($path, $pdf->output());

            $pengajuan->update([
                'status' => 'validated',
                'validated_at' => now(),
                'surat_path' => $path
                // 'approved_by' and 'approved_at' are for Kepala Desa later
            ]);

            \App\Models\PengajuanHistory::create([
                'pengajuan_id' => $pengajuan->id,
                'from_status' => $oldStatus,
                'to_status' => 'validated',
                'priority_score_saat_itu' => $pengajuan->priority_score,
                'actor_id' => \Illuminate\Support\Facades\Auth::id(),
                'actor_role' => 'admin',
                'catatan' => 'Draf surat divalidasi dan di-generate. Menunggu persetujuan Kepala Desa.',
                'created_at' => now()
            ]);

            \Illuminate\Support\Facades\DB::commit();
            return redirect()->route('admin.pengajuan.index')->with('success', 'Pengajuan divalidasi. Draf surat berhasil dibuat.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            \Illuminate\Support\Facades\Log::error('Gagal approve pengajuan: ' . $e->getMessage() . ' | File: ' . $e->getFile() . ':' . $e->getLine());
            return back()->with('error', 'Gagal memvalidasi pengajuan: ' . $e->getMessage());
        }
    }

    /**
     * Reject submission
     */
    public function reject(Request $request, PengajuanSurat $pengajuan)
    {
        // Check lock
        if ($pengajuan->handled_by_admin && $pengajuan->handled_by_admin !== Auth::id()) {
            abort(403, 'Aksi tidak diizinkan. Pengajuan ini sedang ditangani oleh Admin lain.');
        }

        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $oldStatus = $pengajuan->status;
            $pengajuan->update([
                'status' => 'rejected',
                'rejection_reason' => $request->reason
            ]);

            PengajuanHistory::create([
                'pengajuan_id' => $pengajuan->id,
                'from_status' => $oldStatus,
                'to_status' => 'rejected',
                'priority_score_saat_itu' => $pengajuan->priority_score,
                'actor_id' => Auth::id(),
                'actor_role' => 'admin',
                'catatan' => 'Pengajuan ditolak: ' . $request->reason,
                'created_at' => now()
            ]);

            DB::commit();
            return redirect()->route('admin.pengajuan.index')->with('success', 'Pengajuan telah ditolak.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menolak pengajuan: ' . $e->getMessage());
        }
    }

    /**
     * Request Revision for submission
     */
    public function requestRevision(Request $request, PengajuanSurat $pengajuan)
    {
        // Check lock
        if ($pengajuan->handled_by_admin && $pengajuan->handled_by_admin !== Auth::id()) {
            abort(403, 'Aksi tidak diizinkan. Pengajuan ini sedang ditangani oleh Admin lain.');
        }

        $request->validate([
            'catatan_revisi' => 'required|string|max:1000'
        ]);

        try {
            DB::beginTransaction();

            $oldStatus = $pengajuan->status;

            // Update submission status to 'need_revision'
            $pengajuan->update([
                'status' => 'need_revision',
            ]);

            // Create revision record
            \App\Models\PengajuanRevisi::create([
                'pengajuan_id' => $pengajuan->id,
                'diminta_oleh' => Auth::id(),
                'catatan_revisi' => $request->catatan_revisi,
                'status' => 'pending'
            ]);

            PengajuanHistory::create([
                'pengajuan_id' => $pengajuan->id,
                'from_status' => $oldStatus,
                'to_status' => 'need_revision',
                'priority_score_saat_itu' => $pengajuan->priority_score,
                'actor_id' => Auth::id(),
                'actor_role' => 'admin',
                'catatan' => 'Admin meminta revisi: ' . substr($request->catatan_revisi, 0, 50) . '...',
                'created_at' => now()
            ]);

            DB::commit();
            return redirect()->route('admin.pengajuan.index')->with('success', 'Permintaan revisi telah dikirim ke pemohon.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal meminta revisi: ' . $e->getMessage());
        }
    }

    /**
     * Finalize the approved document
     */
    public function finalize(PengajuanSurat $pengajuan)
    {
        // Check if status is approved
        if ($pengajuan->status !== 'approved') {
            return back()->with('error', 'Hanya pengajuan yang telah disetujui Kepala Desa yang dapat difinalisasi.');
        }

        try {
            DB::beginTransaction();

            $oldStatus = $pengajuan->status;

            $pengajuan->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);

            PengajuanHistory::create([
                'pengajuan_id' => $pengajuan->id,
                'from_status' => $oldStatus,
                'to_status' => 'completed',
                'priority_score_saat_itu' => $pengajuan->priority_score,
                'actor_id' => Auth::id(),
                'actor_role' => 'admin',
                'catatan' => 'Surat selesai dan siap diunduh oleh warga.',
                'created_at' => now()
            ]);

            // Ensure user relationships exist, then send notification
            if ($pengajuan->user) {
                // We use our existing PengajuanStatusUpdated notification
                $pengajuan->user->notify(new \App\Notifications\PengajuanStatusUpdated($pengajuan));
            }

            DB::commit();

            return redirect()->route('admin.pengajuan.show', $pengajuan)
                ->with('success', 'Surat berhasil diselesaikan dan notifikasi telah dikirim ke warga.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::error('Finalize error: ' . $e->getMessage());
            return back()->with('error', 'Gagal menyelesaikan surat: ' . $e->getMessage());
        }
    }
}
