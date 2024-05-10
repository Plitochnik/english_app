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
        if (!Schema::hasTable('games')) {
            Schema::create('games', function (Blueprint $table) {
                $table->id();
                $table->boolean('is_online')->nullable();
                $table->boolean('is_private')->nullable();
                $table->string('total_questions')->nullable();
                $table->string('test_from')->nullable();
                $table->string('test_to')->nullable();
                $table->string('language_level')->nullable();
                $table->integer('winner_user_id')->nullable();
                $table->string('key')->nullable();

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
        Schema::dropIfExists('games');
    }
};
