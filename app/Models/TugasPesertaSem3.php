<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TugasPesertaSem3 extends Model
{
    protected $table = 'tugas_peserta_sem3';
    
    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta');
    }
}
