<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkorService extends Model
{
    public function hitungSkorPrioritas($keparahan, $jumlahpelapor, $fasilitasVital)
    {
        $bobotK = KonfigurasiSistem::getValue('skor_bobot_keparahan', 0.4);
        $bobotP = KonfigurasiSistem::getValue('skor_bobot_pelapor', 0.35);
        $bobotF = KonfigurasiSistem::getValue('skor_bobot_fasilitas', 0.25);

        $skor = ($keparahan * $bobotK) + ($jumlahPelapor * $bobotP) + ($fasilitasVital * $bobotF);
    return $skor;
    }
    
}
