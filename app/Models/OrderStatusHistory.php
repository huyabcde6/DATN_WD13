<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatusHistory extends Model
{
    use HasFactory;

    protected $table = 'order_status_histories';

    protected $fillable = [
        'order_id',
        'previous_status_id',
        'current_status_id',
        'changed_at',
        'changed_by',
    ];

    // Relationship với Order
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    // Relationship với User (người thay đổi)
    public function user()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    // Relationship với trạng thái trước
    public function previousStatus()
    {
        return $this->belongsTo(StatusDonhang::class, 'previous_status_id');
    }

    // Relationship với trạng thái sau
    public function currentStatus()
    {
        return $this->belongsTo(StatusDonhang::class, 'current_status_id');
    }
}
