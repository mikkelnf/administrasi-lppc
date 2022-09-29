<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semesterkuliah extends Model
{
    protected $table = 'semesterkuliah';

    public function semesterdetail()
    {
        return $this->belongsToMany(Semesterkuliah::class, 'detailtugas', 'id_semesterkuliah', 'nomor_tugas')
        ->withPivot('nama_tugas');
    }

    public function evaluasisemester()
    {
        return $this->belongsToMany(Semesterkuliah::class, 'detail_evaluasitugas', 'id_semesterkuliah', 'nomor_tugas')
        ->withPivot('nama_tugas');
    }

    public function evaluasisemesterd3()
    {
        return $this->belongsToMany(Semesterkuliah::class, 'detail_evaluasitugasd3', 'id_semesterkuliah', 'nomor_tugas')
        ->withPivot('nama_tugas');
    }

    public function rapord3()
    {
        return $this->belongsToMany(Semesterkuliah::class, 'rapord3', 'id_semesterkuliah', 'nomor_pertemuan')
        ->withPivot('nama_pertemuan');
    }
    public function angkatan()
    {
        return $this->belongsToMany(Angkatan::class, 'catatanjadwal', 'id_angkatan', 'id_semesterkuliah')
        ->withPivot(['catatan']);
    }
}
