<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTruckVehicleMaintenancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('truck_vehicle_maintenances', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('maintenance_type_id');
            $table->bigInteger('truck_vehicle_id');
            $table->float('amount', 20, 2);
            $table->date('date');
            $table->string('assigned');
            $table->string('file')->nullable();
            $table->string('file_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('truck_vehicle_maintenances');
    }
}
