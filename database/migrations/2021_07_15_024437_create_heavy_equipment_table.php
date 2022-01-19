<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeavyEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('heavy_equipments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('asset_category_id');
            $table->string('control_number');
            $table->string('brand_name');
            $table->string('model')->nullable();
            $table->string('engine_model')->nullable();
            $table->string('engine_number')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('reference_number')->nullable();
            $table->string('capacity')->nullable();
            $table->longText('description')->nullable();
            $table->date('date_acquired')->nullable();
            $table->longText('photo')->nullable();
            $table->string('status');
            $table->string('assigned_to')->nullable();
            $table->float('cost', 20, 2)->nullable();
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
        Schema::dropIfExists('heavy_equipments');
    }
}
