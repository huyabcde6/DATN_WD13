<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;
    protected $table = 'sizes';

    protected $primaryKey = 'size_id';
<<<<<<< HEAD

    protected $fillable = ['value', 'status'];
=======
>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19
    
    public function productDetails()
    {
        return $this->hasMany(ProductDetail::class, 'size_id', 'size_id');
    }
}
