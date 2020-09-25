<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DaspeCreateFiltercontrollerTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_views', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_only_for_me');
            $table->string('name', '50');
            $table->unsignedInteger('dw_model_id');
            $table->unsignedInteger('user_id')->nullable();
            $table->timestamps();
        });

        Schema::create('list_view_criterias', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('list_view_id');
            $table->string('field_api', '50');
            $table->string('field_label', '50');
            $table->string('field_type', '50');
            $table->string('criteria_api', '50');
            $table->string('criteria_label', '50');
            $table->string('value', '100');
            $table->string('value_api', '100');
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
        Schema::dropIfExists('list_view_criterias');
        Schema::dropIfExists('list_views');
    }
}
