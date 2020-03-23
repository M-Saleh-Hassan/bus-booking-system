<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    public function stations()
    {
        return $this->belongsToMany(Station::class, 'trip_station', 'trip_id', 'station_id')->withPivot('station_order')->orderBy('station_order', 'asc')->withTimestamps();
    }

    public function bus()
    {
        return $this->hasOne(Bus::class, 'trip_id');
    }

    public function seats()
    {
        return $this->hasManyThrough(BusSeat::class, Bus::class);
    }
}
