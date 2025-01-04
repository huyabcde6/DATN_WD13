<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ColorRequest extends FormRequest
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
            'value' => 'required|string|max:255|unique:colors',
            'color_code' => 'nullable|string|max:255',
            'status' => 'nullable|boolean',
        ];
    }

    public function messages()
    {
        return [
            'value.required' => 'Màu không được để trống',
            'value.string' => 'Màu phải là chuỗi',
            'value.max' => 'Màu không vượt qua 255 ký tự',
            'value.unique' => 'Màu này đã tồn tại',
            'color_code.string' => 'Màu phải là chuỗi',
            'color_code.max' => 'Màu không vượt qua 255 ký tự',
        ];
    }
}
