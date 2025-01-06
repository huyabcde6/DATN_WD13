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
        'product_name',
        'product_avata',
        'product_variant_id', // Cột mới thay thế product_detail_id
        'quantity',
        'attributes', // Cột JSON để lưu các thuộc tính động
        'price',
    ];

    protected $casts = [
        'attributes' => 'array',
    ];
    

    /**
     * Quan hệ với model Order.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Quan hệ với model ProductVariant.
     */
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
    // App\Models\OrderDetail.php
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

}
