<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categories extends Model
{
    use HasFactory;


    protected $table = 'categories';
    protected $fillable = ['name', 'slug', 'status'];

    public function product()
    {
        return $this->hasMany(product::class, 'categories_id', 'id');
    }

    public function updateStatus($status)
    {
        // Cập nhật trạng thái danh mục
        $this->update(['status' => $status]);

        // Cập nhật trạng thái sản phẩm liên quan
        if ($status == 0) {
            // Ẩn tất cả sản phẩm trong danh mục này
            $this->products()->update(['iS_show' => false]);
        } else {
            // Chỉ hiện các sản phẩm đã được chọn là hiển thị
            $this->products()->where('iS_show', 1)->update(['iS_show' => true]);
        }
    }
}
