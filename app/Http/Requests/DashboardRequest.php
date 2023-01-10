<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DashboardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'user_id' => 'required|integer',
            'percent' => 'required|integer',
            'test_word' => 'required|string',
            'user_answer' => 'required|string',
            'true_ids' => 'required|string',
            'home_lang' => 'required|string',
            'test_lang' => 'required|string',
            'true_answers' => 'required|integer',
            'false_answers' => 'required|integer',
        ];
    }
}
