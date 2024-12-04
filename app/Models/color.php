<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    protected $table = 'colors';

    protected $primaryKey = 'color_id';

<<<<<<< HEAD
    protected $fillable = ['value', 'color_code', 'status'];
    
=======
>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19
    public function productDetails()
    {
        return $this->hasMany(ProductDetail::class, 'color_id', 'color_id');
    }
}
