<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusSeat extends Model
{
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'bus_seat_id');
    }
}
