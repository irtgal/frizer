<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('users', 'slug'))
        {
            Schema::table('users', function (Blueprint $table) {
                $table->string('slug')->after('email');
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
        if (Schema::hasColumn('users', 'slug'))
        {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('slug');
            });
        }
    }
}
