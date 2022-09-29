<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailEvaluasitugas extends Model
{
    protected $table = 'detail_evaluasitugas';
    protected $fillable = array('nomor_tugas');

    public function semesterkuliah()
    {
        return $this->belongsTo(Semesterkuliah::class);
    }
}
