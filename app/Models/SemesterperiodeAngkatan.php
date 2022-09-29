<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SemesterperiodeAngkatan extends Model
{
    protected $table = 'semesterperiode_angkatan';

    public function angkatan()
    {
        return $this->belongsTo(Angkatan::class, 'id_angkatan');
    }
}
