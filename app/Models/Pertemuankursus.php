<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pertemuankursus extends Model
{
    protected $table = 'pertemuankursus';

    public function jadwalasisten()
    {
        return $this->hasMany(Jadwalasisten::class);
    }

    public function semesterperiode()
    {
        return $this->belongsToMany(Semesterperiode::class, 'periode_pertemuan', 'id_semesterperiode', 'id_pertemuankursus')
        ->withPivot(['periode'])
        ->using(PeriodePertemuan::class);
    }
}
