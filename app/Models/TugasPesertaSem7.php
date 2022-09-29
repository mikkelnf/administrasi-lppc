<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TugasPesertaSem7 extends Model
{
    protected $table = 'tugas_peserta_sem7';
    
    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta');
    }
}
