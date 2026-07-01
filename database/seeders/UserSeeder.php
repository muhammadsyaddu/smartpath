<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@smartpath.id'],
            [
                'nama_lengkap' => 'Administrator SmartPath',
                'email' => 'admin@smartpath.id',
                'kata_sandi' => Hash::make('admin123'),
                'peran' => 'administrator',
                'email_terverifikasi' => true,
                'aktif' => true,
            ]
        );

        // Sample Dinas user
        User::updateOrCreate(
            ['email' => 'dinas@smartpath.id'],
            [
                'nama_lengkap' => 'Petugas Dinas',
                'email' => 'dinas@smartpath.id',
                'kata_sandi' => Hash::make('petugas123'),
                'peran' => 'dinas',
                'email_terverifikasi' => true,
                'aktif' => true,
            ]
        );

        // Sample Warga users
        $warga = [
            ['nama' => 'Budi Santoso', 'email' => 'budi@email.com'],
            ['nama' => 'Siti Rahayu', 'email' => 'siti@email.com'],
            ['nama' => 'Andi Wijaya', 'email' => 'andi@email.com'],
            ['nama' => 'Dewi Lestari', 'email' => 'dewi@email.com'],
            ['nama' => 'Rudi Hartono', 'email' => 'rudi@email.com'],
        ];

        foreach ($warga as $w) {
            User::updateOrCreate(
                ['email' => $w['email']],
                [
                    'nama_lengkap' => $w['nama'],
                    'email' => $w['email'],
                    'kata_sandi' => Hash::make('warga123'),
                    'peran' => 'warga',
                    'email_terverifikasi' => true,
                    'aktif' => true,
                ]
            );
        }
    }
}