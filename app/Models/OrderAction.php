<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAction extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'order_id', 'product_id', 'action', 'comment', 'is_read'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(product::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
