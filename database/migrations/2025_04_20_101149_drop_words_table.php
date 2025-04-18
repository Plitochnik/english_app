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
        Schema::dropIfExists('words');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('words', function (Blueprint $table) {
            $table->id();
            $table->string('english')->default('');
            $table->string('ukrainian')->default('');;
            $table->string('russian')->default('');;
            $table->string('spanish')->default('');;
            $table->timestamps();
        });
    }
};
