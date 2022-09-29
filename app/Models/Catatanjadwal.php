<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catatanjadwal extends Model
{
    protected $table = 'catatanjadwal';

    public function angkatan()
    {
        return $this->belongsTo(Angkatan::class, 'id_angkatan');
    }

    public function semesterkuliah()
    {
        return $this->belongsTo(Semesterkuliah::class, 'id_semesterkuliah');
    }
}
