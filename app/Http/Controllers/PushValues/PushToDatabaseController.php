<?php

namespace App\Http\Controllers\PushValues;

use App\Http\Controllers\Controller;
use App\Models\Words;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PushToDatabaseController extends Controller
{
    // код по пушу англ слов ниже
    public array $english_words, $ukrainian_words, $russian_words, $spanish_words;

    public function storageFilesToArrayAndDeleteTrims($filename): array
    {
        $content = Storage::disk('local')->get($filename);
        $words = explode(',', $content);

        for ($i = 0; $i <= count($words) - 1; $i++) {
            $words[$i] = trim($words[$i]);
        }

        return $words;
    }

    public function __construct()
    {
        $this->english_words = $this->storageFilesToArrayAndDeleteTrims('english_words.txt');
        $this->ukrainian_words = $this->storageFilesToArrayAndDeleteTrims('ukrainian_words.txt');
        $this->russian_words = $this->storageFilesToArrayAndDeleteTrims('russian_words.txt');
        $this->spanish_words = $this->storageFilesToArrayAndDeleteTrims('spanish_words.txt');
    }

    public function getAndPushValuesToDatabase($english_words,$ukrainian_words, $russian_words, $spanish_words): void
    {
        for ($i = 0; $i <= count($english_words); $i++) {

            Words::create([
                'english' => ucfirst($english_words[$i]),
                'ukrainian' => ucfirst($ukrainian_words[$i]),
                'russian' => ucfirst($russian_words[$i]),
                'spanish' => ucfirst($spanish_words[$i]),
            ]);
        }
    }

}
