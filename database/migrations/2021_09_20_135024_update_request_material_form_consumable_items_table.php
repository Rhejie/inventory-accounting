<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRequestMaterialFormConsumableItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('request_materials_form_consumable_items', function (Blueprint $table) {
            $table->renameColumn('request_materials_form_id', 'r_m_form_id');
            $table->renameColumn('consumable_supplies_id', 'c_s_id');
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
            $table->renameColumn('request_materials_form_id', 'r_m_form_id');
            $table->renameColumn('consumable_supplies_id', 'c_s_id');
        });
    }
}
