<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    public function trips()
    {
        return $this->belongsToMany(Trip::class, 'trip_station', 'station_id', 'trip_id')->withPivot('station_order')->withTimestamps();
    }
}
