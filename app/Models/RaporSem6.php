<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RaporSem6 extends Model
{
    protected $table = 'rapor_sem6';

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta');
    }
}
