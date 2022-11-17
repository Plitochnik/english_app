<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParamFormRequest extends FormRequest
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
            'home_language' => 'required|string',
            'test_language' => 'required|string',
            'picked' => 'required|string',
        ];
    }
}
