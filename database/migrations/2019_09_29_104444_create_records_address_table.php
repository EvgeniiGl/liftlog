<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordsAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records_address', function (Blueprint $table) {
            $table->integer('records_id');
        });
        DB::statement('ALTER TABLE records_address ADD address_id binary(16)');
        Schema::table('records_address', function (Blueprint $table) {
            $table->foreign('records_id')->references('id')->on('records')->onDelete('cascade')->onUpdate('cascade');
//            $table->foreign('address_id')->references('_IDRRef')->on('_Reference10');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('records_address');
    }
}
