<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequet extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->route('id'),
            'password' => 'required|string|min:8|max:20',
            'roles' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được để trống',
            'name.string' => 'Tên phải là chuỗi',
            'name.max' => 'Tên không vượt quá 255 ký tự',
            'password.required' => 'Password không được để trống',
            'password.string' => 'Password phải là chuỗi',
            'password.min' => 'Password phải có độ dài từ 8 đến 20 ký tự',
            'password.max' => 'Password phải có độ dài từ 8 đến 20 ký tự',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại',
            'email.max' => 'Email không được vượt qua 255 ký tự',
            'roles.required' => 'Vui lòng chọn vai trò'
        ];
    }
}
