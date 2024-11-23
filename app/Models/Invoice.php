<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_code',
        'order_id',  // Liên kết trực tiếp với đơn hàng
        'user_id',
        'nguoi_nhan',
        'email',
        'number_phone',
        'address',
        'ghi_chu',
        'method',
        'subtotal',
        'discount',
        'shipping_fee',
        'total_price',
        'date_invoice',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);  // Liên kết với bảng 'orders'
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoiceDetails()
    {
        return $this->hasMany(InvoiceDetail::class);
    }
}
