<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clubs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->string('name_abbr');
            $table->integer('ea_id');
            $table->string('img')->nullable();
            $table->string('img_dark_small')->nullable();
            $table->string('img_dark_medium')->nullable();
            $table->string('img_dark_large')->nullable();
            $table->string('img_light_small')->nullable();
            $table->string('img_light_medium')->nullable();
            $table->string('img_light_large')->nullable();
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
        Schema::drop('clubs');
    }
}
