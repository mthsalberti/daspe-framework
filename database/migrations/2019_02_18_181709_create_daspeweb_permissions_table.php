<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDaspewebPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dw_permission_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('dw_model_id')->nullable();
            $table->string('permission_name');
            $table->foreign('dw_model_id')->references('id')->on('dw_models')->onDelete('set null');
            $table->timestamps();
        });
        Schema::create('dw_permission_detail_role', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('dw_permission_detail_id')->nullable();
            $table->unsignedInteger('role_id')->nullable();
            $table->boolean('is_allowed')->default(1);
            $table->foreign('dw_permission_detail_id')->references('id')->on('dw_permission_details')->onDelete('set null');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
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
        Schema::dropIfExists('dw_permissions');
        Schema::dropIfExists('dw_permission_details');
    }
}
