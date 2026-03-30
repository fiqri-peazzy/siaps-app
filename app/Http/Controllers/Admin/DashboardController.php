<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BiodataMasyarakat;
use App\Models\PengajuanSurat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Basic Stats
        $stats = [
            'total_penduduk' => BiodataMasyarakat::count(),
            'pending_validasi' => BiodataMasyarakat::where('verification_status', 'pending')->count(),
            'pending_pengajuan' => PengajuanSurat::where('status', 'submitted')->count(),
            'kades_approval' => PengajuanSurat::where('status', 'validated')->count(),
            'completed_today' => PengajuanSurat::where('status', 'completed')
                ->whereDate('completed_at', Carbon::today())
                ->count(),
            'completed_month' => PengajuanSurat::where('status', 'completed')
                ->whereMonth('completed_at', Carbon::now()->month)
                ->whereYear('completed_at', Carbon::now()->year)
                ->count(),
        ];

        // 2. Chart Data (Last 7 Days)
        $days = collect();
        $chartData = collect();

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $days->push($date->isoFormat('DD MMM'));

            $count = PengajuanSurat::whereIn('status', ['approved', 'ready', 'completed'])
                ->whereDate('approved_at', $date)
                ->count();
            $chartData->push($count);
        }

        // 3. Recent Submissions
        $recentSubmissions = PengajuanSurat::with(['biodata', 'jenisSurat'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('dashboard', compact('stats', 'days', 'chartData', 'recentSubmissions'));
    }
}
