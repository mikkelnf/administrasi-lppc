<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RaporPeserta extends Model
{
    protected $table = 'rapor_peserta';

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta');
    }
    public function asistenpenilai()
    {
        return $this->belongsTo(AsistenpenilaiRaporPeserta::class, 'id_rapor_peserta');
    }
    public function tanggalperiksa()
    {
        return $this->belongsTo(TanggalperiksaRaporPeserta::class, 'id_rapor_peserta');
    }
    public function catatan()
    {
        return $this->belongsTo(CatatanRaporPeserta::class, 'id_rapor_peserta');
    }
}
