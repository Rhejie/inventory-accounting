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
            $table->foreignId('invoice_id')->nullable()->unsigned();
            $table->string('item_name')->nullable();
            $table->integer('quantity')->nullable()->unsigned();
            $table->decimal('rate',20,2)->nullable()->unsigned();
            $table->decimal('tax_percentage')->nullable()->unsigned();
            $table->decimal('discount',20,2)->nullable()->unsigned();
            $table->decimal('sub_total',20,2)->nullable()->unsigned();
            $table->string('note')->nullable();
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
