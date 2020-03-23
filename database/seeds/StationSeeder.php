<?php

use App\Models\Station;
use Illuminate\Database\Seeder;

class StationSeeder extends Seeder
{
    /**
     * Run seeds for stations table.
     *
     * @return void
     */
    public function run()
    {
        $stations = ['Cairo', 'Giza', 'AlFayyoum', 'AlMinya', 'Asyut', 'Alexandria', 'Aswan', 'Beheira', 'Beni Suef', 'Dakahlia', ' Damietta', 'Gharbia', 'Ismailia', 'Kafr El Sheikh', 'Luxor', 'Matruh', 'Monufia', 'New Valley', 'North Sinai', 'Port Said', 'Qalyubia', 'Qena', 'Red Sea', 'Sharqia', 'Sohag', 'South Sinai', 'Suez'];

        foreach ($stations as $station) {
            Station::firstOrCreate([
                'name' => $station
            ]);
        }
    }
}
