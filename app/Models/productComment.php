<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'description',
        'images',
    ];  
    protected $casts = [
        'images' => 'array', // Tự động chuyển đổi JSON thành mảng PHP
    ];
    public function product() {
        return $this->belongsTo(product::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function getImageUrlsAttribute()
    {
        return collect($this->images)->map(function ($image) {
            return asset('storage/' . $image);
        });
    }
}
