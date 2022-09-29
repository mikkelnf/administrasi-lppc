<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Angkatan extends Model
{
    protected $table = 'angkatan';

    public function peserta()
    {
        return $this->hasMany(Peserta::class);
    }
    public function jadwal_kursus()
    {
        return $this->hasMany(Jadwalkursus::class);
    }
    public function semesterperiode()
    {
        return $this->belongsTo(SemesterperiodeAngkatan::class, 'id_angkatan');
    }
    public function semesterkuliah()
    {
        return $this->belongsToMany(Semesterkuliah::class, 'catatanjadwal', 'id_angkatan', 'id_semesterkuliah')
        ->withPivot(['catatan']);
    }
}
