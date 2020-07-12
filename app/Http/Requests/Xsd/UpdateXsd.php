<?php

namespace App\Http\Requests\Xsd;

use Illuminate\Foundation\Http\FormRequest;

class UpdateXsd extends FormRequest
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
            'title' => 'max:255|min:3',
            'xsd-file' => 'max:20000|mimes:zip',
            'root_xsd' => 'max:255',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.min' => 'В названии должно быть минимум 3 символа',
            'title.max' => 'Слишком длинное название',
        ];
    }
}
