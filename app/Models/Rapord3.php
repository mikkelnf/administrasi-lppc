<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rapord3 extends Model
{
    protected $table = 'rapord3';

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta');
    }

    public function semesterkuliah()
    {
        return $this->belongsTo(Semesterkuliah::class);
    }
}
