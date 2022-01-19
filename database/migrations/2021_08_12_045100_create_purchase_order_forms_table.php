<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_forms', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('supplier_id');
            $table->string('address')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('quote_reference_no')->nullable();
            $table->string('material_reference_no')->nullable();
            $table->date('date_needed')->nullable();
            $table->string('purchase_order_reference_no')->nullable();
            $table->date('push_order_date')->nullable();
            $table->string('project')->nullable();
            $table->string('location')->nullable();
            $table->string('requested_by')->nullable();
            $table->date('date_created')->nullable();
            $table->string('terms_of_payment')->nullable();
            $table->string('mode_of_payment')->nullable();
            $table->string('remarks')->nullable();
            $table->float('subtotal',30,2)->nullable();
            $table->float('vat',30,2)->nullable();
            $table->float('discount',30,2)->nullable();
            $table->float('subtotal_net',30,2)->nullable();
            $table->float('others',30,2)->nullable();
            $table->float('total_net',30,2)->nullable();
            $table->string('prepared_by')->nullable();
            $table->string('noted_by')->nullable();
            $table->string('checked_by')->nullable();
            $table->string('approved_by')->nullable();
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
        Schema::dropIfExists('purchase_order_forms');
    }
}
