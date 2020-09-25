<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToUsersTable extends Migration
{
    public function up()
    {

        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable();
            $table->string('last_name')->nullable();
            $table->unsignedInteger('role_id');
            //$table->foreign('role_id')->references('id')->on('roles');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('avatar');
            $table->dropColumn('role_id');
        });
    }
}
