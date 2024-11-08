<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productComment extends Model
{
    use HasFactory;

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
}
