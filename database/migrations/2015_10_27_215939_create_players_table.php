<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->increments('id');
            $table->string('common_name');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('card_name');
            $table->string('img')->nullable();
            $table->string('img_small')->nullable();
            $table->string('img_medium')->nullable();
            $table->string('img_large')->nullable();
            $table->string('img_totw_medium')->nullable();
            $table->string('img_totw_large')->nullable();
            $table->string('slug');
            $table->integer('ea_id');
            $table->integer('ea_unique_id');
            $table->string('position');
            $table->string('position_full');
            $table->string('play_style');
            $table->string('play_style_id')->nullable();
            $table->string('height');
            $table->string('weight');
            $table->string('birthdate');
            $table->integer('overall_rating');
            $table->integer('acceleration');
            $table->integer('aggression');
            $table->integer('agility');
            $table->integer('balance');
            $table->integer('ball_control');
            $table->integer('crossing');
            $table->integer('curve');
            $table->integer('dribbling');
            $table->integer('finishing');
            $table->integer('free_kick_accuracy');
            $table->integer('gk_diving');
            $table->integer('gk_handling');
            $table->integer('gk_kicking');
            $table->integer('gk_positioning');
            $table->integer('gk_reflexes');
            $table->integer('heading_accuracy');
            $table->integer('interceptions');
            $table->integer('jumping');
            $table->integer('long_passing');
            $table->integer('long_shots');
            $table->integer('marking');
            $table->integer('penalties');
            $table->integer('positioning');
            $table->integer('potential');
            $table->integer('reactions');
            $table->integer('short_passing');
            $table->integer('shot_power');
            $table->integer('sliding_tackle');
            $table->integer('sprint_speed');
            $table->integer('standing_tackle');
            $table->integer('stamina');
            $table->integer('strength');
            $table->integer('vision');
            $table->integer('volleys');
            $table->integer('weak_foot');
            $table->integer('skill_moves');
            $table->string('foot');
            $table->string('workrate_att');
            $table->string('workrate_def');
            $table->string('player_type');
            $table->string('item_type');
            $table->integer('card_att_1');
            $table->integer('card_att_2');
            $table->integer('card_att_3');
            $table->integer('card_att_4');
            $table->integer('card_att_5');
            $table->integer('card_att_6');
            $table->string('quality');
            $table->string('color');
            $table->boolean('is_gk');
            $table->boolean('is_special_type');
            $table->string('traits')->nullable();
            $table->string('specialities')->nullable();
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
        Schema::drop('players');
    }
}
