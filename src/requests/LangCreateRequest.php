<?php

namespace Sashaef\TranslateProvider\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LangCreateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:128',
            'index' => 'required|string|min:2|max:5',
            'flag' => 'required|string|max:2'
        ];
    }
}
