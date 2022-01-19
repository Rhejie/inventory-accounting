<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumnProjectInPurchaseOrderFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_order_forms', function (Blueprint $table) {
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade')->after('push_order_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_order_forms', function (Blueprint $table) {
            //
        });
    }
}
