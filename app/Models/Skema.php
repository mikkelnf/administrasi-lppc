<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skema extends Model
{
    protected $table = 'skema';

    public function peserta()
    {
        return $this->hasMany(Peserta::class);
    }
}
