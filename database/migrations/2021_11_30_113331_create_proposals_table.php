<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->date('issue_date');
            $table->string('proposal_number');
            $table->date('send_date')->nullable();
            $table->integer('category_id')->nullable();
            $table->bigInteger('project_id')->nullable();
            $table->integer('status')->default(0);
            $table->boolean('is_converted')->default(false);
            $table->integer('discount_apply')->default('0')->nullable();
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
        Schema::dropIfExists('proposals');
    }
}
