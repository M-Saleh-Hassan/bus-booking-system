<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripStationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_station', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('station_id')->unsigned();
            $table->bigInteger('trip_id')->unsigned();
            $table->bigInteger('station_order')->default(0);
            $table->timestamps();

            $table->foreign('station_id')->references('id')->on('stations')->onDelete('cascade');
            $table->foreign('trip_id')->references('id')->on('trips')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trip_station');
    }
}
