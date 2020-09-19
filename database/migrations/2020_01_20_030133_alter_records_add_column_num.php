<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRecordsAddColumnNum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('records', 'num')) {
            Schema::table('records', function (Blueprint $table) {
                $table->bigInteger('num')->default(0);
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('records', 'num')) {
            {
                Schema::table('records', function (Blueprint $table) {
                    $table->dropColumn('num');
                });
            }
        }
    }
}
