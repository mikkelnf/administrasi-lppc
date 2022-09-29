<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TugasPesertaSem1 extends Model
{
    protected $table = 'tugas_peserta_sem1';
    
    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta');
    }
}
