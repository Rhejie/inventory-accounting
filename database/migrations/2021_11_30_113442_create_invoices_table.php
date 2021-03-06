<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('proposal_id')->nullable();
            $table->date('issue_date');
            $table->date('due_date')->nullable();
            $table->date('send_date')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->text('ref_number')->nullable();
            $table->integer('shipping_display')->default('1');
            $table->integer('discount_apply')->default('0');
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
        Schema::dropIfExists('invoices');
    }
}
