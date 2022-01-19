<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_assets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('asset_category_id')->nullable();
            $table->string('brand_name');
            $table->string('plate_number')->comment('Plate Number/MV File Number');
            $table->longText('body_type')->comment('description')->nullable();
            $table->date('date_acquired')->nullable();
            $table->string('assigned_to')->nullable();
            $table->string('status');
            $table->decimal('cost', 15, 2)->nullable();
            $table->longText('photo')->nullable();
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
        Schema::dropIfExists('vehicle_assets');
    }
}
