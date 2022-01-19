<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeavyEquipmentJobOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('heavy_equipment_job_orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('heavy_equipment_id');
            $table->bigInteger('job_order_type_id');
            $table->date('date_created');
            $table->string('assignee');
            $table->string('status');
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
        Schema::dropIfExists('heavy_equipment_job_orders');
    }
}
