<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        //        код по сиду англ слов ниже
//        $file_name = 'storage/app/public/english_words.txt';
//
//        $file = fopen($file_name, 'r');
//
//        $content = fread($file, filesize($file_name));
//
//        fclose($file);
////        $content = preg_replace('/[^a-zA-Zа-яА-ЯёЁ]/u', '', $content);
//        $content = trim($content);
//
//        $english_words = explode(',', $content);
//
////        dd($english_words);
//
//        for ($i = 0; $i <= count($english_words); $i++) {
//            Words::firstOrCreate([
//                'english' => $english_words[$i],
//            ], [
//                'english' => trim($english_words[$i]),
//            ]);
//        }
//        dump("Everything done");
    }
}
