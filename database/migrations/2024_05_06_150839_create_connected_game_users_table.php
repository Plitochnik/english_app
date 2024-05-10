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
        if (!Schema::hasTable('connected_game_users')) {
            Schema::create('connected_game_users', function (Blueprint $table) {
                $table->id();
                $table->foreignId('game_id')->constrained();
                $table->foreignId('user_id')->constrained();
                $table->timestamps();
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
        Schema::dropIfExists('connected_game_users');
    }
};
