<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\TripCollection;
use Illuminate\Http\Request;

class TripController extends ApiController
{
    public function getAllAvailableTrips(Request $request)
    {
        $rules = [
            'start_station_id' => 'required|numeric|min:1|exists:stations,id',
            'end_station_id' => 'required|numeric|min:1|exists:stations,id',
        ];
        $this->validateRequest($request, $rules);

        $trips = $this->tripRepo->getAllTripsByStationId($request->start_station_id);
        $startStation = $this->stationRepo->getStationById($request->start_station_id);
        $endStation   = $this->stationRepo->getStationById($request->end_station_id);

        $availableTrips = $this->tripRepo->getAllAvailableTrips($trips, $startStation, $endStation);

        return response()->json(['status'=>1,'data'=>TripCollection::collection($availableTrips)]);
    }
}
