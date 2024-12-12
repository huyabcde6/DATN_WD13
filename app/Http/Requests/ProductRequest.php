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
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'categories_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lte:price',
            'stock_quantity' => 'required|integer|min:0',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'avata' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'variant_quantity.*.*' => 'required|integer|min:0',
            'variant_price.*.*' => 'nullable|numeric|min:0',
            'variant_discount_price.*.*' => 'nullable|numeric|min:0|lte:variant_price.*.*',
            'variant_image.*.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được để trống',
            'name.string' => 'Tên phải là chuỗi',
            'name.max' => 'Tên không vượt qua 255 ký tự',
            'slug.string' => 'Slug phải là chuỗi',
            'slug.max' => 'Slug không vượt qua 255 ký tự',
            'categories_id.required' => 'Danh mục không được để trống',
            'categories_id.exists' => 'Danh mục không tồn tại',
            'price.required' => 'Giá không được để trống',
            'price.numeric' => 'Giá phải là số',
            'price.min' => 'Giá phải lớn hơn hoặc bằng 0',
            'discount_price.numeric' => 'Giá khuyến mãi phải là số',
            'discount_price.min' => 'Giá khuyến mãi phải lớn hơn hoặc bằng 0',
            'discount_price.lte' => 'Giá khuyến mãi phải nhỏ hơn hoặc bằng giá gốc',
            'stock_quantity.required' => 'Số lượng không được để trống',
            'stock_quantity.integer' => 'Số lượng phải là số nguyên',
            'stock_quantity.min' => 'Số lượng phải lớn hơn hoặc bằng 0',
            'short_description.string' => 'Mô tả ngắn phải là chuỗi',
            'short_description.max' => 'Mô tả ngắn không vượt qua 500 ký tự',
            'description.string' => 'Mô tả phải là chuỗi',
            'avata.image' => 'Ảnh đại diện phải là hình ảnh',
            'avata.mimes' => 'Ảnh đại diện phải có định dạng jpeg, png, jpg, gif',
            'avata.max' => 'Ảnh đại diện không vượt quá 2MB',
            'images.*.image' => 'Hình ảnh phải là hình ảnh',
            'images.*.mimes' => 'Hình ảnh phải có định dạng jpeg, png, jpg, gif',
            'images.*.max' => 'Hình ảnh không vượt quá 2MB',
            'variant_quantity.*.*.required' => 'Số lượng không được để trống',
            'variant_quantity.*.*.integer' => 'Số lượng phải là số nguyên',
            'variant_quantity.*.*.min' => 'Số lượng phải lớn hơn hoặc bằng 0',
            'variant_price.*.*.numeric' => 'Giá phải là số',
            'variant_price.*.*.min' => 'Giá phải lớn hơn hoặc bằng 0',
            'variant_discount_price.*.*.lte' => 'Giá khuyến mãi phải nhỏ hơn hoặc bằng giá gốc',
            'variant_discount_price.*.*.min' => 'Giá khuyến mãi phải lớn hơn hoặc bằng 0',
            'variant_image.*.*.image' => 'Hình ảnh phải là hình ảnh',
            'variant_image.*.*.mimes' => 'Hình ảnh phải có định dạng jpeg, png, jpg, gif',
            'variant_image.*.*.max' => 'Hình ảnh không vượt quá 2MB',
        ];
    }
}
