<?php

namespace App\Http\Controllers\PushValues;

use App\Http\Controllers\Controller;
use App\Models\Words;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PushToDatabaseController extends Controller
{
    // код по пушу англ слов ниже
    public function storageFilesToArrayAndDeleteTrims($filename): array
    {
        $content = Storage::disk('local')->get($filename);
        $words = explode(',', $content);

        for ($i = 0; $i <= count($words) - 1; $i++) {
            $words[$i] = trim($words[$i]);
        }

        return $words;
    }


}
