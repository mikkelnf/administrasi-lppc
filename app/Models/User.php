<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'user';

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $fillable = [
        'nama_user',
        'username',
        'password',
    ];

    public function getAuthPassword()
    {
     return $this->password;
    }

    public function roles()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }

    public function peserta()
    {
        return $this->hasMany(Peserta::class, 'id_asisten');
    }

    public function instrukturs()
    {
        return $this->hasMany(Jadwalasisten::class, 'instruktur');
    }

    public function hosts()
    {
        return $this->hasMany(Jadwalasisten::class, 'host');
    }

    public function jadwalasisten()
    {
        return $this->belongsToMany(Jadwalasisten::class, 'asisten_jadwalasisten', 'id_jadwalasisten', 'id_user')
        ->using(AsistenJadwalasisten::class);
    }

    public function asistenjadwalasisten()
    {
        return $this->hasMany(asistenjadwalasisten::class, 'id_user');
    }

    
}
