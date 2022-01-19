<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRequestMaterialFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('request_material_forms', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->change();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade')->change();
            $table->date('date_request')->nullable()->change();
            $table->string('requested_by')->nullable()->change();
            $table->string('approved_by')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('request_materials_forms', function (Blueprint $table) {
            //
        });
    }
}
