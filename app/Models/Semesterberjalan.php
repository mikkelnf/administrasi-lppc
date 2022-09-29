<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semesterberjalan extends Model
{
    protected $table = 'semesterberjalan';

    public function semesterperiode()
    {
        return $this->belongsTo(Semesterperiode::class, 'id_semesterperiode');
    }
}
