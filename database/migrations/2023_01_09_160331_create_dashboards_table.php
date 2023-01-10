<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dashboards', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('percent');
            $table->string('test_word');
            $table->string('user_answer');
            $table->string('true_ids');
            $table->string('home_lang');
            $table->string('test_lang');
            $table->integer('true_answers');
            $table->integer('false_answers');

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
        Schema::dropIfExists('dashboards');
    }
};
