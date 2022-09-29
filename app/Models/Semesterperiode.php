<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semesterperiode extends Model
{
    protected $table = 'semesterperiode';

    protected $fillable = [
        'nama_semesterperiode',
        'status_semesterperiode',
    ];

    public function jadwalasisten()
    {
        return $this->hasMany(Jadwalasisten::class);
    }

    public function pertemuankursus()
    {
        return $this->belongsToMany(Pertemuankursus::class, 'periode_pertemuan', 'id_semesterperiode', 'id_pertemuankursus')
        ->withPivot(['periode'])
        ->using(PeriodePertemuan::class);
    }

    public function semesterberjalan()
    {
        return $this->hasOne(Semesterberjalan::class);
    }
}
