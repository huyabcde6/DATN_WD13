<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'product_code', 'image', 'price', 'stock_quantity'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attributes()
    {
        return $this->hasMany(ProductVariantAttribute::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'product_variant_id');
    }

}
