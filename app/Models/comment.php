<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comment extends Model
{
    use HasFactory;
<<<<<<< HEAD

    protected $fillable = [
        'user_id',
        'products_id',
        'description',
        'image',
    ];  

    public function product() {
        return $this->belongsTo(products::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
=======
>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19
}
