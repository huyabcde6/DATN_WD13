<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SizeRequetUpdate extends FormRequest
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
            'value' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'value.required' => 'Kích thước không được để trống',
            'value.string' => 'Kích thước phải là chuỗi',
            'value.max' => 'Kích thước không vượt qua 255 ký tự',
            
        ];
    }
}
