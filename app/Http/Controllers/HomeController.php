<?php

namespace App\Http\Controllers;

use App\Models\banner;
use App\Models\News;
use App\Models\product;
use Illuminate\Http\Request;
use App\Models\Voucher;
use Illuminate\Support\Facades\DB;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::where('status', 1)->get();
        $news = News::where('status', 1)->get();
        // Sản phẩm mới
        $newProducts = product::where('iS_new', 1)
            ->where('iS_show', 1)
            ->latest() // Sắp xếp theo ngày tạo mới nhất
            ->limit(8)->get(); // Hiển thị tối đa 8 sản phẩm

        // Sản phẩm bán chạy
        $bestSellingProducts = product::where('is_hot', true)
            ->where('is_show', true)
            ->limit(8)->get();

        // Sản phẩm sale
        $saleProducts = product::whereNotNull('discount_price')
            ->where('is_show', true)
            ->limit(8)->get();

        $coupons = Voucher::where('status', 1) // Chỉ lấy voucher hoạt động
            ->whereDate('start_date', '<=', now()) // Đang trong khoảng thời gian hợp lệ
            ->whereDate('end_date', '>=', now())
            ->get();


        return view('user.sanpham.home', compact('banners', 'coupons', 'newProducts', 'bestSellingProducts', 'saleProducts', 'news'));
    }
    public function getLatestNotifications()
    {
        $userId = Auth::id();
        $notifications = DB::table('order_status_histories')
            ->join('orders', 'order_status_histories.order_id', '=', 'orders.id') // Kết nối với bảng orders
            ->join('users', 'order_status_histories.changed_by', '=', 'users.id') // Kết nối với bảng users để lấy thông tin người thay đổi
            ->join('status_donhangs as current_status', 'order_status_histories.current_status_id', '=', 'current_status.id') // Kết nối với bảng status_donhangs để lấy trạng thái hiện tại
            ->leftJoin('status_donhangs as previous_status', 'order_status_histories.previous_status_id', '=', 'previous_status.id') // Kết nối trạng thái trước đó
            ->where('orders.user_id', $userId) // Lọc theo user_id
            ->orderBy('order_status_histories.created_at', 'desc') // Sắp xếp giảm dần theo thời gian
            ->take(5) // Lấy 5 bản ghi mới nhất
            ->select(
                'order_status_histories.*', // Chọn tất cả các cột từ bảng order_status_histories
                'orders.order_code', // Chọn mã đơn hàng từ bảng orders
                'orders.date_order', // Ngày đặt hàng
                'current_status.type as current_status', // Trạng thái hiện tại
                'previous_status.type as previous_status', // Trạng thái trước đó
                'users.name as changed_by_name' // Tên người thay đổi
            )
            ->get();



        return response()->json($notifications);
    }
}
