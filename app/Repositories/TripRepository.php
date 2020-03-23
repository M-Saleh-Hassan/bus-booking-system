<?php

namespace App\Repositories;

use App\Models\Reservation;
use App\Models\Station;
use App\Models\Trip;
use App\Models\TripStop;
use Carbon\Carbon;

class TripRepository
{
    public function getAllTripsByStationId($stationId, $withRelations=true)
    {
        if($withRelations)
            return Station::find($stationId)->trips()->with(['stations', 'bus.seats.reservations'])->get();
        else
            return Station::find($stationId)->trips;
    }

    public function getAllAvailableTrips($trips, $startStation, $endStation)
    {
        $availableTrips = [];
        foreach ($trips as $trip) {
            if (!$this->tripHasEndStation($trip, $startStation, $endStation))
                continue;
            if ($reservedSeatsIds = $this->tripBusHasAvaliablePlace($trip, $startStation, $endStation)) {
                $trip->avaliable_seats = $this->getAvaliableSeatsByReservedSeatsIds($trip, $reservedSeatsIds);
                $availableTrips[] = $trip;
                continue;
            }
        }
        return $availableTrips;
    }

    public function bookSeat($trip, $seat, $startStation, $endStation, $user)
    {
        if(!$this->tripHasEndStation($trip, $startStation, $endStation))
            return [];

        $reservedSeatsIds = $this->tripBusHasAvaliablePlace($trip, $startStation, $endStation);
        if(empty($reservedSeatsIds) || in_array($seat->id, $reservedSeatsIds->toArray()))
            return [];

        $reservation = Reservation::Create([
            'user_id'         => $user->id,
            'bus_seat_id'     => $seat->id,
            'from_station_id' => $startStation->id,
            'to_station_id'   => $endStation->id
        ]);

        return $reservation;

    }

    private function tripHasEndStation($trip, $startStation, $endStation)
    {
        $startOrder = $trip->stations()->find($startStation->id)->pivot->station_order;
        if ($trip->stations->contains($endStation)) {
            $endOrder = $trip->stations()->find($endStation->id)->pivot->station_order;
            if ($startOrder > $endOrder)
                return false;
            else
                return true;
        }
        return false;
    }

    private function tripBusHasAvaliablePlace($trip, $startStation, $endStation)
    {
        $endStopOrder = $endStation->trips()->where('trip_id', $trip->id)->first()->pivot->station_order;

        $reservations = Trip::join('buses', 'trips.id', '=', 'buses.trip_id')
            ->join('bus_seats', 'buses.id', '=', 'bus_seats.bus_id')
            ->join('reservations', 'bus_seats.id', '=', 'reservations.bus_seat_id')
            ->select('trips.id as trip_id', 'reservations.from_station_id as start_id', 'reservations.to_station_id as end_id', 'bus_seats.id as bus_occupied_id')
            ->where('trips.id', $trip->id)
            ->whereDate('trips.trip_day', '>', Carbon::today()->toDateString())
            ->get();

        if(count($reservations) < 12)
            return $reservations->pluck('bus_occupied_id');

        $reservedSeatsIds = [];
        foreach ($reservations as $reservation) {
            $fromStationOrder = TripStop::select('station_order')->where('station_id', $reservation->start_id)->where('trip_id', $reservation->trip_id)->first()->station_order;
            if($fromStationOrder < $endStopOrder){
                $reservedSeatsIds[] = $reservation->bus_occupied_id;
            }
        }
        return count($reservedSeatsIds) < 12 ? $reservedSeatsIds : [];
    }

    private function getAvaliableSeatsByReservedSeatsIds($trip, $reservedSeatsIds)
    {
        return $trip->bus->seats()->whereNotIn('id', $reservedSeatsIds)->get();
    }
}
