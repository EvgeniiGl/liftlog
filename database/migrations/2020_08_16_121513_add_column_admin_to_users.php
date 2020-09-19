<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnAdminToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('users', 'admin')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('admin')->default(0);
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
        if (Schema::hasColumn('users', 'admin')) {
            Schema::table('admin', function (Blueprint $table) {
                $table->dropColumn('admin');
            });
        }
    }
}
