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
    public function calculatePriorityScore(BiodataMasyarakat $biodata, JenisSurat $jenisSurat, int $urgensi = 3): array
    {
        // Journal Algorithm: Higher is Higher Priority
        // Tier 1: (Jenis Surat Value) + (Urgensi Value)

        $jenisSuratValue = (int) $jenisSurat->base_priority; // Assigned 1-5
        $urgensiValue = $urgensi; // Input 1-4

        $tier1Score = $jenisSuratValue + $urgensiValue;
        $totalScore = (float) $tier1Score;

        $breakdown = [
            [
                'label' => 'Jenis Surat (' . $jenisSurat->nama . ')',
                'score' => $jenisSuratValue,
                'weight' => 'P1',
                'type' => 'base'
            ],
            [
                'label' => 'Tingkat Urgensi',
                'score' => $urgensiValue,
                'weight' => 'P1',
                'type' => 'base'
            ],
            [
                'label' => 'Subtotal Prioritas 1',
                'score' => $tier1Score,
                'type' => 'subtotal'
            ]
        ];

        // Enhancement: Add score for special conditions (Higher = More Priority)
        $bobots = PriorityBobot::where('is_active', true)->get()->keyBy('kode');

        // 1. Cek Lansia (> 60 tahun)
        $usia = Carbon::parse($biodata->tanggal_lahir)->age;
        if ($usia >= 60 && isset($bobots['LANSIA'])) {
            $bonus = (float) $bobots['LANSIA']->bobot;
            $totalScore += $bonus;
            $breakdown[] = [
                'label' => 'Bonus Lansia (Usia ' . $usia . ' thn)',
                'score' => $bonus,
                'type' => 'profile'
            ];
        }

        // 2. Cek Disabilitas
        if ($biodata->is_disabilitas && isset($bobots['DISABILITAS'])) {
            $bonus = (float) $bobots['DISABILITAS']->bobot;
            $totalScore += $bonus;
            $breakdown[] = [
                'label' => 'Bonus Disabilitas',
                'score' => $bonus,
                'type' => 'profile'
            ];
        }

        // 3. Cek Hamil (Khusus Perempuan)
        if ($biodata->is_hamil && $biodata->jenis_kelamin === 'P' && isset($bobots['HAMIL'])) {
            $bonus = (float) $bobots['HAMIL']->bobot;
            $totalScore += $bonus;
            $breakdown[] = [
                'label' => 'Bonus Ibu Hamil',
                'score' => $bonus,
                'type' => 'profile'
            ];
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
