<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeavyEquipmentMaintenancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('heavy_equipment_maintenances', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('maintenance_type_id');
            $table->bigInteger('heavy_equipment_id');
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
        Schema::dropIfExists('heavy_equipment_maintenances');
    }
}
