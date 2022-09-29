<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class AsistenJadwalasisten extends Pivot
{
    protected $table = 'asisten_jadwalasisten';

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
