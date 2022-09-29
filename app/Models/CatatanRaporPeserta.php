<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanRaporPeserta extends Model
{
    protected $table = 'catatan_rapor_peserta';

    public function raporpeserta()
    {
        return $this->belongsTo(RaporPeserta::class, 'id_rapor_peserta');
    }
}
