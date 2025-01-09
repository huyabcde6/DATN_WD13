<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
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
            'code' => 'required|string|max:255|unique:coupons,code',
            'discount_value' => 'required|numeric|min:1|max:99', // Giá trị giảm tối thiểu là 1, tối đa là 100%
            'max_discount_amount' => 'nullable|numeric|min:1|max:99999999', // Giới hạn tối đa 1 tỷ (tùy chỉnh theo DB)
            'min_order_amount' => 'nullable|numeric|min:1|max:99999999', // Giới hạn tối đa 1 tỷ (tùy chỉnh theo DB)
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'total_quantity' => 'required|integer|min:1|max:1000000', // Giới hạn số lượng mã giảm giá
            'status' => 'required|in:active,disabled',
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Mã giảm giá không được để trống.',
            'code.unique' => 'Mã giảm giá đã tồn tại, vui lòng nhập mã khác.',
            'discount_value.required' => 'Giá trị giảm là bắt buộc.',
            'discount_value.numeric' => 'Giá trị giảm phải là một số.',
            'discount_value.min' => 'Giá trị giảm phải lớn hơn hoặc bằng 1.',
            'discount_value.max' => 'Giá trị giảm không được lớn hơn 99%.',
            'max_discount_amount.numeric' => 'Giảm tối đa phải là số.',
            'min_order_amount.numeric' => 'Đơn hàng tối thiểu phải là số.',
            'min_order_amount.min' => 'Giá trị đơn hàng tối thiểu phải lớn hơn 0',
            'start_date.required' => 'Ngày bắt đầu là bắt buộc.',
            'start_date.after_or_equal' => 'Ngày bắt đầu phải từ hôm nay trở đi.',
            'end_date.required' => 'Ngày kết thúc là bắt buộc.',
            'end_date.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',
            'total_quantity.required' => 'Số lượng mã là bắt buộc.',
            'total_quantity.integer' => 'Số lượng mã phải là số nguyên.',
            'total_quantity.min' => 'Số lượng mã phải lớn hơn 0.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái không hợp lệ.',
            'min_order_amount.numeric' => 'Đơn hàng tối thiểu phải là một số hợp lệ.',
            'min_order_amount.min' => 'Đơn hàng tối thiểu không được nhỏ hơn 0.',
            'min_order_amount.max' => 'Đơn hàng tối thiểu không được lớn hơn 99 triệu.',
            'max_discount_amount.max' => 'Giảm tối đa không được lớn hơn 99 triệu.',
            'total_quantity.max' => 'Số lượng mã không được vượt quá 1 triệu.',
        ];
    }
}
