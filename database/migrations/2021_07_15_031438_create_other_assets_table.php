<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtherAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_assets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('asset_category_id')->nullable();
            $table->string('brand_name');
            $table->longText('description')->nullable();
            $table->string('status');
            $table->float('cost', 20, 2)->nullable();
            $table->longText('photo')->nullable();
            $table->date('date_acquired')->nullable();
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
        Schema::dropIfExists('other_assets');
    }
}
