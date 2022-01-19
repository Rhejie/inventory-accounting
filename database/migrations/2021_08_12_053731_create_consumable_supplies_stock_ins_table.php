<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsumableSuppliesStockInsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consumable_supplies_stock_ins', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('purchase_order_form_id');
            $table->bigInteger('purchase_order_form_item_id');
            $table->date('date_received')->nullable();
            $table->integer('received_quantity')->nullable();
            $table->integer('remaining_quantity_to_receive')->nullable();
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
        Schema::dropIfExists('consumabe_supplies_stock_ins');
    }
}
