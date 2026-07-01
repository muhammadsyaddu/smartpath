<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengaturanPrioritasSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@smartpath.id')->first();

        if (!$admin) {
            return;
        }

        DB::table('pengaturan_prioritas')->insert([
            'dibuat_oleh_id' => $admin->id,
            'label' => 'Bobot Awal MVP SmartPath 2026',
            'bobot_keparahan' => 0.40,
            'bobot_pelapor' => 0.35,
            'bobot_fasilitas' => 0.25,
            'radius_deduplikasi_m' => 50,
            'radius_fasilitas_m' => 500,
            'adalah_aktif' => true,
            'catatan' => 'Konfigurasi bawaan sesuai proposal teknis purwarupa.',
            'berlaku_sejak' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
