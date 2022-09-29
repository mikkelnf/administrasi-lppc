<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PeriodePertemuan extends Pivot
{
    protected $table = 'periode_pertemuan';

    public function semesterperiode()
    {
        return $this->belongsTo(Semesterperiode::class, 'id_semesterperiode');
    }

    public function pertemuankursus()
    {
        return $this->belongsTo(Pertemuankursus::class, 'id_pertemuankursus');
    }
}
