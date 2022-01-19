<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumnRequestMaterialFormConsumableItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('request_materials_form_consumable_items', function (Blueprint $table) {
            $table->unsignedBigInteger('r_m_form_id')->change();
            $table->foreign('r_m_form_id')->references('id')->on('request_material_forms')->onDelete('cascade')->change();
            $table->unsignedBigInteger('c_s_id')->change();
            $table->foreign('c_s_id')->references('id')->on('consumable_supplies')->onDelete('cascade')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('request_materials_form_consumable_items', function (Blueprint $table) {
            $table->unsignedBigInteger('r_m_form_id')->change();
            $table->foreign('r_m_form_id')->references('id')->on('request_material_forms')->onDelete('cascade')->change();
            $table->unsignedBigInteger('c_s_id')->change();
            $table->foreign('c_s_id')->references('id')->on('consumable_supplies')->onDelete('cascade')->change();
        });
    }
}
