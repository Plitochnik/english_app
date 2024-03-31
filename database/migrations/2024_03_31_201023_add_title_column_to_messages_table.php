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
        if (Schema::hasTable('messages') && !Schema::hasColumn('messages', 'title')) {
            Schema::table('messages', function (Blueprint $table) {
                $table->text('title')->after('id');
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
        if (Schema::hasTable('messages') && Schema::hasColumn('messages', 'title')){
            Schema::table('messages', function (Blueprint $table) {
                $table->dropColumn('title');
            });
        }
    }
};
