<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->mediumInteger('postcode')->nullable();
            $table->bigInteger('region_id');
            $table->bigInteger('city_id')->nullable();
            $table->bigInteger('locality_id')->nullable();
            $table->bigInteger('type_street_id');
            $table->bigInteger('street_id');
            $table->string('house')->nullable();
            $table->string('building')->nullable();
            $table->string('entrance')->nullable();
            $table->string('office')->nullable();
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
        Schema::dropIfExists('addresses');
    }
}
