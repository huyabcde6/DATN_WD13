<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'unique:permissions,name,' . $this->route('id')
            ]
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên quyền',
            'name.string' => 'Quyền phải là chữ',
            'name.unique' => 'Quyền đã tồn tại'
        ];
    }
}
