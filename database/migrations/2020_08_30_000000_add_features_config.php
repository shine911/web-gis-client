<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFeaturesConfig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('layers', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->string('layer_name');
            //type: 1 Floor, type: 2 - Water, 3 - Electric
            $table->integer('layer_type');
            $table->string('url');
            $table->boolean('user_hide');
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
        Schema::table('features_config', function (Blueprint $table) {
            Schema::drop('features_config');
        });
    }
}
