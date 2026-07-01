<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KonfigurasiSistem;

class KonfigurasiSistemSeeder extends Seeder
{
    public function run(): void
    {
        $configs = [
            ['kunci' => 'radius_deduplikasi_meter', 'nilai' => '50', 'tipe_nilai' => 'angka', 'keterangan' => 'Jarak maksimum antar laporan yang dianggap lokasi sama'],
            ['kunci' => 'skor_bobot_keparahan', 'nilai' => '0.40', 'tipe_nilai' => 'desimal', 'keterangan' => 'Bobot komponen keparahan pada rumus skor prioritas'],
            ['kunci' => 'skor_bobot_pelapor', 'nilai' => '0.35', 'tipe_nilai' => 'desimal', 'keterangan' => 'Bobot komponen jumlah pelapor pada rumus skor prioritas'],
            ['kunci' => 'skor_bobot_fasilitas', 'nilai' => '0.25', 'tipe_nilai' => 'desimal', 'keterangan' => 'Bobot komponen kedekatan fasilitas vital pada rumus skor prioritas'],
            ['kunci' => 'batas_skor_prioritas_tinggi', 'nilai' => '70', 'tipe_nilai' => 'angka', 'keterangan' => 'Skor minimum untuk dikategorikan Prioritas Tinggi'],
            ['kunci' => 'batas_skor_prioritas_sedang', 'nilai' => '40', 'tipe_nilai' => 'angka', 'keterangan' => 'Skor minimum untuk dikategorikan Prioritas Sedang'],
            ['kunci' => 'radius_fasilitas_vital_meter', 'nilai' => '500', 'tipe_nilai' => 'angka', 'keterangan' => 'Radius pencarian fasilitas publik vital dari titik laporan'],
            ['kunci' => 'max_foto_per_laporan', 'nilai' => '5', 'tipe_nilai' => 'angka', 'keterangan' => 'Jumlah maksimum foto yang dapat diunggah per laporan'],
            ['kunci' => 'masa_pending_jam', 'nilai' => '72', 'tipe_nilai' => 'angka', 'keterangan' => 'Laporan pending lebih dari N jam otomatis diarsipkan'],
            ['kunci' => 'nama_aplikasi', 'nilai' => 'SmartPath', 'tipe_nilai' => 'teks', 'keterangan' => 'Nama resmi platform yang tampil di UI'],
            ['kunci' => 'versi_aplikasi', 'nilai' => '1.0.0', 'tipe_nilai' => 'teks', 'keterangan' => 'Versi rilis saat ini'],
            ['kunci' => 'email_notifikasi_admin', 'nilai' => 'admin@smartpath.id', 'tipe_nilai' => 'teks', 'keterangan' => 'Email penerima notifikasi sistem'],
        ];

        foreach ($configs as $config) {
            KonfigurasiSistem::updateOrCreate(
                ['kunci' => $config['kunci']],
                $config
            );
        }
    }
}