<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        \App\Models\User::updateOrCreate(
            ['email' => 'admin@desa.id'],
            [
                'name' => 'Administrator Desa',
                'username' => 'admin',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'admin',
                'status' => 'active',
            ]
        );

        // Kepala Desa
        \App\Models\User::updateOrCreate(
            ['email' => 'kades@desa.id'],
            [
                'name' => 'Kepala Desa',
                'username' => 'kades',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'kepala_desa',
                'status' => 'active',
            ]
        );
    }
}
