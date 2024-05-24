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
        if (Schema::hasTable('games') && !Schema::hasColumn('games', 'players_count')) {
            Schema::table('games', function (Blueprint $table) {
                $table->integer('players_count')->after('test_to');
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
        if (Schema::hasTable('games') && Schema::hasColumn('games', 'players_count')) {
            Schema::table('games', function (Blueprint $table) {
                $table->dropColumn('players_count');
            });
        }
    }
};
