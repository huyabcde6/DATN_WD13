<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categories extends Model
{
    use HasFactory;

<<<<<<< HEAD

    protected $table = 'categories';


    protected $fillable = ['name', 'slug', 'status'];

    public function products()
    {
        return $this->hasMany(products::class, 'categories_id', 'id');
=======
    protected $table = 'categories';

    public function products()
    {
        return $this->hasMany(products::class);
>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19
    }
}
