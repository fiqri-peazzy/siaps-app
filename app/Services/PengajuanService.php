<?php

namespace App\Services;

use App\Models\BiodataMasyarakat;
use App\Models\JenisSurat;
use App\Models\PriorityBobot;
use Carbon\Carbon;

class PengajuanService
{
    /**
     * Hitung Skor Prioritas berdasarkan Profil Masyarakat dan Jenis Surat
     */
    public function calculatePriorityScore(BiodataMasyarakat $biodata, JenisSurat $jenisSurat, int $urgensi = 3, ?Carbon $submittedAt = null): array
    {
        /**
         * ALGORITMA PENJADWALAN PRIORITAS (HIGHER IS BETTER)
         * Tier 1: (Jenis Surat Score + Level Urgensi Score)
         * Aging: +1 poin per hari menunggu (menambah bobot prioritas)
         */

        $jenisSuratScore = (int) $jenisSurat->base_priority; // 5 (Penghasilan) s/d 1 (SKTM)
        
        // Invert Urgensi: 1(Sangat Mendesak)->4 pts, 4(Tidak Mendesak)->1 pt
        $urgensiScores = [
            1 => 4, // Sangat Mendesak
            2 => 3, // Mendesak
            3 => 2, // Biasa
            4 => 1  // Tidak Mendesak
        ];
        $urgensiLabels = [
            1 => 'Sangat Mendesak',
            2 => 'Mendesak',
            3 => 'Biasa',
            4 => 'Tidak Mendesak'
        ];
        
        $urgensiScore = $urgensiScores[$urgensi] ?? 1;

        $baseScore = $jenisSuratScore + $urgensiScore;
        $totalScore = (float) $baseScore;

        $breakdown = [
            [
                'label' => 'Jenis Surat (' . $jenisSurat->nama . ')',
                'score' => $jenisSuratScore,
                'type' => 'base'
            ],
            [
                'label' => 'Level Urgensi (' . ($urgensiLabels[$urgensi] ?? 'N/A') . ')',
                'score' => $urgensiScore,
                'type' => 'base'
            ],
            [
                'label' => 'Subtotal Prioritas Dasar',
                'score' => $baseScore,
                'type' => 'subtotal'
            ]
        ];

        // Enhancement: Aging (Wait Time) - Penambahan skor per hari (Higher is Better)
        if ($submittedAt) {
            $bobots = PriorityBobot::where('is_active', true)->get()->keyBy('kode');
            $perHari = isset($bobots['PER_HARI']) ? (float) $bobots['PER_HARI']->bobot : 1.0;
            $maxAging = isset($bobots['MAX_AGING']) ? (float) $bobots['MAX_AGING']->bobot : 5.0;
            
            $daysWaiting = floor($submittedAt->diffInDays(now()));
            if ($daysWaiting > 0) {
                $agingBonus = $daysWaiting * $perHari;
                
                // Cap the aging bonus if MAX_AGING is defined
                if ($agingBonus > $maxAging) {
                    $agingBonus = $maxAging;
                }
                
                $totalScore += $agingBonus;

                $breakdown[] = [
                    'label' => 'Aging (Menunggu ' . $daysWaiting . ' hari)',
                    'score' => $agingBonus,
                    'type' => 'aging',
                    'detail' => $agingBonus == $maxAging ? 'Maksimal bobot tercapai' : $daysWaiting . ' hari x +' . $perHari
                ];
            }
        }

        return [
            'total_score' => $totalScore,
            'breakdown' => $breakdown
        ];
    }

    /**
     * Generate Kode Pengajuan Unik
     */
    public function generateKodePengajuan(JenisSurat $jenisSurat): string
    {
        $prefix = strtoupper($jenisSurat->kode);
        $date = now()->format('Ymd');

        // Count today's submissions to get increment
        $count = \App\Models\PengajuanSurat::whereDate('created_at', Carbon::today())->count();
        $sequence = str_pad($count + 1, 3, '0', STR_PAD_LEFT);

        return "REG-{$prefix}-{$date}-{$sequence}";
    }
}
