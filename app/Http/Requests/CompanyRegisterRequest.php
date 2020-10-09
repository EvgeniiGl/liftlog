<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRegisterRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'company_name' => ['required', 'max:1000'],
            'company_inn' => ['required', 'unique:companies,inn', 'max:12'],
            'company_phone' => ['required', 'digits:11', 'numeric', 'starts_with:7,8'],
            'company_email' => ['required', 'email', 'max:255'],
            'name' => 'required|string|max:255',
            'phone' => ['required', 'digits:11', 'numeric', 'starts_with:7,8'],
            'login' => 'required|string|max:255|unique:users,login',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'login.unique' => 'Такой логин уже существует',
            'company_inn.unique' => 'Такой ИНН уже существует',
        ];
    }
}
