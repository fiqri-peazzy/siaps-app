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
        // 1. Seed Jenis Surat & Syarat & Fields
        $letters = [
            // --- KATEGORI 1: SURAT KETERANGAN UMUM ---
            [
                'kode' => 'SKTM',
                'nama' => 'Surat Keterangan Tidak Mampu (SKTM)',
                'deskripsi' => 'Untuk pengajuan beasiswa, keringanan biaya RS, atau bantuan sosial.',
                'base_priority' => 9,
                'sla_hari' => 2,
                'fields' => [
                    ['field_key' => 'keperluan', 'field_label' => 'Keperluan (Beasiswa/RS/Bansos)', 'field_type' => 'text', 'is_required' => true],
                ],
                'syarat' => [
                    ['nama' => 'Fotokopi KTP', 'deskripsi' => 'KTP Pemohon'],
                    ['nama' => 'Fotokopi KK', 'deskripsi' => 'Kartu Keluarga'],
                    ['nama' => 'Surat Pengantar RT/RW', 'deskripsi' => 'Tanda tangan RT dan RW setempat'],
                    ['nama' => 'Foto Rumah', 'deskripsi' => 'Foto kondisi rumah tampak depan'],
                ],
            ],
            [
                'kode' => 'SKU',
                'nama' => 'Surat Keterangan Usaha (SKU)',
                'deskripsi' => 'Untuk syarat pengajuan kredit bank (KUR) atau bantuan UMKM.',
                'base_priority' => 5,
                'sla_hari' => 3,
                'fields' => [
                    ['field_key' => 'nama_usaha', 'field_label' => 'Nama Usaha', 'field_type' => 'text', 'is_required' => true],
                    ['field_key' => 'jenis_usaha', 'field_label' => 'Jenis Usaha (Perdagangan/Jasa/dll)', 'field_type' => 'text', 'is_required' => true],
                    ['field_key' => 'alamat_usaha', 'field_label' => 'Alamat Lengkap Usaha', 'field_type' => 'textarea', 'is_required' => true],
                    ['field_key' => 'lama_usaha', 'field_label' => 'Lama Usaha (Tahun)', 'field_type' => 'number', 'is_required' => true],
                ],
                'syarat' => [
                    ['nama' => 'Fotokopi KTP', 'deskripsi' => 'KTP Pemilik Usaha'],
                    ['nama' => 'Fotokopi KK', 'deskripsi' => 'Kartu Keluarga'],
                    ['nama' => 'Surat Pengantar RT/RW', 'deskripsi' => 'Tanda tangan RT dan RW setempat'],
                    ['nama' => 'Foto Lokasi Usaha', 'deskripsi' => 'Foto tempat usaha dijalankan'],
                ],
            ],
            [
                'kode' => 'SKD',
                'nama' => 'Surat Keterangan Domisili',
                'deskripsi' => 'Untuk pendatang atau warga yang tinggal sementara namun butuh bukti alamat setempat.',
                'base_priority' => 6,
                'sla_hari' => 3,
                'fields' => [
                    ['field_key' => 'keperluan', 'field_label' => 'Keperluan Domisili', 'field_type' => 'text', 'is_required' => true],
                    ['field_key' => 'alamat_asal', 'field_label' => 'Alamat Asal (Sesuai KTP)', 'field_type' => 'textarea', 'is_required' => true],
                ],
                'syarat' => [
                    ['nama' => 'Fotokopi KTP', 'deskripsi' => 'KTP Pemohon'],
                    ['nama' => 'Fotokopi KK', 'deskripsi' => 'Kartu Keluarga Asal'],
                    ['nama' => 'Surat Pengantar RT/RW', 'deskripsi' => 'Tanda tangan RT dan RW setempat'],
                ],
            ],
            [
                'kode' => 'SKBB',
                'nama' => 'Surat Keterangan Berkelakuan Baik',
                'deskripsi' => 'Biasanya untuk melamar kerja di tingkat lokal atau syarat administrasi tertentu.',
                'base_priority' => 5,
                'sla_hari' => 2,
                'fields' => [
                    ['field_key' => 'keperluan', 'field_label' => 'Keperluan (Melamar Kerja/dll)', 'field_type' => 'text', 'is_required' => true],
                ],
                'syarat' => [
                    ['nama' => 'Fotokopi KTP', 'deskripsi' => 'KTP Pemohon'],
                    ['nama' => 'Fotokopi KK', 'deskripsi' => 'Kartu Keluarga'],
                    ['nama' => 'Surat Pengantar RT/RW', 'deskripsi' => 'Tanda tangan RT dan RW setempat'],
                ],
            ],

            // --- KATEGORI 2: KEPENDUDUKAN & CATATAN SIPIL ---
            [
                'kode' => 'P_KTP_KK',
                'nama' => 'Surat Pengantar Pembuatan KTP/KK',
                'deskripsi' => 'Digunakan jika ada perubahan data atau pembuatan baru di Dukcapil.',
                'base_priority' => 7,
                'sla_hari' => 2,
                'fields' => [
                    ['field_key' => 'alasan', 'field_label' => 'Alasan (Baru/Rusak/Hilang/Perubahan)', 'field_type' => 'select', 'field_options' => json_encode(['Baru', 'Rusak', 'Hilang', 'Perubahan Data']), 'is_required' => true],
                ],
                'syarat' => [
                    ['nama' => 'KK Lama / Fotokopi', 'deskripsi' => 'Jika perubahan data'],
                    ['nama' => 'Surat Pengantar RT/RW', 'deskripsi' => 'Tanda tangan RT dan RW setempat'],
                    ['nama' => 'Surat Kehilangan Kepolisian', 'deskripsi' => 'Jika KTP/KK hilang', 'is_required' => false],
                ],
            ],
            [
                'kode' => 'S_LAHIR',
                'nama' => 'Surat Keterangan Kelahiran',
                'deskripsi' => 'Untuk dasar pembuatan Akta Kelahiran.',
                'base_priority' => 8,
                'sla_hari' => 2,
                'fields' => [
                    ['field_key' => 'nama_anak', 'field_label' => 'Nama Anak', 'field_type' => 'text', 'is_required' => true],
                    ['field_key' => 'tempat_lahir_anak', 'field_label' => 'Tempat Lahir', 'field_type' => 'text', 'is_required' => true],
                    ['field_key' => 'tanggal_lahir_anak', 'field_label' => 'Tanggal Lahir', 'field_type' => 'date', 'is_required' => true],
                    ['field_key' => 'nama_ayah', 'field_label' => 'Nama Ayah', 'field_type' => 'text', 'is_required' => true],
                    ['field_key' => 'nama_ibu', 'field_label' => 'Nama Ibu', 'field_type' => 'text', 'is_required' => true],
                ],
                'syarat' => [
                    ['nama' => 'Suket Lahir RS/Bidan', 'deskripsi' => 'Asli dari penolong kelahiran'],
                    ['nama' => 'Fotokopi KTP Orang Tua', 'deskripsi' => 'Ayah dan Ibu'],
                    ['nama' => 'Fotokopi KK', 'deskripsi' => 'Kartu Keluarga'],
                    ['nama' => 'Fotokopi Buku Nikah', 'deskripsi' => 'Legalisir'],
                ],
            ],
            [
                'kode' => 'S_MATI',
                'nama' => 'Surat Keterangan Kematian',
                'deskripsi' => 'Untuk mengurus warisan, asuransi, atau penghapusan data penduduk.',
                'base_priority' => 10,
                'sla_hari' => 1,
                'fields' => [
                    ['field_key' => 'nama_almarhum', 'field_label' => 'Nama Almarhum/ah', 'field_type' => 'text', 'is_required' => true],
                    ['field_key' => 'tanggal_meninggal', 'field_label' => 'Tanggal Meninggal', 'field_type' => 'date', 'is_required' => true],
                    ['field_key' => 'tempat_meninggal', 'field_label' => 'Tempat Meninggal', 'field_type' => 'text', 'is_required' => true],
                    ['field_key' => 'penyebab_meninggal', 'field_label' => 'Penyebab (Sakit/Kecelakaan/dll)', 'field_type' => 'text', 'is_required' => true],
                ],
                'syarat' => [
                    ['nama' => 'KTP Almarhum', 'deskripsi' => 'KTP asli yang bersangkutan'],
                    ['nama' => 'Fotokopi KK', 'deskripsi' => 'Kartu Keluarga'],
                    ['nama' => 'Suket Kematian RS/Puskesmas', 'deskripsi' => 'Jika meninggal di RS'],
                    ['nama' => 'Fotokopi KTP Saksi', 'deskripsi' => '2 orang saksi'],
                ],
            ],
            [
                'kode' => 'S_PINDAH',
                'nama' => 'Surat Keterangan Pindah/Datang',
                'deskripsi' => 'Syarat wajib jika ingin pindah domisili secara resmi.',
                'base_priority' => 7,
                'sla_hari' => 3,
                'fields' => [
                    ['field_key' => 'alamat_tujuan', 'field_label' => 'Alamat Lengkap Tujuan Pindah', 'field_type' => 'textarea', 'is_required' => true],
                    ['field_key' => 'jumlah_keluarga_ikut', 'field_label' => 'Jumlah Anggota Keluarga yang Ikut', 'field_type' => 'number', 'is_required' => true],
                ],
                'syarat' => [
                    ['nama' => 'KK Asli', 'deskripsi' => 'Kartu Keluarga yang masih berlaku'],
                    ['nama' => 'Fotokopi KTP', 'deskripsi' => 'Pemohon'],
                    ['nama' => 'Surat Pengantar RT/RW', 'deskripsi' => 'Tanda tangan RT dan RW setempat'],
                ],
            ],

            // --- KATEGORI 3: PERNIKAHAN & KELUARGA ---
            [
                'kode' => 'P_NIKAH',
                'nama' => 'Surat Pengantar Nikah (Model N1-N4)',
                'deskripsi' => 'Dokumen wajib sebelum mendaftar ke KUA atau Pencatatan Sipil.',
                'base_priority' => 8,
                'sla_hari' => 3,
                'fields' => [
                    ['field_key' => 'nama_pasangan', 'field_label' => 'Nama Calon Pasangan', 'field_type' => 'text', 'is_required' => true],
                    ['field_key' => 'ttl_pasangan', 'field_label' => 'Tempat, Tgl Lahir Pasangan', 'field_type' => 'text', 'is_required' => true],
                    ['field_key' => 'alamat_pasangan', 'field_label' => 'Alamat Calon Pasangan', 'field_type' => 'textarea', 'is_required' => true],
                ],
                'syarat' => [
                    ['nama' => 'Fotokopi KTP & KK', 'deskripsi' => 'Pemohon dan Orang Tua'],
                    ['nama' => 'Akta Kelahiran / Ijazah', 'deskripsi' => 'Fotokopi'],
                    ['nama' => 'Pas Foto 2x3 & 3x4', 'deskripsi' => 'Latar merah/biru sesuai tahun lahir'],
                    ['nama' => 'Surat Pengantar RT/RW', 'deskripsi' => 'Tanda tangan RT dan RW setempat'],
                ],
            ],
            [
                'kode' => 'S_BELUM_NIKAH',
                'nama' => 'Surat Keterangan Belum Pernah Menikah',
                'deskripsi' => 'Sering diminta sebagai syarat kerja atau daftar anggota TNI/Polri.',
                'base_priority' => 6,
                'sla_hari' => 2,
                'fields' => [
                    ['field_key' => 'keperluan', 'field_label' => 'Keperluan (Melamar TNI/POLRI/Kerja)', 'field_type' => 'text', 'is_required' => true],
                ],
                'syarat' => [
                    ['nama' => 'Fotokopi KTP & KK', 'deskripsi' => 'Pemohon'],
                    ['nama' => 'Surat Pernyataan Bermaterai', 'deskripsi' => 'Menyatakan belum pernah menikah'],
                    ['nama' => 'Surat Pengantar RT/RW', 'deskripsi' => 'Tanda tangan RT dan RW setempat'],
                ],
            ],
            [
                'kode' => 'S_JANDA_DUDA',
                'nama' => 'Surat Keterangan Janda/Duda',
                'deskripsi' => 'Untuk urusan pensiun atau menikah lagi.',
                'base_priority' => 6,
                'sla_hari' => 2,
                'fields' => [
                    ['field_key' => 'alasan', 'field_label' => 'Alasan (Cerai Hidup/Cerai Mati)', 'field_type' => 'select', 'field_options' => json_encode(['Cerai Hidup', 'Cerai Mati']), 'is_required' => true],
                    ['field_key' => 'nama_mantan', 'field_label' => 'Nama Pasangan Sebelumnya', 'field_type' => 'text', 'is_required' => true],
                ],
                'syarat' => [
                    ['nama' => 'Fotokopi KTP & KK', 'deskripsi' => 'Pemohon'],
                    ['nama' => 'Akta Cerai / Suket Kematian', 'deskripsi' => 'Surat resmi dari instansi terkait'],
                    ['nama' => 'Surat Pengantar RT/RW', 'deskripsi' => 'Tanda tangan RT dan RW setempat'],
                ],
            ],

            // --- KATEGORI 4: PERTANAHAN & HARTA ---
            [
                'kode' => 'S_RIWAYAT_TANAH',
                'nama' => 'Surat Keterangan Riwayat Tanah',
                'deskripsi' => 'Untuk pengurusan sertifikat tanah (PTSL/Mandiri).',
                'base_priority' => 5,
                'sla_hari' => 5,
                'fields' => [
                    ['field_key' => 'lokasi_tanah', 'field_label' => 'Lokasi Tanah (Blok/Dusun)', 'field_type' => 'text', 'is_required' => true],
                    ['field_key' => 'luas_tanah', 'field_label' => 'Luas Tanah (m2)', 'field_type' => 'number', 'is_required' => true],
                    ['field_key' => 'batas_utara', 'field_label' => 'Batas Sebelah Utara', 'field_type' => 'text', 'is_required' => true],
                    ['field_key' => 'batas_selatan', 'field_label' => 'Batas Sebelah Selatan', 'field_type' => 'text', 'is_required' => true],
                    ['field_key' => 'batas_timur', 'field_label' => 'Batas Sebelah Timur', 'field_type' => 'text', 'is_required' => true],
                    ['field_key' => 'batas_barat', 'field_label' => 'Batas Sebelah Barat', 'field_type' => 'text', 'is_required' => true],
                ],
                'syarat' => [
                    ['nama' => 'KTP & KK Pemohon', 'deskripsi' => 'Fotokopi'],
                    ['nama' => 'Bukti Kepemilikan (Girik/C-Desa)', 'deskripsi' => 'Asli/Fotokopi'],
                    ['nama' => 'SPPT PBB Terakhir', 'deskripsi' => 'Bukti lunas pajak'],
                    ['nama' => 'Surat Pengantar RT/RW', 'deskripsi' => 'Tanda tangan RT dan RW setempat'],
                ],
            ],
            [
                'kode' => 'S_AHLI_WARIS',
                'nama' => 'Surat Keterangan Ahli Waris',
                'deskripsi' => 'Untuk pembagian harta atau pencairan dana di bank milik almarhum.',
                'base_priority' => 7,
                'sla_hari' => 3,
                'fields' => [
                    ['field_key' => 'nama_pewaris', 'field_label' => 'Nama Pewaris (Almarhum)', 'field_type' => 'text', 'is_required' => true],
                    ['field_key' => 'tanggal_meninggal', 'field_label' => 'Tanggal Meninggal Pewaris', 'field_type' => 'date', 'is_required' => true],
                    ['field_key' => 'jumlah_ahli_waris', 'field_label' => 'Jumlah Ahli Waris', 'field_type' => 'number', 'is_required' => true],
                ],
                'syarat' => [
                    ['nama' => 'Akta/Suket Kematian', 'deskripsi' => 'Fotokopi'],
                    ['nama' => 'Suket Ahli Waris (Draft)', 'deskripsi' => 'Sudah ditandatangani seluruh ahli waris di atas materai'],
                    ['nama' => 'Fotokopi KTP & KK Ahli Waris', 'deskripsi' => 'Seluruh ahli waris'],
                    ['nama' => 'Surat Pengantar RT/RW', 'deskripsi' => 'Tanda tangan RT dan RW setempat'],
                ],
            ],
        ];

        foreach ($letters as $l) {
            $fields = $l['fields'];
            $syarat = $l['syarat'];

            $letterData = [
                'kode' => $l['kode'],
                'nama' => $l['nama'],
                'deskripsi' => $l['deskripsi'] ?? null,
                'base_priority' => $l['base_priority'],
                'sla_hari' => $l['sla_hari']
            ];

            DB::table('jenis_surat')->updateOrInsert(['kode' => $l['kode']], $letterData);

            $record = DB::table('jenis_surat')->where('kode', $l['kode'])->first();
            $jenisSuratId = $record->id;

            // Seed Fields
            foreach ($fields as $idx => $f) {
                $f['jenis_surat_id'] = $jenisSuratId;
                $f['urutan'] = $idx;
                DB::table('jenis_surat_fields')->updateOrInsert(
                    ['jenis_surat_id' => $jenisSuratId, 'field_key' => $f['field_key']],
                    $f
                );
            }

            // Seed Syarat
            foreach ($syarat as $s) {
                DB::table('syarat_surat')->updateOrInsert(
                    ['jenis_surat_id' => $jenisSuratId, 'nama_syarat' => $s['nama']],
                    [
                        'jenis_surat_id' => $jenisSuratId,
                        'nama_syarat' => $s['nama'],
                        'deskripsi' => $s['deskripsi'] ?? null,
                        'is_required' => true,
                    ]
                );
            }
        }
    }
}
