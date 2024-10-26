<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    protected $table = 'colors';

    protected $primaryKey = 'color_id';

    public function productDetails()
    {
        return $this->hasMany(ProductDetail::class, 'color_id', 'color_id');
    }
}
