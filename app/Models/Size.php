<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;
    protected $table = 'sizes';

    protected $primaryKey = 'size_id';
    
    public function productDetails()
    {
        return $this->hasMany(ProductDetail::class, 'size_id', 'size_id');
    }
}
