<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
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

=======

class ProductDetail extends Model
{
    use HasFactory;

    protected $table = 'product_details';

>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19
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

<<<<<<< HEAD
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
=======
>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19

}
