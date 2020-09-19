<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnPhoneToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('users', 'phone'))
        {
            Schema::table('users', function (Blueprint $table)
            {
                $table->bigInteger('phone')->nullable();
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
        if (Schema::hasColumn('users', 'phone'))
        {
            Schema::table('users', function (Blueprint $table)
            {
                $table->dropColumn('phone');
            });
        }
    }
}
