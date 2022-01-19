<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestMaterialsFormConsumableSuppliesStockOutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_materials_form_consumable_supplies_stock_outs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('consumable_supplies_id');
            $table->bigInteger('request_materials_form_id');
            $table->integer('actual_quantity_delivered')->nullable();
            $table->date('date_delivered')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('request_materials_form_consumable_supplies_stock_outs');
    }
}
