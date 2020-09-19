<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('login')->unique();
            $table->bigInteger('phone');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps(4);
            $table->string('role');
            $table->integer('access_users')->default(0);
            $table->integer('access_records')->default(0);
            $table->integer('notificate')->default(2);
        });

//        Schema::table('users', function ($table) {
//            $table->string('api_token', 80)->after('password')
//                ->unique()
//                ->nullable()
//                ->default(null);
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
