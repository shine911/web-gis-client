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
            //type: 0 Floor, type: 2 - Dormitory, 3 - Electric, 4 - Water
            $table->integer('layer_type');
            $table->integer('floor');
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
        Schema::table('layers', function (Blueprint $table) {
            Schema::drop('layers');
        });
    }
}
