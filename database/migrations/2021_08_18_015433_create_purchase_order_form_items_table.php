<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderFormItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_form_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('purchase_order_form_id');
            $table->bigInteger('item_id')->nullable();
            $table->string('description')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('unit')->nullable();
            $table->float('unit_price',30,2)->nullable();
            $table->float('amount',30,2)->nullable();
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
        Schema::dropIfExists('purchase_order_form_items');
    }
}
