<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanPrioritas extends Model
{
    protected $table = 'pengaturan_prioritas';
    protected $primaryKey = 'prioritas_id';
    protected $fillable = ['nama_prioritas', 'bobot'];
}
