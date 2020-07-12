<?php

namespace App\Http\Requests\Validate;

use Illuminate\Foundation\Http\FormRequest;

class CheckValidate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
//    public function authorize()
//    {
//        return false;
//    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'main-xsd' => 'required|max:255',
            'zip' => 'required|max:20000|mimes:zip',
            'xml' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'xml.required' => 'Заполните xml для проверки',
            'zip.required' => 'Загрузите архив с xsd',
            'main-xsd.required' => 'Укажите имя корневой xsd',
            'zip.mimes' => 'Поддерживается только формат zip',
        ];
    }
}
