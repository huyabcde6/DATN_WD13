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
    public function rules(): array
    {
        return [
            'code' => 'required|string|unique:coupons,code',
            'discount_type' => 'required|string|in:percentage,fixed_amount',
            'discount_value' => 'required|numeric|min:0',
            'max_discount_amount' => 'required|numeric|min:0',
            'min_order_amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'total_quantity' => 'required|integer|min:1',
            'status' => 'required|string|in:active,disabled,disabled',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Mã coupon là bắt buộc.',
            'code.string' => 'Mã coupon phải là một chuỗi ký tự.',
            'code.unique' => 'Mã coupon này đã tồn tại.',
            'discount_type.required' => 'Loại giảm giá là bắt buộc.',
            'discount_type.string' => 'Loại giảm giá phải là một chuỗi ký tự.',
            'discount_type.in' => 'Loại giảm giá không hợp lệ. Chỉ có thể là "percentage" hoặc "fixed_amount".',
            'discount_value.required' => 'Giá trị giảm giá là bắt buộc.',
            'discount_value.numeric' => 'Giá trị giảm giá phải là một số.',
            'discount_value.min' => 'Giá trị giảm giá phải lớn hơn hoặc bằng 0.',
            'max_discount_amount.required' => 'Số tiền giảm tối đa là bắt buộc.',
            'max_discount_amount.numeric' => 'Số tiền giảm tối đa phải là một số.',
            'max_discount_amount.min' => 'Số tiền giảm tối đa phải lớn hơn hoặc bằng 0.',
            'min_order_amount.required' => 'Số tiền tối thiểu cho đơn hàng là bắt buộc.',
            'min_order_amount.numeric' => 'Số tiền tối thiểu cho đơn hàng phải là một số.',
            'min_order_amount.min' => 'Số tiền tối thiểu cho đơn hàng phải lớn hơn hoặc bằng 0.',
            'start_date.required' => 'Ngày bắt đầu là bắt buộc.',
            'start_date.date' => 'Ngày bắt đầu phải là một ngày hợp lệ.',
            'end_date.required' => 'Ngày kết thúc là bắt buộc.',
            'end_date.date' => 'Ngày kết thúc phải là một ngày hợp lệ.',
            'end_date.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',
            'total_quantity.required' => 'Số lượng tổng là bắt buộc.',
            'total_quantity.integer' => 'Số lượng tổng phải là một số nguyên.',
            'total_quantity.min' => 'Số lượng tổng phải lớn hơn hoặc bằng 1.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.string' => 'Trạng thái phải là một chuỗi ký tự.',
            'status.in' => 'Trạng thái không hợp lệ. Chỉ có thể là "active", "disabled".',
        ];
    }
}
