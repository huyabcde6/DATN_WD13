<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    use HasFactory;

    protected $table = 'products';

    public function categories()
    {
        return $this->belongsTo(categories::class);
    }

    public function productDetails()
    {
        return $this->hasMany(ProductDetail::class, 'products_id');
    }


}
