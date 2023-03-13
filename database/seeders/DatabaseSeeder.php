<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Http\Controllers\PushValues\PushToDatabaseController;
use App\Models\Words;
use Database\Factories\WordsFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

    public function run()
    {
        $get_sources_words = new PushToDatabaseController();

        $get_sources_words->getAndPushValuesToDatabase(
            $get_sources_words->english_words,
            $get_sources_words->ukrainian_words,
            $get_sources_words->russian_words,
            $get_sources_words->spanish_words,
        );

    }
}
