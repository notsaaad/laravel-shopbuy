<?php

namespace App\Http\Requests\user;

use Illuminate\Foundation\Http\FormRequest;

class newuserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'      => 'required',
            'email'     => 'required|unique:users',
            'password'  => 'required|min:6',
            // 'confirmed' => 'required|same:password:6',
        ];
    }

    function messages(){
      return [
        "name.required" => "you must Enter your name",
        "email.required" => "you must Enter your Email",
        "password.required" => "you must Enter your password",
      ];
    }
}
