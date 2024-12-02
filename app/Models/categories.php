<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categories extends Model
{
    use HasFactory;

    protected $table = 'categories';

    // Cột cho phép gán giá trị
    protected $fillable = [
        'gioi_tinh',
        'name',
        'slug',
        'status',
    ];
    public function products()
    {
        return $this->hasMany(products::class);
    }
}
