<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\TripCollection;
use App\Models\BusSeat;
use App\Models\Trip;
use Illuminate\Http\Request;
use JWTAuth;

class TripController extends ApiController
{
    public function getAllAvailableTrips(Request $request)
    {
        $rules = [
            'start_station_id' => 'required|numeric|min:1|exists:stations,id',
            'end_station_id'   => 'required|numeric|min:1|exists:stations,id',
        ];
        $this->validateRequest($request, $rules);

        $trips        = $this->tripRepo->getAllTripsByStationId($request->start_station_id);
        $startStation = $this->stationRepo->getStationById($request->start_station_id);
        $endStation   = $this->stationRepo->getStationById($request->end_station_id);

        $availableTrips = $this->tripRepo->getAllAvailableTrips($trips, $startStation, $endStation);

        return response()->json(['status'=>1, 'data'=>TripCollection::collection($availableTrips)]);
    }

    public function bookSeat(Trip $trip, BusSeat $seat, Request $request)
    {
        $rules = [
            'start_station_id' => 'required|numeric|min:1|exists:stations,id',
            'end_station_id'   => 'required|numeric|min:1|exists:stations,id',
        ];
        $this->validateRequest($request, $rules);
        $this->validateStationIds($trip, $request->start_station_id, $request->end_station_id);

        $startStation = $this->stationRepo->getStationById($request->start_station_id);
        $endStation   = $this->stationRepo->getStationById($request->end_station_id);
        $user = JWTAuth::parseToken()->toUser();

        $reservation = $this->tripRepo->bookSeat($trip, $seat, $startStation, $endStation, $user);

        if(empty($reservation))
            $this->throwCustomError(['This seat isn\'t valid right now.']);

        return response()->json(['status'=>1, 'data'=>'The seat is reserved successfully.']);
    }

    private function validateStationIds($trip, $startStationId, $endStationId)
    {
        if( $trip->stations()->whereIn('station_id', [$startStationId, $endStationId])->count() != 2 )
            $this->throwCustomError(['Stations ids are not valid.']);
    }

}
