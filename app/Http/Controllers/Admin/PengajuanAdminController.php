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
    public function approve(Request $request, PengajuanSurat $pengajuan)
    {
        // Implementation for Stage 6 / Final Approval logic
        // For now, just mark as approved
        try {
            DB::beginTransaction();

            $oldStatus = $pengajuan->status;
            $pengajuan->update([
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => Auth::id()
            ]);

            PengajuanHistory::create([
                'pengajuan_id' => $pengajuan->id,
                'from_status' => $oldStatus,
                'to_status' => 'approved',
                'priority_score_saat_itu' => $pengajuan->priority_score,
                'actor_id' => Auth::id(),
                'actor_role' => 'admin',
                'catatan' => 'Pengajuan disetujui.',
                'created_at' => now()
            ]);

            DB::commit();
            return redirect()->route('admin.pengajuan.index')->with('success', 'Pengajuan berhasil disetujui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyetujui pengajuan: ' . $e->getMessage());
        }
    }

    /**
     * Reject submission
     */
    public function reject(Request $request, PengajuanSurat $pengajuan)
    {
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
}
