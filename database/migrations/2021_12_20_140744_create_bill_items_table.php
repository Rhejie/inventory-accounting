<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bill_id');
            $table->unsignedBigInteger('purchase_order_id')->nullable();
            $table->string('purchase_order_number')->nullable();
            $table->string('name')->nullable();
            $table->string('company_name')->nullable();
            $table->bigInteger('project_id')->nullable();
            $table->float('amount', 20, 2);
            $table->float('discount', 20, 2)->nullable();
            $table->float('subtotal_net', 20, 2);
            $table->float('others', 20, 2)->nullable();
            $table->float('subtotal', 20, 2);
            $table->float('vat')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file')->nullable();
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
        Schema::dropIfExists('bill_items');
    }
}
