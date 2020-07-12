<?php

namespace App\Http\Requests\Tags;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStoreTag extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:50|min:3|unique:tags,title',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Не указано название',
            'title.min' => 'Минимум 3 символа',
            'title.max' => 'Максимум 50 символов',
            'title.unique' => 'Метка с таким названием уже существует',
        ];
    }
}
