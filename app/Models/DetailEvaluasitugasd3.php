<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailEvaluasitugasd3 extends Model
{
    protected $table = 'detail_evaluasitugasd3';
    protected $fillable = array('nomor_tugas');

    public function semesterkuliah()
    {
        return $this->belongsTo(Semesterkuliah::class);
    }
}
