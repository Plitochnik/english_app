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
        if (Schema::hasTable('messages') && !Schema::hasColumn('messages', 'is_seen')) {
            Schema::table('messages', function (Blueprint $table) {
                $table->boolean('is_seen')->after('user_id')->default(false);
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
       if (Schema::hasTable('messages') && Schema::hasColumn('messages', 'is_seen')) {
            Schema::table('messages', function (Blueprint $table) {
                $table->dropColumn('is_seen');
            });
        }
    }
};
