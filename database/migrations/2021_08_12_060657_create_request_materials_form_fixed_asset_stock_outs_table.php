<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestMaterialsFormFixedAssetStockOutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_materials_form_fixed_asset_stock_outs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('request_materials_form_fixed_asset_items_id');
            $table->string('is_delivered')->nullable();
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
        Schema::dropIfExists('request_materials_form_fixed_asset_stock_outs');
    }
}
