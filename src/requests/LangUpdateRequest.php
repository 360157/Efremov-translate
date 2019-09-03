<?php

namespace Sashaef\TranslateProvider\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LangUpdateRequest extends FormRequest
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
            'id' => 'required|integer',
            'name' => 'required|string|max:191',
            'index' => 'required|string|max:191'
        ];
    }
}
