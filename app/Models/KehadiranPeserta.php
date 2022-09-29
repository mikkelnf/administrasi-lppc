<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class KehadiranPeserta extends Pivot
{
    protected $table = 'kehadiran_peserta';
    
    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta');
    }
}
