<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
<<<<<<< HEAD
    protected $fillable = [
        'title',
        'description',
        'avata',
        'detail',
        'view',
        'new_date',
        'created_at',
        'updated_at',

    ];
    protected $casts = [
        'status' => 'boolean',
    ];
=======

    protected $fillable = ['title', 'content']; // Các trường có thể điền
>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19
}
