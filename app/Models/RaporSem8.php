<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RaporSem8 extends Model
{
    protected $table = 'rapor_sem8';

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta');
    }
}
