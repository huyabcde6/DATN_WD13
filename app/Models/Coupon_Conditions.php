<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon_Conditions extends Model
{
    use HasFactory;
    protected $table = 'couponconditions';

    /**
     * Các cột có thể được gán giá trị
     */
    protected $fillable = [
        'coupon_id',
        'product_id',
        'category_id',
    ];

    /**
     * Quan hệ: Điều kiện này thuộc về một Coupon
     */
    public function coupon()
    {
        return $this->belongsTo(Coupons::class, 'coupon_id');
    }
}
