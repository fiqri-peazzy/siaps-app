<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WilayahSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('master_wilayah')->delete();

        // Desa
        $desaId = DB::table('master_wilayah')->insertGetId([
            'parent_id' => null,
            'tipe'      => 'desa',
            'kode'      => 'DS001',
            'nama'      => 'Desa Siapsatu',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Dusun A
        $dusunAId = DB::table('master_wilayah')->insertGetId([
            'parent_id' => $desaId,
            'tipe'      => 'dusun',
            'kode'      => 'DS001-A',
            'nama'      => 'Dusun Mekar',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Dusun B
        $dusunBId = DB::table('master_wilayah')->insertGetId([
            'parent_id' => $desaId,
            'tipe'      => 'dusun',
            'kode'      => 'DS001-B',
            'nama'      => 'Dusun Sejahtera',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // RW di Dusun A
        $rw1aId = DB::table('master_wilayah')->insertGetId([
            'parent_id' => $dusunAId,
            'tipe'      => 'rw',
            'kode'      => 'RW001',
            'nama'      => '001',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $rw2aId = DB::table('master_wilayah')->insertGetId([
            'parent_id' => $dusunAId,
            'tipe'      => 'rw',
            'kode'      => 'RW002',
            'nama'      => '002',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // RW di Dusun B
        $rw1bId = DB::table('master_wilayah')->insertGetId([
            'parent_id' => $dusunBId,
            'tipe'      => 'rw',
            'kode'      => 'RW003',
            'nama'      => '003',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $rw2bId = DB::table('master_wilayah')->insertGetId([
            'parent_id' => $dusunBId,
            'tipe'      => 'rw',
            'kode'      => 'RW004',
            'nama'      => '004',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // RT di bawah setiap RW
        $rts = [
            ['parent_id' => $rw1aId, 'kode' => 'RT001', 'nama' => '001'],
            ['parent_id' => $rw1aId, 'kode' => 'RT002', 'nama' => '002'],
            ['parent_id' => $rw2aId, 'kode' => 'RT003', 'nama' => '003'],
            ['parent_id' => $rw2aId, 'kode' => 'RT004', 'nama' => '004'],
            ['parent_id' => $rw1bId, 'kode' => 'RT005', 'nama' => '005'],
            ['parent_id' => $rw1bId, 'kode' => 'RT006', 'nama' => '006'],
            ['parent_id' => $rw2bId, 'kode' => 'RT007', 'nama' => '007'],
            ['parent_id' => $rw2bId, 'kode' => 'RT008', 'nama' => '008'],
        ];

        foreach ($rts as $rt) {
            DB::table('master_wilayah')->insert([
                'parent_id' => $rt['parent_id'],
                'tipe'      => 'rt',
                'kode'      => $rt['kode'],
                'nama'      => $rt['nama'],
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
