<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdminIds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('terms', 'admin_id'))
        {
            Schema::table('terms', function (Blueprint $table) {
                $table->unsignedBigInteger('admin_id');
            });
        }
        if (!Schema::hasColumn('types', 'admin_id'))
        {
            Schema::table('types', function (Blueprint $table) {
                $table->unsignedBigInteger('admin_id');
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
        if (Schema::hasColumn('terms', 'admin_id'))
        {
            Schema::table('terms', function (Blueprint $table) {
                $table->dropColumn('admin_id');
            });
        }
        if (Schema::hasColumn('types', 'admin_id'))
        {
            Schema::table('types', function (Blueprint $table) {
                $table->dropColumn('admin_id');
            });
        }
    }
}
