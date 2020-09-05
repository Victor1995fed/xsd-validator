<?php

namespace App\Http\Requests\Form;

use Illuminate\Foundation\Http\FormRequest;

class GetForm extends FormRequest
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
            'root-element' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'root-element.required' => 'Укажите корневой элемент для генерации формы',
            'zip.required' => 'Загрузите архив с xsd',
            'main-xsd.required' => 'Укажите имя корневой xsd',
            'zip.mimes' => 'Поддерживается только формат zip',
        ];
    }
}
