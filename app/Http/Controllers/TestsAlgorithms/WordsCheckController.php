<?php

namespace App\Http\Controllers\TestsAlgorithms;

use App\Http\Controllers\Controller;
use App\Http\Requests\ParamFormRequest;
use App\Models\Words;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\NoReturn;

class WordsCheckController extends Controller
{
    public function manageWords(ParamFormRequest $request)
    {
        $posts = $request->validated();

        $home_language = mb_strtolower($posts['home_language']);
        $test_language = mb_strtolower($posts['test_language']);

        function takeFalseTestWordsFromDatabase($test_lang): array
        {
            $false_test_words = [];

            for ($i = 0; $i <= 3; $i++) {
                $false_test_words[$i] = Words::find(rand(1, count(Words::all())))->$test_lang;
            }

            return $false_test_words;
        }

        $random_true_value = rand(1, count(Words::all()));
        $true_test_word = Words::find($random_true_value)->$test_language;
        $true_home_word = Words::find($random_true_value)->$home_language;

        $false_test_words = takeFalseTestWordsFromDatabase($home_language);

        function pushTrueWordToFalseArrayAnswerList($false_test_words, $true_test_word)
        {
            $five_users_answers = $false_test_words;
            array_push($five_users_answers, $true_test_word);

            shuffle($five_users_answers);

            return $five_users_answers;
        }


        function getKeyOfCorrectAnswer($five_users_answers, $true_home_word)
        {
            $key_of_true_answer = array_search($true_home_word, $five_users_answers);

            return $key_of_true_answer;
        }


        $random_false_values = takeFalseTestWordsFromDatabase($test_language);
        $five_users_answers = pushTrueWordToFalseArrayAnswerList($false_test_words, $true_home_word);
        $key_of_true_answer = getKeyOfCorrectAnswer($five_users_answers, $true_home_word);

        dump('Перевод слова: "' . $true_test_word . "\"\n" . 'Варианты ответа: ');
        dd($five_users_answers);

    }


}
