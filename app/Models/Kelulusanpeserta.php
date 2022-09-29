<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelulusanpeserta extends Model
{
    protected $table = 'kelulusanpeserta';
    
    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta');
    }
}
