<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrioritasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pengaturan_prioritas')->truncate(); // Menghapus data lama sebelum melakukan seeding
        DB::table('pengaturan_prioritas')->insert([
        [
            'nama_prioritas' => 'Tinggi',
            'bobot' => 3,
            'deskripsi' => 'Hambatan berat (misal:jalan putus, demo besar). Harus dialihkan.'
        ],
        [
            'nama_prioritas' => 'sedang',
            'bobot' => 2,
            'deskripsi' => 'Hambatan sedang (misal: perbaikan jalan, macet padat). Disarankan jalur lain.'
        ],

        [
            'nama_prioritas' => 'rendah',
            'bobot' => 1,
            'deskripsi' => 'Hambatan ringan (misal: genangan air kecil, pasar tumpah). Jalur masih layak dilewati.'
        ]
        ]);
    }
}
