<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    const ROLE_ADMIN = 'Admin';
    const ROLE_USER = 'User';
    protected $fillable = [
        'name',
        'email',
        'password',
        'number_phone',
        'address',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function order()
    {
        return $this->hasMany(Order::class);
    }
    public function shifts()
    {
        return $this->belongsToMany(Shift::class, 'user_shift', 'user_id', 'shift_id')
            ->withPivot('assigned_date')
            ->withTimestamps();
    }
    public function reviews()
    {
        return $this->hasMany(productComment::class);
    }
}
