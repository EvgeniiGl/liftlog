<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pgsql_company')->create('lifts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('num')->nullable();
            $table->string('reg_num')->nullable();
            $table->string('serial_num')->nullable();
            $table->mediumInteger('year_mf')->nullable();//год изг.
            $table->mediumInteger('type_id')->nullable();//reference
            $table->mediumInteger('capacity')->nullable();
            $table->tinyInteger('floor')->nullable();
            $table->tinyInteger('speed')->nullable();
            $table->tinyInteger('maker_id')->nullable();
            $table->dateTime('date_exam')->nullable();//date examination
            $table->dateTime('type_exam_id')->nullable();
            $table->dateTime('design_id')->nullable();
            $table->string('description')->nullable();
            $table->bigInteger('address_id');
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
        Schema::dropIfExists('lifts');
    }
}
