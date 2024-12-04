<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
<<<<<<< HEAD
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
=======

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19

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
<<<<<<< HEAD
        'number_phone',
        'address'
=======
>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19
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
<<<<<<< HEAD

    public function order(){
        return $this->hasMany(Order::class);
    }
=======
>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19
}
