<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RaporSem1 extends Model
{
    protected $table = 'rapor_sem1';

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta');
    }
}
