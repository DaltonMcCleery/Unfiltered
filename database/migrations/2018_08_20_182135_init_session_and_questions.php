<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitSessionAndQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->increments('id');
            $table->string('session_id');
            $table->string('game_id');
            $table->integer('ninja_id')->references('id')->on('users');
            $table->string('type')->default('public');
            $table->integer('max_sessions')->default(6);
            $table->integer('current_sessions')->default(1);
            $table->integer('status')->default(0); // 0 = not started, 1 = in progress (can't join game that is in progress)
            $table->timestamps();
        });

        Schema::create('game_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('session_id')->references('session_id')->on('games')->onDelete('cascade');
            $table->mediumText('question');
            $table->integer('ninja_id')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::create('game_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('session_id')->references('session_id')->on('games')->onDelete('cascade');;
            $table->mediumText('answer');
            $table->integer('ninja_id')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::create('stats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ninja_id')->references('id')->on('users');
            $table->integer('games_won');
            $table->integer('likes');
            $table->integer('loves');
            $table->integer('dislikes');
            $table->timestamps();
        });

        Schema::create('saved_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->mediumText('question');
            $table->integer('ninja_id')->references('id')->on('users');
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
        //
    }
}
