<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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
            'title'         => 'required',
            'description'   => 'nullable',
            'image_path'    => 'required|image',
            'order'         => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Tiêu đề không được để trống',
            'image_path.required' => 'Ảnh không được để trống',
        ];
    }
}
