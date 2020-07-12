<?php

namespace App\Http\Requests\Xsd;

use Illuminate\Foundation\Http\FormRequest;

class StoreXsd extends FormRequest
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
            'title' => 'required|max:255|min:3',
            'xsd-file' => 'required|max:20000|mimes:zip',
            'root_xsd' => 'required|max:255',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Название обязательно',
            'xsd-file.required' => 'Загрузка файла обязательна',
            'root_xsd.required' => 'Не указана корневая схема',
            'title.min' => 'В названии должно быть минимум 3 символа',
            'title.max' => 'Слишком длинное название',
        ];
    }
}
