<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_id');
            $table->integer('product_id');
            $table->string('name');
            $table->float('service_fee', 20, 2);
            $table->float('tax_rate')->nullable();
            $table->string('unit')->nullable();
            $table->integer('quantity');
            $table->float('tax', 20, 2)->default('0.00')->nullable();
            $table->float('discount', 20, 2)->default('0.00')->nullable();
            $table->float('price', 20, 2)->default('0.00');
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
        Schema::dropIfExists('invoice_items');
    }
}
