<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KonfigurasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('konfigurasi_sistem')->insert([
        ['kunci' => 'radius_deteksi', 'nilai' => '50', 'deskripsi' => 'Radius deteksi dalam meter'],
        ['kunci' => 'batas_kecepatan', 'nilai' => '60', 'deskripsi' => 'Batas kecepatan maksimal (km/jam)'],
        ['kunci' => 'mode_operasional', 'nilai' => 'normal', 'deskripsi' => 'Mode kerja sistem (normal/hemat/high)']
    ]);

    }
}
