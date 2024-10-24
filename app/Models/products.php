<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'category_id',
        'avata',
        'description',
        'is_hot',
        'is_new',
        'is_show',
        'created_at',
        'updated_at',
        'price',
        'discount_price',
        'stock_quantity',
        'short_description',
    ];

    public function categories()
    {
        return $this->belongsTo(categories::class);
    }

    public function productDetails()
    {
        return $this->hasMany(ProductDetail::class, 'products_id');
    }


}
