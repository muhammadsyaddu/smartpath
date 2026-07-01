<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FasilitasPublik;
use App\Models\Wilayah;

class FasilitasPublikSeeder extends Seeder
{
    public function run(): void
    {
        $beji = Wilayah::where('kode_bps', '3276010')->first();
        $pancoranMas = Wilayah::where('kode_bps', '3276020')->first();

        $fasilitas = [
            [
                'nama' => 'RSUD Kota Depok',
                'jenis' => 'rumah_sakit',
                'wilayah_id' => $beji?->id,
                'alamat' => 'Jl. Raya Muchtar No.99, Sawangan',
                'latitude' => -6.4328,
                'longitude' => 106.7642,
                'bobot_vital' => 100,
                'sumber_data' => 'osm'
            ],
            [
                'nama' => 'RS Hermina Depok',
                'jenis' => 'rumah_sakit',
                'wilayah_id' => $pancoranMas?->id,
                'alamat' => 'Jl. Raya Siliwangi No.50, Pancoran Mas',
                'latitude' => -6.4012,
                'longitude' => 106.8193,
                'bobot_vital' => 95,
                'sumber_data' => 'osm'
            ],
            [
                'nama' => 'Stasiun Depok Baru',
                'jenis' => 'stasiun',
                'wilayah_id' => $beji?->id,
                'alamat' => 'Jl. Stasiun, Depok',
                'latitude' => -6.3886,
                'longitude' => 106.8239,
                'bobot_vital' => 90,
                'sumber_data' => 'osm'
            ],
            [
                'nama' => 'Stasiun Depok Lama',
                'jenis' => 'stasiun',
                'wilayah_id' => $pancoranMas?->id,
                'alamat' => 'Jl. Pemuda, Depok',
                'latitude' => -6.3933,
                'longitude' => 106.8198,
                'bobot_vital' => 90,
                'sumber_data' => 'osm'
            ],
            [
                'nama' => 'Terminal Depok',
                'jenis' => 'terminal',
                'wilayah_id' => $pancoranMas?->id,
                'alamat' => 'Jl. Margonda Raya, Depok',
                'latitude' => -6.4021,
                'longitude' => 106.8167,
                'bobot_vital' => 85,
                'sumber_data' => 'osm'
            ],
            [
                'nama' => 'Balai Kota Depok',
                'jenis' => 'kantor_pemerintah',
                'wilayah_id' => $beji?->id,
                'alamat' => 'Jl. Margonda Raya No.54, Depok',
                'latitude' => -6.3994,
                'longitude' => 106.8140,
                'bobot_vital' => 80,
                'sumber_data' => 'osm'
            ],
            [
                'nama' => 'SMAN 1 Depok',
                'jenis' => 'sekolah',
                'wilayah_id' => $beji?->id,
                'alamat' => 'Jl. Nusantara Raya No.317, Depok',
                'latitude' => -6.3900,
                'longitude' => 106.8280,
                'bobot_vital' => 70,
                'sumber_data' => 'osm'
            ],
            [
                'nama' => 'Universitas Indonesia',
                'jenis' => 'perguruan_tinggi',
                'wilayah_id' => $beji?->id,
                'alamat' => 'Kampus UI Depok',
                'latitude' => -6.3625,
                'longitude' => 106.8270,
                'bobot_vital' => 75,
                'sumber_data' => 'osm'
            ],
            [
                'nama' => 'Halte Margonda Raya',
                'jenis' => 'halte',
                'wilayah_id' => $pancoranMas?->id,
                'alamat' => 'Jl. Margonda Raya, Depok',
                'latitude' => -6.4035,
                'longitude' => 106.8155,
                'bobot_vital' => 65,
                'sumber_data' => 'osm'
            ],
            [
                'nama' => 'Puskesmas Beji',
                'jenis' => 'puskesmas',
                'wilayah_id' => $beji?->id,
                'alamat' => 'Jl. Nusantara Raya, Beji',
                'latitude' => -6.3870,
                'longitude' => 106.8230,
                'bobot_vital' => 75,
                'sumber_data' => 'osm'
            ],
        ];

        foreach ($fasilitas as $f) {
            FasilitasPublik::updateOrCreate(
                [
                    'nama' => $f['nama'],
                    'latitude' => $f['latitude'],
                    'longitude' => $f['longitude'],
                ],
                $f
            );
        }
    }
}