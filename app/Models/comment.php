<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'products_id',
        'description',
        'image',
        'is_hidden',
    ];  

    public function product() {
        return $this->belongsTo(products::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
}
