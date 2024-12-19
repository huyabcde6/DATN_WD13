<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|lt:price|min:0',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'categories_id' => 'required|exists:categories,id',
            'is_show' => 'required|boolean',
            'is_new' => 'nullable|boolean',
            'is_hot' => 'nullable|boolean',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên sản phẩm là bắt buộc.',
            'price.required' => 'Giá sản phẩm là bắt buộc.',
            'price.numeric' => 'Giá sản phẩm phải là số.',
            'discount_price.lt' => 'Giá khuyến mãi phải nhỏ hơn giá sản phẩm.',
            'categories_id.required' => 'Danh mục là bắt buộc.',
            'categories_id.exists' => 'Danh mục không hợp lệ.',

        ];
    }
}
