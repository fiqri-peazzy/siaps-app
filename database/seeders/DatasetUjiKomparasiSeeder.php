<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\BiodataMasyarakat;
use App\Models\JenisSurat;
use App\Models\PengajuanSurat;
use App\Services\PengajuanService;
use Carbon\Carbon;

class DatasetUjiKomparasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(PengajuanService $pengajuanService): void
    {
        // Data dari User:
        // A | Surat Keterangan Tidak Mampu (9) | Mendesak (3) | 0 Hari
        // B | Surat Keterangan Usaha (5) | Biasa (2) | 10 Hari
        // C | Surat Keterangan Kematian (10) | Sangat Mendesak (4) | 0 Hari
        // D | Surat Keterangan Domisili (6) | Tidak Mendesak (1) | 0 Hari
        // E | Surat Keterangan Kelahiran (8) | Biasa (2) | 5 Hari

        $dataset = [
            [
                'pemohon' => 'Pemohon A',
                'kode_surat' => 'SKTM',
                'urgensi_key' => 2, // Mendesak (Score 3)
                'waktu_tunggu' => 0,
            ],
            [
                'pemohon' => 'Pemohon B',
                'kode_surat' => 'SKU',
                'urgensi_key' => 3, // Biasa (Score 2)
                'waktu_tunggu' => 10,
            ],
            [
                'pemohon' => 'Pemohon C',
                'kode_surat' => 'S_MATI',
                'urgensi_key' => 1, // Sangat Mendesak (Score 4)
                'waktu_tunggu' => 0,
            ],
            [
                'pemohon' => 'Pemohon D',
                'kode_surat' => 'SKD',
                'urgensi_key' => 4, // Tidak Mendesak (Score 1)
                'waktu_tunggu' => 0,
            ],
            [
                'pemohon' => 'Pemohon E',
                'kode_surat' => 'S_LAHIR',
                'urgensi_key' => 3, // Biasa (Score 2)
                'waktu_tunggu' => 5,
            ],
        ];

        DB::beginTransaction();

        try {
            foreach ($dataset as $idx => $data) {
                // 1. Create User
                $user = User::firstOrCreate(
                    ['phone' => '08000000000' . $idx],
                    [
                        'name' => $data['pemohon'],
                        'role' => 'masyarakat',
                        'status' => 'active',
                    ]
                );

                // 2. Create Biodata (minimal untuk requirement validasi)
                $biodata = BiodataMasyarakat::firstOrCreate(
                    ['user_id' => $user->id],
                    [
                        'nik' => '320000000000000' . $idx,
                        'nama_lengkap' => $data['pemohon'],
                        'tempat_lahir' => 'Kota A',
                        'tanggal_lahir' => '1990-01-01',
                        'jenis_kelamin' => 'L',
                        'status_perkawinan' => 'belum_kawin',
                        'alamat_lengkap' => 'Jl. Pengujian No. ' . $idx,
                        'verification_status' => 'verified' // langsung verified
                    ]
                );

                // 3. Get Jenis Surat
                $jenisSurat = JenisSurat::where('kode', $data['kode_surat'])->first();
                
                if (!$jenisSurat) {
                    $this->command->warn("Jenis Surat dengan kode {$data['kode_surat']} tidak ditemukan. Skip...");
                    continue;
                }

                // Waktu tunggu (Aging) di-set dengan mengubah submitted_at mundur ke masa lalu
                $submittedDate = Carbon::now()->subDays($data['waktu_tunggu']);

                // Calculate Priority Score using the App Service
                $priorityData = $pengajuanService->calculatePriorityScore($biodata, $jenisSurat, $data['urgensi_key'], $submittedDate);

                // 4. Create Pengajuan Surat
                $pengajuan = PengajuanSurat::create([
                    'kode_pengajuan' => 'UJI-2026-' . str_pad($idx + 1, 4, '0', STR_PAD_LEFT),
                    'user_id' => $user->id,
                    'biodata_id' => $biodata->id,
                    'jenis_surat_id' => $jenisSurat->id,
                    'keperluan' => 'Pengujian Algoritma Prioritas - Dataset Komparasi',
                    'field_data' => json_encode(['catatan' => 'Data dummy untuk uji komparasi urgensi dan aging']),
                    'status' => 'queued',
                    'priority_score' => $priorityData['total_score'],
                    'priority_breakdown' => json_encode($priorityData['breakdown']),
                    'submitted_at' => $submittedDate,
                    'queued_at' => $submittedDate,
                    // created_at dan updated_at bisa di override jika perlu, tapi kita biarkan default / kita set manual
                ]);

                // Update timestamps manually karena eloquent akan set created_at ke now()
                $pengajuan->created_at = $submittedDate;
                $pengajuan->updated_at = $submittedDate;
                $pengajuan->save(['timestamps' => false]);

                $this->command->info("Seeded: {$data['pemohon']} | {$jenisSurat->nama} | Urgensi: {$data['urgensi_key']} | Score: {$priorityData['total_score']}");
            }

            DB::commit();
            $this->command->info('Dataset Uji Komparasi berhasil di-seed.');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Gagal melakukan seed: ' . $e->getMessage());
        }
    }
}
