<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusDonHang extends Model
{
    use HasFactory;

    protected $table = 'status_donhangs';

    protected $primaryKey = 'id';

    protected $fillable = ['type'];

    const CHO_XAC_NHAN = 'Chờ xác nhận';
    const DA_XAC_NHAN = 'Đã xác nhận';
    const DANG_VAN_CHUYEN = 'Đang vận chuyển';
    const DA_GIAO_HANG = 'Đã giao hàng';
    const HOAN_THANH = 'Hoàn thành';
    const HOAN_HANG = 'Hoàn hàng';
    const DA_HUY = 'Đã hủy';
    const CHO_HOAN = 'Chờ hoàn';


    public function orders()
    {
        return $this->hasMany(Order::class, 'status_donhang_id');
    }
    public static function getIdByType($type)
    {
        return self::where('type', $type)->value('id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'status_donhang_id');
    }

    public function getStatusColor()
    {
        $colors = [
            'Chờ xác nhận' => 'bg-primary',
            'Đã xác nhận' => 'bg-primary',
            'Đang vận chuyển' => 'bg-primary',
            'Đã giao hàng' => 'bg-primary',
            'Hoàn thành' => 'bg-success',
            'Hoàn hàng' => 'bg-danger',
            'Đã hủy' => 'bg-danger',
            'Chờ hoàn' => 'bg-warning',
        ];

        return $colors[$this->type] ?? 'bg-light';
    }
    public function previousStatusHistories()
    {
        return $this->hasMany(OrderStatusHistory::class, 'previous_status_id');
    }

    public function currentStatusHistories()
    {
        return $this->hasMany(OrderStatusHistory::class, 'current_status_id');
    }
}
