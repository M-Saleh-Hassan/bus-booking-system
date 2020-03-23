<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    public function seats()
    {
        return $this->hasMany(BusSeat::class, 'bus_id');
    }
}
