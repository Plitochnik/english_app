<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // rename game_answers table to user_answers
        if (Schema::hasTable('game_answers')) {
            Schema::rename('game_answers', 'user_answers');
        }

        // rename columns of user_answers table
        if (Schema::hasTable('user_answers')) {
            Schema::table('user_answers', function (Blueprint $table) {
                $table->dropColumn('question_word_id');
                $table->dropColumn('answer_word_id');
                $table->dropColumn('correct_answer_word_id');

                $table->foreignId('question_id')->constrained();
                $table->foreignId('answer_id')->constrained('question_answers');
                $table->integer('correct_answer_id');
            });
        }

        // add topic_slug column to games
        if (Schema::hasTable('games')) {
            Schema::table('games', function (Blueprint $table) {
                $table->string('topic_slug')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // rename user_answers table to game_answers
        if (Schema::hasTable('user_answers')) {
            Schema::rename('user_answers', 'game_answers');
        }

        // rename columns of game_answers table
        if (Schema::hasTable('game_answers')) {
            Schema::table('game_answers', function (Blueprint $table) {
                $table->dropColumn('question_id');
                $table->dropColumn('answer_id');
                $table->dropColumn('correct_answer_id');

                $table->integer('question_word_id');
                $table->integer('answer_word_id');
                $table->integer('correct_answer_word_id');
            });
        }

        // drop topics table
        if (Schema::hasTable('topics')) {
            Schema::dropIfExists('topics');
        }

        // drop topic_slug column from games
        if (Schema::hasTable('games')) {
            Schema::table('games', function (Blueprint $table) {
                $table->dropColumn('topic_slug');
            });
        }
    }
};
