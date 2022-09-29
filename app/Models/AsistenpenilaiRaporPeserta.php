<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsistenpenilaiRaporPeserta extends Model
{
    protected $table = 'asistenpenilai_rapor_peserta';

    public function raporpeserta()
    {
        return $this->belongsTo(RaporPeserta::class, 'id_rapor_peserta');
    }
    public function pert1()
    {
        return $this->belongsTo(User::class, 'pertemuan_1');
    }
    public function pert2()
    {
        return $this->belongsTo(User::class, 'pertemuan_2');
    }
    public function pert3()
    {
        return $this->belongsTo(User::class, 'pertemuan_3');
    }
    public function pert4()
    {
        return $this->belongsTo(User::class, 'pertemuan_4');
    }
    public function pert5()
    {
        return $this->belongsTo(User::class, 'pertemuan_5');
    }
    public function pert6()
    {
        return $this->belongsTo(User::class, 'pertemuan_6');
    }
    public function pert7()
    {
        return $this->belongsTo(User::class, 'pertemuan_7');
    }
    public function pert8()
    {
        return $this->belongsTo(User::class, 'pertemuan_8');
    }
    public function pert9()
    {
        return $this->belongsTo(User::class, 'pertemuan_9');
    }
    public function pert10()
    {
        return $this->belongsTo(User::class, 'pertemuan_10');
    }
}
