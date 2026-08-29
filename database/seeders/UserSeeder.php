<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        /*
         * Helper untuk membuat atau memperbarui user.
         *
         * withTrashed() diperlukan karena User menggunakan
         * SoftDeletes.
         */
        $upsertUser = function (
            string $email,
            array $data
        ): User {
            $user = User::withTrashed()
                ->updateOrCreate(
                    [
                        'email' => $email,
                    ],
                    $data
                );

            /*
             * Jika user sebelumnya soft deleted,
             * aktifkan kembali saat proses seeding.
             */
            if ($user->trashed()) {
                $user->restore();
            }

            return $user;
        };

        /*
         * ==========================================
         * ADMINISTRATOR
         * ==========================================
         */
        $upsertUser(
            'admin@smartpath.id',
            [
                'nama_lengkap' =>
                    'Administrator SmartPath',

                'kata_sandi' =>
                    Hash::make('admin123'),

                'peran' =>
                    'administrator',

                'email_terverifikasi' =>
                    true,

                'aktif' =>
                    true,
            ]
        );

        /*
         * ==========================================
         * DINAS
         * ==========================================
         */
        $upsertUser(
            'dinas@smartpath.id',
            [
                'nama_lengkap' =>
                    'Petugas Dinas',

                'kata_sandi' =>
                    Hash::make('petugas123'),

                'peran' =>
                    'dinas',

                'email_terverifikasi' =>
                    true,

                'aktif' =>
                    true,
            ]
        );

        /*
         * ==========================================
         * WARGA
         * ==========================================
         */
        $warga = [
            [
                'nama_lengkap' =>
                    'Budi Santoso',

                'email' =>
                    'budi@email.com',
            ],

            [
                'nama_lengkap' =>
                    'Siti Rahayu',

                'email' =>
                    'siti@email.com',
            ],

            [
                'nama_lengkap' =>
                    'Andi Wijaya',

                'email' =>
                    'andi@email.com',
            ],

            [
                'nama_lengkap' =>
                    'Dewi Lestari',

                'email' =>
                    'dewi@email.com',
            ],

            [
                'nama_lengkap' =>
                    'Rudi Hartono',

                'email' =>
                    'rudi@email.com',
            ],
        ];

        foreach ($warga as $data) {
            $upsertUser(
                $data['email'],
                [
                    'nama_lengkap' =>
                        $data['nama_lengkap'],

                    'kata_sandi' =>
                        Hash::make('warga123'),

                    'peran' =>
                        'warga',

                    'email_terverifikasi' =>
                        true,

                    'aktif' =>
                        true,
                ]
            );
        }
    }
}