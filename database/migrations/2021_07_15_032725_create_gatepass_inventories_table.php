<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGatepassInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gatepass_inventories', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number');
            $table->string('plate_number');
            $table->string('checked_by');
            $table->string('delivered_by');
            $table->string('received_by');
            $table->date('date_delivered');
            $table->date('date_received');
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
        Schema::dropIfExists('gatepass_inventories');
    }
}
