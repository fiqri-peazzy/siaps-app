<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LetterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed Priority Bobot
        $priorityBobots = [
            ['kategori' => 'status_sosial', 'kode' => 'LANSIA', 'label' => 'Usia > 60 Tahun', 'bobot' => 2.00],
            ['kategori' => 'status_sosial', 'kode' => 'DISABILITAS', 'label' => 'Penyandang Disabilitas', 'bobot' => 3.00],
            ['kategori' => 'status_sosial', 'kode' => 'HAMIL', 'label' => 'Ibu Hamil', 'bobot' => 2.50],
            ['kategori' => 'aging', 'kode' => 'PER_HARI', 'label' => 'Tambahan per hari menunggu', 'bobot' => 0.10],
            ['kategori' => 'aging', 'kode' => 'MAX_AGING', 'label' => 'Maksimum bobot aging', 'bobot' => 5.00],
        ];

        foreach ($priorityBobots as $pb) {
            DB::table('priority_bobot')->updateOrInsert(['kode' => $pb['kode']], $pb);
        }

        // 2. Seed Jenis Surat & Syarat & Fields
        $letters = [
            [
                'kode' => 'SKTM',
                'nama' => 'Surat Keterangan Tidak Mampu',
                'base_priority' => 9,
                'sla_hari' => 2,
                'fields' => [
                    ['field_key' => 'keperluan', 'field_label' => 'Keperluan (Beasiswa/BPJS/Sekolah/dll)', 'field_type' => 'text', 'is_required' => true],
                ],
                'syarat' => ['Fotokopi KTP', 'Fotokopi KK', 'Surat Pengantar RT/RW'],
            ],
            [
                'kode' => 'SKD',
                'nama' => 'Surat Keterangan Domisili',
                'base_priority' => 6,
                'sla_hari' => 3,
                'fields' => [
                    ['field_key' => 'keperluan', 'field_label' => 'Keperluan', 'field_type' => 'text', 'is_required' => true],
                    ['field_key' => 'alamat_tujuan', 'field_label' => 'Alamat Tujuan Surat', 'field_type' => 'textarea', 'is_required' => true],
                ],
                'syarat' => ['Fotokopi KTP', 'Fotokopi KK'],
            ],
            [
                'kode' => 'SKU',
                'nama' => 'Surat Keterangan Usaha',
                'base_priority' => 5,
                'sla_hari' => 3,
                'fields' => [
                    ['field_key' => 'nama_usaha', 'field_label' => 'Nama Usaha', 'field_type' => 'text', 'is_required' => true],
                    ['field_key' => 'jenis_usaha', 'field_label' => 'Jenis Usaha', 'field_type' => 'text', 'is_required' => true],
                    ['field_key' => 'alamat_usaha', 'field_label' => 'Alamat Usaha', 'field_type' => 'textarea', 'is_required' => true],
                ],
                'syarat' => ['Fotokopi KTP', 'Foto Lokasi Usaha'],
            ],
            [
                'kode' => 'SK_KELAHIRAN',
                'nama' => 'Surat Keterangan Kelahiran',
                'base_priority' => 8,
                'sla_hari' => 2,
                'fields' => [
                    ['field_key' => 'nama_bayi', 'field_label' => 'Nama Bayi', 'field_type' => 'text', 'is_required' => true],
                    ['field_key' => 'tanggal_lahir_bayi', 'field_label' => 'Tanggal Lahir', 'field_type' => 'date', 'is_required' => true],
                    ['field_key' => 'nama_orang_tua', 'field_label' => 'Nama Orang Tua (Ayah/Ibu)', 'field_type' => 'text', 'is_required' => true],
                ],
                'syarat' => ['Surat Keterangan Lahir dari Bidan/RS', 'Fotokopi KTP Orang Tua', 'Fotokopi KK'],
            ],
        ];

        foreach ($letters as $l) {
            $fields = $l['fields'];
            $syarat = $l['syarat'];

            $letterData = [
                'kode' => $l['kode'],
                'nama' => $l['nama'],
                'base_priority' => $l['base_priority'],
                'sla_hari' => $l['sla_hari']
            ];

            DB::table('jenis_surat')->updateOrInsert(['kode' => $l['kode']], $letterData);

            $record = DB::table('jenis_surat')->where('kode', $l['kode'])->first();
            $jenisSuratId = $record->id;

            foreach ($fields as $idx => $f) {
                $f['jenis_surat_id'] = $jenisSuratId;
                $f['urutan'] = $idx;
                DB::table('jenis_surat_fields')->updateOrInsert(
                    ['jenis_surat_id' => $jenisSuratId, 'field_key' => $f['field_key']],
                    $f
                );
            }

            foreach ($syarat as $s) {
                DB::table('syarat_surat')->updateOrInsert(
                    ['jenis_surat_id' => $jenisSuratId, 'nama_syarat' => $s],
                    ['jenis_surat_id' => $jenisSuratId, 'nama_syarat' => $s]
                );
            }
        }
    }
}
