<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTruckVehicleDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('truck_vehicle_documents', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('truck_vehicle_id')->unsigned();
            $table->foreign('truck_vehicle_id')->references('id')->on('vehicle_assets')->onDelete('cascade');
            $table->longText('attached_file');
            $table->longText('file_type');
            $table->longText('file_name');
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
        Schema::dropIfExists('truck_vehicle_documents');
    }
}
