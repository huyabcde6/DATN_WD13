<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Egulias\EmailValidator\Parser\Comment;

class products extends Model
{
    use HasFactory, SoftDeletes, Sluggable;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'slug',
        'categories_id',
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
    protected $casts = [
        'is_show' => 'boolean',
        'is_new' => 'boolean',
        'is_hot' => 'boolean',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function categories()
    {
        return $this->belongsTo(categories::class);
    }

    public function productDetails()
    {
        return $this->hasMany(ProductDetail::class, 'products_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
    public function productImages()
    {
        return $this->hasMany(ProductImage::class, 'products_id');
    }
    public function order() {
        return $this->hasMany(Order::class);
    }
    public function productComments() {
        return $this->hasMany(productComment::class);
    }
}
