<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('creator_id');
            $table->string('type');
            $table->text('theme')->nullable();
            $table->text('theme_end')->nullable();
            $table->dateTime('time_create',4);
            $table->dateTime('time_sent',4)->nullable();
            $table->integer('maker_id')->nullable();
            $table->dateTime('time_take',4)->nullable();
            $table->dateTime('time_done',4)->nullable();
            $table->integer('closer_id')->nullable();
            $table->text('notice')->nullable();
            $table->dateTime('time_incident',4)->nullable();
            $table->dateTime('time_evacuation',4)->nullable();
            $table->boolean('evacuation')->default(0);
            $table->softDeletes();
            $table->timestamps(4);
        });

        Schema::table('records', function (Blueprint $table) {
            $table->foreign('creator_id')->references('id')->on('users');
            $table->foreign('maker_id')->references('id')->on('users');
            $table->foreign('closer_id')->references('id')->on('users');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('records');
    }
}
