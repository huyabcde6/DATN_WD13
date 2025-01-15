<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'avata' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên sản phẩm là bắt buộc.',
            'price.required' => 'Giá sản phẩm là bắt buộc.',
            'price.numeric' => 'Giá sản phẩm phải là số.',
            'discount_price.lt' => 'Giá khuyến mãi phải nhỏ hơn giá sản phẩm.',
            'avata.image' => 'Ảnh sản phẩm phải là định dạng hình ảnh.',
            'avata.mimes' => 'Ảnh sản phẩm phải có định dạng jpeg, png, jpg, gif,svg, hoặc webp.',
        ];
    }
}
