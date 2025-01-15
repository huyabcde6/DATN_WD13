<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttributeRequest extends FormRequest
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
        $id = $this->route('attribute') ? $this->route('attribute')->id : null;
        return [
            'name' => 'required|max:255|unique:attributes,name,' . $id,
        ];

    }
    public function messages()
    {
        return [
            'name.required' => 'Tên thuộc tính là bắt buộc.',
            'name.max' => 'Tên thuộc tính không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên thuộc tính này đã tồn tại. Vui lòng chọn tên khác.',
        ];
    }
}
