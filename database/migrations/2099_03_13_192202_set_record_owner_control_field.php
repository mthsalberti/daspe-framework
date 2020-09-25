<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetRecordOwnerControlField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tables = array_map('reset', \DB::select('SHOW TABLES'));
        foreach ($tables as $tableName){
            if(!Schema::hasColumn($tableName, 'user_id') && $tableName <> 'migrations' && $tableName <> 'password_resets'){
                Schema::disableForeignKeyConstraints();
                \Illuminate\Support\Facades\Schema::table($tableName, function (Blueprint $table){
                    try{
                        $table->unsignedInteger('user_id')->nullable();
                        //$table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
                    }catch (Exception $e){}
                });
                Schema::enableForeignKeyConstraints();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
