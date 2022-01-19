<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsumabeSuppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consumable_supplies', function (Blueprint $table) {
            $table->id();
            $table->string('item_code')->nullable();
            $table->string('item_name')->nullable();
            $table->bigInteger('project_id')->nullable();
            $table->string('bar_code')->nullable();
            $table->string('lot_number')->nullable();
            $table->string('description')->nullable();
            $table->string('unit_of_measure')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('stock_on_hand')->nullable();
            $table->integer('reorder_point')->nullable();
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
        Schema::dropIfExists('consumabe_supplies');
    }
}
