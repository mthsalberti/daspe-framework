<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dw_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('namespace')->nullable();
            $table->string('slug')->nullable();
            $table->string('singular_name')->nullable();
            $table->string('plural_name')->nullable();
            $table->string('gender')->nullable();
            $table->string('icon')->nullable();
            $table->boolean('hide_view_mode')->default(0);
            $table->boolean('has_owner_field')->default(1);
            $table->string('ownership_fields')->nullable();
            $table->boolean('use_card_for_browse')->default(0);
            $table->string('add_new_label')->nullable();
            $table->string('edit_label')->nullable();
            $table->string('delete_label')->nullable();
            $table->string('default_order_by')->nullable();
            $table->string('default_order_by_direction')->nullable();
            $table->boolean('is_displayed_on_app_center')->default(0);
            $table->string('app_center_group')->nullable();
            $table->integer('order')->nullable();
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
        Schema::dropIfExists('dw_models');
    }
}
