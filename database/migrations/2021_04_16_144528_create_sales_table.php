<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date')->nullable();
            $table->string('customer')->nullable();
            $table->string('clerk')->nullable();
            $table->decimal('amount',20,2)->nullable();
            $table->decimal('vat',20,2)->nullable();
            $table->decimal('discount')->nullable();
            $table->string('discount_type')->nullable();
            $table->decimal('tendered',20,2)->nullable();
            $table->decimal('change',20,2)->nullable();
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
        Schema::dropIfExists('sales');
    }
}
