<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TugasPeserta extends Model
{
    protected $table = 'tugas_peserta';
    
    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta');
    }
}
