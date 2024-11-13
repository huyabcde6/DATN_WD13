<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_code',
        'user_id',
        'date_order',
        'nguoi_nhan',
        'email',
        'number_phone',
        'address',
        'ghi_chu',
        'status_donhang_id',
        'method',
        'subtotal',
        'discount',
        'shipping_fee',
        'total_price',
        'payment_status',
    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(StatusDonHang::class, 'status_donhang_id');
    }

    public function products()
    {
        return $this->hasManyThrough(products::class, OrderDetail::class, 'order_id', 'id', 'id', 'products_id');
    }
}
