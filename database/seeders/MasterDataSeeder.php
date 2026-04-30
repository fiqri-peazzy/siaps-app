<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Agama
        $agama = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Khonghucu'];
        foreach ($agama as $item) {
            DB::table('master_agama')->insert(['nama' => $item]);
        }

        // Pekerjaan
        $pekerjaan = [
            ['nama' => 'PNS', 'kode' => 'PNS'],
            ['nama' => 'TNI/POLRI', 'kode' => 'TNI_POLRI'],
            ['nama' => 'Karyawan Swasta', 'kode' => 'SWASTA'],
            ['nama' => 'Wiraswasta', 'kode' => 'WIRASWASTA'],
            ['nama' => 'Petani/Pekebun', 'kode' => 'PETANI'],
            ['nama' => 'Nelayan', 'kode' => 'NELAYAN'],
            ['nama' => 'Buruh Harian Lepas', 'kode' => 'BURUH'],
            ['nama' => 'Ibu Rumah Tangga', 'kode' => 'IRT'],
            ['nama' => 'Pelajar/Mahasiswa', 'kode' => 'PELAJAR'],
            ['nama' => 'Tidak/Belum Bekerja', 'kode' => 'TIDAK_BEKERJA'],
        ];
        DB::table('master_pekerjaan')->insert($pekerjaan);

        // Priority Bobot
        $bobot = [
            ['kategori' => 'status_sosial', 'kode' => 'LANSIA', 'label' => 'Usia > 60 Tahun', 'bobot' => 2.00],
            ['kategori' => 'status_sosial', 'kode' => 'DISABILITAS', 'label' => 'Penyandang Disabilitas', 'bobot' => 3.00],
            ['kategori' => 'status_sosial', 'kode' => 'HAMIL', 'label' => 'Ibu Hamil', 'bobot' => 2.50],
            ['kategori' => 'status_sosial', 'kode' => 'MISKIN', 'label' => 'Keluarga Tidak Mampu (DTKS)', 'bobot' => 2.00],
            ['kategori' => 'aging', 'kode' => 'PER_HARI', 'label' => 'Tambahan per hari menunggu', 'bobot' => 0.10],
            ['kategori' => 'aging', 'kode' => 'MAX_AGING', 'label' => 'Maksimum bobot aging', 'bobot' => 5.00],
        ];

        foreach ($bobot as $b) {
            DB::table('priority_bobot')->updateOrInsert(['kode' => $b['kode']], $b);
        }


        // Master Jabatan
        $jabatan = [
            ['nama_jabatan' => 'Kepala Desa', 'singkatan' => 'Kades', 'is_penandatangan' => true, 'urutan' => 1],
            ['nama_jabatan' => 'Sekretaris Desa', 'singkatan' => 'Sekdes', 'is_penandatangan' => true, 'urutan' => 2],
            ['nama_jabatan' => 'Kepala Urusan Pemerintahan', 'singkatan' => 'Kaur Pem', 'is_penandatangan' => false, 'urutan' => 3],
        ];
        DB::table('master_jabatan')->insert($jabatan);
    }
}
