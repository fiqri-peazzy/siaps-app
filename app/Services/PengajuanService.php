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
    public function calculatePriorityScore(BiodataMasyarakat $biodata, JenisSurat $jenisSurat): array
    {
        $baseScore = (float) $jenisSurat->base_priority;
        $totalScore = $baseScore;
        $breakdown = [
            [
                'label' => 'Base Priority (' . $jenisSurat->nama . ')',
                'score' => $baseScore,
                'type' => 'base'
            ]
        ];

        // Ambil semua bobot dari database
        $bobots = PriorityBobot::where('is_active', true)->get()->keyBy('kode');

        // 1. Cek Lansia (> 60 tahun)
        $usia = Carbon::parse($biodata->tanggal_lahir)->age;
        if ($usia >= 60 && isset($bobots['LANSIA'])) {
            $score = (float) $bobots['LANSIA']->bobot;
            $totalScore += $score;
            $breakdown[] = [
                'label' => 'Lansia (Usia ' . $usia . ' thn)',
                'score' => $score,
                'type' => 'profile'
            ];
        }

        // 2. Cek Disabilitas
        if ($biodata->is_disabilitas && isset($bobots['DISABILITAS'])) {
            $score = (float) $bobots['DISABILITAS']->bobot;
            $totalScore += $score;
            $breakdown[] = [
                'label' => 'Disabilitas',
                'score' => $score,
                'type' => 'profile'
            ];
        }

        // 3. Cek Hamil (Khusus Perempuan & sudah kawin/pernah)
        if ($biodata->is_hamil && $biodata->jenis_kelamin === 'P' && isset($bobots['HAMIL'])) {
            $score = (float) $bobots['HAMIL']->bobot;
            $totalScore += $score;
            $breakdown[] = [
                'label' => 'Ibu Hamil',
                'score' => $score,
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
