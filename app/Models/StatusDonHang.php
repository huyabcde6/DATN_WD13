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
    const DA_HUY = 'Đã hủy';

    public function orders()
    {
        return $this->hasMany(Order::class, 'status_donhang_id');
    }
    public static function getIdByType($type)
    {
        return self::where('type', $type)->value('id');
    }
}
