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
    const DANG_XU_LY = 'Đang xử lý';
    const DA_GIAO = 'Đã giao';
    const DA_HUY = 'Đã hủy';

    public function orders()
    {
        return $this->hasMany(Order::class, 'status_donhang_id');
    }
}
