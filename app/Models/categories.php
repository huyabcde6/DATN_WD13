<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categories extends Model
{
    use HasFactory;


    protected $table = 'categories';

<<<<<<< HEAD
    // Cột cho phép gán giá trị
    protected $fillable = [
        'gioi_tinh',
        'name',
        'slug',
        'status',
    ];
=======

    protected $fillable = ['name', 'slug', 'status'];

>>>>>>> 4b72ed8744930d28cd573ea23e4c9db00718596f
    public function products()
    {
        return $this->hasMany(products::class, 'categories_id', 'id');
    }
}
