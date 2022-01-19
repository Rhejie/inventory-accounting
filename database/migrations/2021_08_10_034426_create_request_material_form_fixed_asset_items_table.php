<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestMaterialFormFixedAssetItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_material_form_fixed_asset_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('request_materials_form_id');
            $table->bigInteger('type_id');
            $table->string('type')->nullable();
            $table->date('date_requested')->nullable();
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
        Schema::dropIfExists('request_material_form_fixed_asset_items');
    }
}
