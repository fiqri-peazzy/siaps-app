<?php

namespace App\Console\Commands;

use App\Models\PengajuanSurat;
use App\Services\PengajuanService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdatePriorityScore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'priority:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update priority scores for active submissions including aging factor';

    /**
     * Execute the console command.
     */
    public function handle(PengajuanService $pengajuanService)
    {
        $this->info('Starting priority score update...');

        $activeSubmissions = PengajuanSurat::whereIn('status', ['submitted', 'queued', 'in_process'])
            ->with(['biodata', 'jenisSurat'])
            ->get();

        $count = 0;
        foreach ($activeSubmissions as $pengajuan) {
            $priorityData = $pengajuanService->calculatePriorityScore(
                $pengajuan->biodata,
                $pengajuan->jenisSurat,
                (int) $pengajuan->urgensi,
                $pengajuan->submitted_at
            );

            $pengajuan->update([
                'priority_score' => $priorityData['total_score'],
                'priority_breakdown' => $priorityData['breakdown'],
                'last_priority_update' => now(),
            ]);
            
            $count++;
        }

        $this->info("Successfully updated {$count} submissions.");
        Log::info("Priority scores updated for {$count} submissions.");
    }
}
