<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $table = 'order_details';

    protected $fillable = [
        'order_id',
        'product_detail_id',
        'quantity',
        'color',
        'size',
        'price',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function productDetail()
    {
        return $this->belongsTo(ProductDetail::class);
    }

    public function products()
    {
        return $this->hasOneThrough(products::class, ProductDetail::class, 'id', 'id', 'product_detail_id', 'products_id');
    }
}
