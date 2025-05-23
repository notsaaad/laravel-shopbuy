<?php

namespace App\Http\Requests\admin\product;

use Illuminate\Foundation\Http\FormRequest;

class editRequest extends FormRequest
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
          'title'     => 'required',
          'price'     => 'required',
          'sale'      => 'required',
          'statue'    => 'required',
          'image'     => 'mimes:png,jpg,jpeg,webp',
          'categories' => 'required|array',
          'categories.*' => 'exists:categories,id',
        ];
    }
}
