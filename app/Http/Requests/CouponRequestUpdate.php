<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequestUpdate extends FormRequest
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
            'code' => 'required|string|max:255',
            'discount_type' => 'required|string|in:percentage',
            'discount_value' => 'required|numeric|min:1|max:99', // Giá trị giảm tối thiểu là 1, tối đa là 100%
            'max_discount_amount' => 'nullable|numeric|min:1|max:99999999', // Giảm tối đa không quá 99 triệu
            'min_order_amount' => 'nullable|numeric|min:1|max:99999999', // Đơn hàng tối thiểu không quá 99 triệu
            'start_date' => 'required|date|after_or_equal:today', // Ngày bắt đầu phải từ hôm nay trở đi
            'end_date' => 'required|date|after:start_date', // Ngày kết thúc phải sau ngày bắt đầu
            'total_quantity' => 'required|integer|min:1|max:1000000', // Số lượng mã giảm giá tối thiểu là 1
            'status' => 'required|in:active,disabled', // Trạng thái phải là 'active' hoặc 'disabled'
        ];
    }
    public function messages()
    {
        return [
            'code.required' => 'Mã giảm giá là bắt buộc.',
            'code.string' => 'Mã giảm giá phải là một chuỗi ký tự.',
            'code.max' => 'Mã giảm giá không được vượt quá 255 ký tự.',

            'discount_type.required' => 'Loại giảm giá là bắt buộc.',
            'discount_type.string' => 'Loại giảm giá phải là một chuỗi ký tự.',
            'discount_type.in' => 'Loại giảm giá phải là "percentage".',

            'discount_value.required' => 'Giá trị giảm là bắt buộc.',
            'discount_value.numeric' => 'Giá trị giảm phải là một số.',
            'discount_value.min' => 'Giá trị giảm phải lớn hơn hoặc bằng 1.',
            'discount_value.max' => 'Giá trị giảm không được lớn hơn 99%.',

            'max_discount_amount.numeric' => 'Số tiền giảm tối đa phải là một số.',
            'max_discount_amount.min' => 'Số tiền giảm tối đa phải lớn hơn 0.',
            'max_discount_amount.max' => 'Số tiền giảm tối đa không được vượt quá 99 triệu đồng.',

            'min_order_amount.numeric' => 'Số tiền tối thiểu phải là một số.',
            'min_order_amount.min' => 'Số tiền tối thiểu phải lớn hơn 1.',
            'min_order_amount.max' => 'Số tiền tối thiểu không được vượt quá 99 triệu đồng.',

            'start_date.required' => 'Ngày bắt đầu là bắt buộc.',
            'start_date.date' => 'Ngày bắt đầu phải là một ngày hợp lệ.',
            'start_date.after_or_equal' => 'Ngày bắt đầu phải là ngày hôm nay hoặc một ngày sau đó.',

            'end_date.required' => 'Ngày kết thúc là bắt buộc.',
            'end_date.date' => 'Ngày kết thúc phải là một ngày hợp lệ.',
            'end_date.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',

            'total_quantity.required' => 'Số lượng mã giảm giá là bắt buộc.',
            'total_quantity.integer' => 'Số lượng mã giảm giá phải là một số nguyên.',
            'total_quantity.min' => 'Số lượng mã giảm giá phải lớn hơn hoặc bằng 1.',
            'total_quantity.max' => 'Số lượng mã không được vượt quá 1 triệu.',

            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái phải là "active" hoặc "disabled".',
        ];
    }
}
