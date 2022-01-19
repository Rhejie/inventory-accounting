<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestMaterialFormConsumableSuppliesStockOutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_material_form_consumable_supplies_stock_outs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('request_material_id');
            $table->bigInteger('request_materials_form_consumable_item_id');
            $table->boolean('is_delivered')->default(false);
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
        Schema::dropIfExists('request_material_form_consumable_supplies_stock_outs');
    }
}
