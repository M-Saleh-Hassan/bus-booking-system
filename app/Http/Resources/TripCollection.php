<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TripCollection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'              => $this->id,
            'trip_name'       => $this->name,
            'trip_day'        => $this->trip_day,
            'bus_id'          => $this->bus->id,
            'avaliable_seats' => SeatCollection::collection($this->avaliable_seats)
        ];
    }
}
