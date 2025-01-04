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
        $couponId = $this->route('coupon');
        return [
            'code' => [
            'required',
            'string',
            $couponId ? 'unique:coupons,code,' . $couponId : 'unique:coupons,code',
        ],
            'discount_type' => 'required|string|in:percentage,fixed_amount',
            'discount_value' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) {
                    $discountType = request('discount_type');
                    $maxDiscountAmount = request('max_discount_amount');

                    // Validate for percentage type
                    if ($discountType === 'percentage' && ($value < 0 || $value > 100)) {
                        $fail('Giá trị giảm giá phải nằm trong khoảng từ 0 đến 100 khi loại giảm giá là phần trăm.');
                    }

                    // Validate for fixed amount type
                    if ($discountType === 'fixed_amount') {
                        if ($value < 0) {
                            $fail('Giá trị giảm giá phải lớn hơn hoặc bằng 0 khi loại giảm giá là số tiền cố định.');
                        }

                        if (!is_null($maxDiscountAmount) && $value < $maxDiscountAmount) {
                            $fail('Giá trị giảm giá phải lớn hơn hoặc bằng số tiền giảm tối đa khi loại giảm giá là số tiền cố định.');
                        }
                    }
                },
            ],
            'max_discount_amount' => 'required|numeric|min:0',
            'min_order_amount' => 'required|numeric|min:0',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'total_quantity' => 'required|integer|min:1',
            'status' => 'required|string|in:active,disabled',
        ];
    }
    public function messages(): array
    {
        return [
            // Validate mã giảm giá
            'code.required' => 'Mã coupon là bắt buộc.',
            'code.string' => 'Mã coupon phải là một chuỗi ký tự.',
            'code.unique' => 'Mã coupon này đã tồn tại.',

            // Validate loại giảm giá
            'discount_type.required' => 'Loại giảm giá là bắt buộc.',
            'discount_type.string' => 'Loại giảm giá phải là một chuỗi ký tự.',
            'discount_type.in' => 'Loại giảm giá không hợp lệ. Chỉ có thể là "Phần trăm" hoặc "Số tiền cố định".',

            // Validate giá trị giảm giá
            'discount_value.required' => 'Giá trị giảm giá là bắt buộc.',
            'discount_value.numeric' => 'Giá trị giảm giá phải là một số.',
            'discount_value.between' => 'Giá trị giảm giá phải nằm trong khoảng từ 0 đến 100 khi loại giảm giá là "Phần trăm".',
            'discount_value.min' => 'Giá trị giảm giá phải lớn hơn hoặc bằng 0 khi loại giảm giá là "Số tiền cố định".',
            'discount_value.custom_rule' => 'Giá trị giảm giá phải lớn hơn hoặc bằng số tiền giảm tối đa khi loại giảm giá là "Số tiền cố định".',

            // Validate số tiền giảm tối đa
            'max_discount_amount.required' => 'Số tiền giảm tối đa là bắt buộc.',
            'max_discount_amount.numeric' => 'Số tiền giảm tối đa phải là một số.',
            'max_discount_amount.min' => 'Số tiền giảm tối đa phải lớn hơn hoặc bằng 0.',

            // Validate số tiền tối thiểu cho đơn hàng
            'min_order_amount.required' => 'Số tiền tối thiểu cho đơn hàng là bắt buộc.',
            'min_order_amount.numeric' => 'Số tiền tối thiểu cho đơn hàng phải là một số.',
            'min_order_amount.min' => 'Số tiền tối thiểu cho đơn hàng phải lớn hơn hoặc bằng 0.',

            // Validate ngày bắt đầu
            'start_date.required' => 'Ngày bắt đầu là bắt buộc.',
            'start_date.date' => 'Ngày bắt đầu phải là một ngày hợp lệ.',
            'start_date.before_or_equal' => 'Ngày bắt đầu phải nhỏ hơn hoặc bằng ngày kết thúc.',

            // Validate ngày kết thúc
            'end_date.required' => 'Ngày kết thúc là bắt buộc.',
            'end_date.date' => 'Ngày kết thúc phải là một ngày hợp lệ.',
            'end_date.after_or_equal' => 'Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu.',

            // Validate số lượng tổng
            'total_quantity.required' => 'Số lượng tổng là bắt buộc.',
            'total_quantity.integer' => 'Số lượng tổng phải là một số nguyên.',
            'total_quantity.min' => 'Số lượng tổng phải lớn hơn hoặc bằng 1.',

            // Validate trạng thái
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.string' => 'Trạng thái phải là một chuỗi ký tự.',
            'status.in' => 'Trạng thái không hợp lệ. Chỉ có thể là "active" hoặc "disabled".',
        ];
    }
}