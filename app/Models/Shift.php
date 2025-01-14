<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'start_time', 'end_time'];

    // Quan hệ với User
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_shift', 'shift_id', 'user_id')
                    ->withPivot('assigned_date')
                    ->withTimestamps();
    }
}
