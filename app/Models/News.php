<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
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
}
