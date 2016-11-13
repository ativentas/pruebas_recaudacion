<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Maquina extends Model
{
    public function scopeActiva($query)
    {
        return $query->where('activa', 1);
    }
}
