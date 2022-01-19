<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposal_items', function (Blueprint $table) {
            $table->id();
            $table->integer('proposal_id');
            $table->integer('product_id');
            $table->string('name');
            $table->float('service_fee', 20, 2);
            $table->float('tax_rate')->nullable();
            $table->string('unit')->nullable();
            $table->integer('quantity');
            $table->float('tax', 20, 2)->default('0.00')->nullable();
            $table->float('discount', 20, 2)->default('0.00')->nullable();
            $table->float('price', 20, 2)->default('0.00')->nullable();
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
        Schema::dropIfExists('proposal_items');
    }
}
