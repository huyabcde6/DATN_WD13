<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupons extends Model
{
    use HasFactory;
    protected $table = 'coupons';

    /**
     * Các cột có thể được gán giá trị
     */
    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'max_discount_amount',
        'min_order_amount',
        'start_date',
        'end_date',
        'total_quantity',
        'status',
    ];

    /**
     * Định dạng dữ liệu cho các cột kiểu thời gian
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * Quan hệ: Một Coupon có nhiều điều kiện áp dụng
     */
    public function conditions()
    {
        return $this->hasMany(Coupon_Conditions::class, 'coupon_id');
    }
}
