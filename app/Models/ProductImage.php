<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $table = 'product_images';

    protected $fillable = [
        'products_id',
        'image_path',
    ];


    public function products()
    {
        return $this->belongsTo(products::class, 'products_id');
    }
}
