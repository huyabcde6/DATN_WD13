<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product_details';

    protected $fillable = [
        'product_code',
        'products_id',
        'size_id',
        'color_id',
        'image',
        'is_active',
        'price',
        'discount_price',
        'quantity',
    ];  

    public function products()
    {
        return $this->belongsTo(products::class, 'products_id');
    }

    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id', 'size_id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id', 'color_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

}
