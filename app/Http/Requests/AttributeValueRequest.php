<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttributeValueRequest extends FormRequest
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
            'value' => 'required|max:255',
        ];

    }
    public function messages()
    {
        return [

            'value.required' => 'Giá trị là bắt buộc.',
            'value.max' => 'Giá trị không được vượt quá 255 ký tự.',
        ];
    }
}
