<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwalkursus extends Model
{
    protected $table = 'jadwalkursus';

    public function angkatan()
    {
        return $this->belongsTo(Angkatan::class, 'id_angkatan');
    }

    public function peserta()
    {
        return $this->belongsToMany(Peserta::class, 'peserta_jadwalkursus', 'id_peserta', 'id_jadwalkursus')
        ->using(PesertaJadwalkursus::class);
    }

    public function jadwal_asisten()
    {
        return $this->hasOne(Jadwalasisten::class);
    }
}
