<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriHambatan;

class KategoriHambatanSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'nama' => 'Guiding Block Rusak Berat',
                'slug' => 'guiding-block-rusak-berat',
                'keterangan' => 'Jalur pemandu (tactile paving) rusak parah: pecah, hilang, atau tidak berkesinambungan lebih dari 2 meter',
                'bobot_keparahan' => 90,
                'warna_penanda' => '#C53030',
                'urutan_tampil' => 1,
            ],
            [
                'nama' => 'Trotoar Terhalang Permanen',
                'slug' => 'trotoar-terhalang-permanen',
                'keterangan' => 'Trotoar diblokir benda permanen: kios, tiang listrik, atau bangunan sehingga tidak dapat dilalui',
                'bobot_keparahan' => 85,
                'warna_penanda' => '#DD6B20',
                'urutan_tampil' => 2,
            ],
            [
                'nama' => 'Tidak Ada Ramp/Jalur Landai',
                'slug' => 'tidak-ada-ramp',
                'keterangan' => 'Titik penyeberangan atau naik-turun trotoar tidak dilengkapi ramp atau jalur landai',
                'bobot_keparahan' => 80,
                'warna_penanda' => '#D69E2E',
                'urutan_tampil' => 3,
            ],
            [
                'nama' => 'Guiding Block Rusak Ringan',
                'slug' => 'guiding-block-rusak-ringan',
                'keterangan' => 'Jalur pemandu rusak sebagian: retak atau terangkat namun masih terhubung',
                'bobot_keparahan' => 60,
                'warna_penanda' => '#ED8936',
                'urutan_tampil' => 4,
            ],
            [
                'nama' => 'Trotoar Terhalang Sementara',
                'slug' => 'trotoar-terhalang-sementara',
                'keterangan' => 'Trotoar diblokir benda tidak permanen: kendaraan parkir, gerobak, atau material bangunan',
                'bobot_keparahan' => 55,
                'warna_penanda' => '#ECC94B',
                'urutan_tampil' => 5,
            ],
            [
                'nama' => 'Permukaan Trotoar Rusak',
                'slug' => 'permukaan-trotoar-rusak',
                'keterangan' => 'Permukaan trotoar berlubang, retak besar, atau tidak rata sehingga berbahaya bagi pengguna kursi roda',
                'bobot_keparahan' => 65,
                'warna_penanda' => '#E53E3E',
                'urutan_tampil' => 6,
            ],
            [
                'nama' => 'Fasilitas Penyeberangan Tidak Layak',
                'slug' => 'penyeberangan-tidak-layak',
                'keterangan' => 'Zebra cross atau jembatan penyeberangan dalam kondisi rusak atau tidak dilengkapi fitur aksesibel',
                'bobot_keparahan' => 70,
                'warna_penanda' => '#9B2C2C',
                'urutan_tampil' => 7,
            ],
            [
                'nama' => 'Hambatan Lainnya',
                'slug' => 'hambatan-lainnya',
                'keterangan' => 'Hambatan aksesibilitas fisik yang tidak termasuk kategori di atas',
                'bobot_keparahan' => 40,
                'warna_penanda' => '#718096',
                'urutan_tampil' => 8,
            ],
        ];

        foreach ($categories as $category) {
            KategoriHambatan::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}