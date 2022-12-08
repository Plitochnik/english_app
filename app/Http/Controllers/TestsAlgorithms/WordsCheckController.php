<?php

namespace App\Http\Controllers\TestsAlgorithms;

use App\Http\Controllers\Controller;
use App\Http\Requests\ParamFormRequest;
use App\Models\Words;
use Illuminate\Http\Request;
use Inertia\Inertia;
use JetBrains\PhpStorm\NoReturn;

class WordsCheckController extends Controller
{
    public function manageWords(ParamFormRequest $request): \Inertia\Response|\Inertia\ResponseFactory
    {
        $posts = $request->validated();

        $home_language = mb_strtolower($posts['home_language']);
        $test_language = mb_strtolower($posts['test_language']);
        $picked = mb_strtolower($posts['picked']);

        function getUsersTestLevel($picked): array
        {
            $picked_level = [];

            if ($picked === 'upper-intermediate') {
                $picked_level[0] = 1;
                $picked_level[1] = 500;
            }

            if ($picked === 'advanced') {
                $picked_level[0] = 500;
                $picked_level[1] = count(Words::all());
            }

            return $picked_level;
        }

        $picked_level = getUsersTestLevel($picked);

        function createRandomValuesForTestWordsAndAnswers($picked_level): array
        {
            $random_true_value = [];

            for ($i = 0; $i <= 9; $i++) {
                $random_true_value[$i] = rand($picked_level[0], $picked_level[1]);
            }

            return $random_true_value;
        }

        $random_true_value = createRandomValuesForTestWordsAndAnswers($picked_level);

        function getTestWords($picked_level, $test_language, $random_true_value): array
        {
            $test_words = [];

            for ($i = 0; $i <= 9; $i++) {
                $test_words[] = mb_convert_case(Words::find($random_true_value[$i])->$test_language, MB_CASE_TITLE);
            }

            return $test_words;
        }

        function getTrueAnswers($random_true_value, $home_language): array
        {
            $true_answers = [];

            for ($i = 0; $i <= 9; $i++) {
                $true_answers[$i] = mb_convert_case(Words::find($random_true_value[$i])->$home_language, MB_CASE_TITLE);
            }

            return $true_answers;
        }

        $test_words = getTestWords($picked_level, $test_language, $random_true_value);
        $true_answers = getTrueAnswers($random_true_value, $home_language);

        function mergeTrueWordToFalseArrayAnswerList($test_words, $true_answers, $picked_level, $home_language): array
        {
            $ready_words_for_test = [];

            for ($i = 0; $i <= 9; $i++) {
                $ready_words_for_test[$i] = [
                    $test_words[$i] => [
                        mb_convert_case(Words::find(rand($picked_level[0], $picked_level[1]))->$home_language, MB_CASE_TITLE),
                        mb_convert_case(Words::find(rand($picked_level[0], $picked_level[1]))->$home_language, MB_CASE_TITLE),
                        mb_convert_case(Words::find(rand($picked_level[0], $picked_level[1]))->$home_language, MB_CASE_TITLE),
                        mb_convert_case(Words::find(rand($picked_level[0], $picked_level[1]))->$home_language, MB_CASE_TITLE),
                    ]
                ];
            }

            for ($i = 0; $i <= 9; $i++) {
                $ready_words_for_test[$i][$test_words[$i]][4] = $true_answers[$i];
                shuffle($ready_words_for_test[$i][$test_words[$i]]);
            }

            return $ready_words_for_test;
        }

        $ready_words_for_test = mergeTrueWordToFalseArrayAnswerList($test_words, $true_answers, $picked_level, $home_language);

        function getKeyOfCorrectAnswer($ready_words_for_test, $test_words, $true_answers): array
        {
            $key_of_true_answer = [];

            for ($i = 0; $i <= 9; $i++) {
                $key_of_true_answer[$i] = array_search($true_answers[$i], $ready_words_for_test[$i][$test_words[$i]]);
            }

            for ($i = 0; $i <= 9; $i++) {
                $ready_words_for_test[$i][$test_words[$i]][5] = $key_of_true_answer[$i];
            }

            return $ready_words_for_test;
        }

        $ready_words_for_test = getKeyOfCorrectAnswer($ready_words_for_test, $test_words, $true_answers);

        return Inertia::render('Test/Test', compact('ready_words_for_test', 'test_words'));
    }


}
