<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUser extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'g-recaptcha-response'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'g-recaptcha-response.required' => 'Пройдите капчу',
        ];
    }
}
