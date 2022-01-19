<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtherAssetDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_asset_documents', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('other_asset_id')->unsigned();
            $table->foreign('other_asset_id')->references('id')->on('other_assets')->onDelete('cascade');
            $table->longText('attached_file');
            $table->longText('file_type');
            $table->longText('file_name');
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
        Schema::dropIfExists('other_asset_documents');
    }
}
