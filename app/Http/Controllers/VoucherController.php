<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    // Hiển thị danh sách voucher
    public function index()
    {
        $coupons = Voucher::where('status', 1) // Chỉ lấy voucher hoạt động
            ->whereDate('start_date', '<=', now()) // Đang trong khoảng thời gian hợp lệ
            ->whereDate('end_date', '>=', now())
            ->get();

        return view('user.sanpham.vouchers', compact('coupons'));
    }
}
