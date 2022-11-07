<?php

namespace App\Http\Controllers\PushValues;

use App\Http\Controllers\Controller;
use App\Models\Words;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PushToDatabaseController extends Controller
{
    public function __invoke()
    {
        // код по пушу англ слов ниже
        function storageFilesToArrayAndDeleteTrims($filename): array
        {
            $content = Storage::disk('local')->get($filename);
            $words = explode(',', $content);

            for ($i = 0; $i <= count($words) - 1; $i++) {
                $words[$i] = trim($words[$i]);
            }

            return $words;
        }

        $english_words = storageFilesToArrayAndDeleteTrims('english_words.txt');
        $ukrainian_words = storageFilesToArrayAndDeleteTrims('ukrainian_words.txt');
        $russian_words = storageFilesToArrayAndDeleteTrims('russian_words.txt');
        $spanish_words = storageFilesToArrayAndDeleteTrims('spanish_words.txt');

        function pushValuesToDatabase($words, $english_value, $ukrainian_value, $russian_value, $spanish_value)
        {
            for ($i = 0; $i <= count($words) - 1; $i++) {
                Words::firstOrCreate([
                    'english' => $english_value[$i],
                    'ukrainian' => $ukrainian_value[$i],
                    'russian' => $russian_value[$i],
                    'spanish' => $spanish_value[$i],
                ], [
                    'english' => $english_value[$i],
                    'ukrainian' => $ukrainian_value[$i],
                    'russian' => $russian_value[$i],
                    'spanish' => $spanish_value[$i],
                ]);
            }
        }

        pushValuesToDatabase($english_words, $english_words, $ukrainian_words, $russian_words, $spanish_words);


        dump("Everything done");

        return view('home_game.test');
    }

}
