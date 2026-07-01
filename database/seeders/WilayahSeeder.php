<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Wilayah;

class WilayahSeeder extends Seeder
{
    public function run(): void
    {
        // Kota Depok
        $depok = Wilayah::updateOrCreate(
            ['kode_bps' => '3276'],
            [
                'nama' => 'Kota Depok',
                'level' => 'kota_kabupaten',
                'kode_bps' => '3276',
                'latitude' => -6.4025,
                'longitude' => 106.7942,
                'aktif' => true,
            ]
        );

        // Kecamatan
        $kecamatan = [
            ['nama' => 'Beji', 'kode_bps' => '3276010'],
            ['nama' => 'Pancoran Mas', 'kode_bps' => '3276020'],
            ['nama' => 'Cipayung', 'kode_bps' => '3276030'],
            ['nama' => 'Sukmajaya', 'kode_bps' => '3276040'],
            ['nama' => 'Cimanggis', 'kode_bps' => '3276050'],
            ['nama' => 'Tapos', 'kode_bps' => '3276060'],
            ['nama' => 'Sawangan', 'kode_bps' => '3276070'],
            ['nama' => 'Bojongsari', 'kode_bps' => '3276080'],
            ['nama' => 'Limo', 'kode_bps' => '3276090'],
            ['nama' => 'Cinere', 'kode_bps' => '3276100'],
            ['nama' => 'Cilodong', 'kode_bps' => '3276110'],
        ];

        foreach ($kecamatan as $k) {
            Wilayah::updateOrCreate(
                ['kode_bps' => $k['kode_bps']],
                [
                    'induk_id' => $depok->id,
                    'nama' => $k['nama'],
                    'level' => 'kecamatan',
                    'kode_bps' => $k['kode_bps'],
                    'aktif' => true,
                ]
            );
        }
    }
}