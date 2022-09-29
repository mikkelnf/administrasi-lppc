<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TanggalperiksaRaporPeserta extends Model
{
    protected $table = 'tanggalperiksa_rapor_peserta';

    public function raporpeserta()
    {
        return $this->belongsTo(RaporPeserta::class, 'id_rapor_peserta');
    }
}
