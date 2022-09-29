<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detailtugas extends Model
{
    protected $table = 'detailtugas';
    protected $fillable = array('nomor_tugas');

    public function semesterkuliah()
    {
        return $this->belongsTo(Semesterkuliah::class);
    }
}
