<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwalasisten extends Model
{
    protected $table = 'jadwalasisten';

    public function semesterperiode()
    {
        return $this->belongsTo(semesterperiode::class, 'id_semesterperiode');
    }

    public function jadwalkursus()
    {
        return $this->belongsTo(Jadwalkursus::class, 'id_jadwalkursus');
    }

    public function pertemuankursus()
    {
        return $this->belongsTo(Pertemuankursus::class, 'id_pertemuankursus');
    }

    public function instrukturs()
    {
        return $this->belongsTo(User::class, 'instruktur');
    }

    public function hosts()
    {
        return $this->belongsTo(User::class, 'host');
    }

    public function asisten()
    {
        return $this->belongsToMany(User::class, 'asisten_jadwalasisten', 'id_jadwalasisten', 'id_user')
        ->using(AsistenJadwalasisten::class);
    }
}
