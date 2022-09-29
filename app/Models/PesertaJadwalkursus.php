<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PesertaJadwalkursus extends Pivot
{
    protected $table = 'peserta_jadwalkursus';

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta');
    }
}
