<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Attribute extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = ['name', 'slug'];

    public function sluggable(): array
    {   
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }
}
