<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestMaterialFormConsumableItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_material_form_consumable_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('request_materials_form_id');
            $table->bigInteger('consumable_supplies_id');
            $table->date('date_requested')->nullable();
            $table->string('item')->nullable();
            $table->string('material_request')->nullable();
            $table->integer('quantity')->nullable();
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
        Schema::dropIfExists('request_material_form_consumable_items');
    }
}
