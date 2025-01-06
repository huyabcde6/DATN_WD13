<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
        'return_reason',
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

    public function product()
    {
        return $this->hasManyThrough(product::class, OrderDetail::class, 'order_id', 'id', 'id', 'products_id');
    }
    public function invoice()
    {
        return $this->hasOne(\App\Models\Invoice::class);
    }
    public function toInvoice()
    {

        // Tạo hóa đơn
        $invoice = Invoice::create([
            'order_code'     => $this->order_code,
            'order_id'       => $this->id,
            'user_id'        => $this->user_id,
            'nguoi_nhan'     => $this->nguoi_nhan,
            'email'          => $this->email,
            'number_phone'   => $this->number_phone,
            'address'        => $this->address,
            'status_donhang_id' => $this->status_donhang_id,
            'ghi_chu'        => $this->ghi_chu,
            'method'         => $this->method,
            'payment_status' => $this->payment_status,
            'subtotal'       => $this->subtotal,
            'discount'       => $this->discount,
            'shipping_fee'   => $this->shipping_fee,
            'total_price'    => $this->total_price,
            'date_invoice'   => $this->created_at,
        ]);

        // Lưu chi tiết hóa đơn
        foreach ($this->orderDetails as $orderDetail) {
            $invoice->invoiceDetails()->create([
                'product_name'  => $orderDetail->product_name,
                'product_avata'  => $orderDetail->product_avata,
                'attributes'    => is_string($orderDetail->attributes) 
                                    ? json_decode($orderDetail->attributes, true) 
                                    : $orderDetail->attributes,
                'quantity'      => $orderDetail->quantity,
                'price'         => $orderDetail->price,
            ]);
        }

        return $invoice;
    }


    public function invoiceDetails()
    {
        return $this->hasMany(InvoiceDetail::class);
    }
    public function statusHistories()
    {
        return $this->hasMany(OrderStatusHistory::class);
    }
}
