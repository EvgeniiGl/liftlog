<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_address', function (Blueprint $table) {
            $table->integer('user_id');
            $table->integer('lift_id');
        });
//        DB::statement('ALTER TABLE users_address ADD address_id binary(16)');
        Schema::table('users_address', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('users_address');
    }
}
