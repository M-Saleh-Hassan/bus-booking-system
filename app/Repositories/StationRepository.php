<?php

namespace App\Repositories;

use App\Models\Station;

class StationRepository
{
    public function getStationById($stationId)
    {
        return Station::find($stationId);
    }
}
