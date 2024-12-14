<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StatusDonHang;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Invoice;
use App\Models\products;
use App\Models\InvoiceDetail;

class StatisticsController extends Controller
{
    public function index(Request $request)
    {
        // Tổng doanh thu tháng (từ bảng Invoice)
        $revenue = Invoice::whereMonth('date_invoice', Carbon::now()->month) // Lọc theo tháng hiện tại
                          ->whereYear('date_invoice', Carbon::now()->year)   // Lọc theo năm hiện tại
                          ->sum('total_price');  // Tính tổng giá trị 'total_price'

        $dailyRevenue = Invoice::whereDate('date_invoice', Carbon::today())  // Lọc theo ngày hôm nay
        ->sum('total_price');

        $totalProducts = products::count();

        $totalOrders = Order::whereMonth('created_at', Carbon::now()->month)  // Lọc theo tháng hiện tại
                            ->whereYear('created_at', Carbon::now()->year)   // Lọc theo năm hiện tại
                            ->count();

        $topProducts = products::select('products.id', 'products.name', 'products.avata', 'products.discount_price','categories.name as category_name', DB::raw('SUM(order_details.quantity) as total_sold'))
                        ->join('categories', 'categories.id', '=', 'products.categories_id')
                        ->join('product_details', 'products.id', '=', 'product_details.products_id') // Liên kết với bảng product_details
                        ->join('order_details', 'product_details.id', '=', 'order_details.product_detail_id') // Liên kết với bảng order_details
                        ->groupBy('products.id', 'products.name', 'products.avata', 'products.discount_price') // Gom nhóm theo sản phẩm gốc
                        ->orderByDesc('total_sold') // Sắp xếp giảm dần theo tổng số lượng bán ra
                        ->take(5) // Lấy 5 sản phẩm đầu tiên
                        ->get();
        
        $pendingOrders = Order::where('status_donhang_id', '1') // Lọc trạng thái 'chờ xác nhận'
                    ->orderBy('created_at', 'desc') // Sắp xếp theo ngày tạo mới nhất
                    ->take(5) // Lấy 5 đơn hàng đầu tiên
                    ->get();

        $topCustomers = Order::select('orders.user_id', 
                    DB::raw('COUNT(orders.id) as total_orders'), // Số lượng đơn hàng
                    DB::raw('SUM(orders.total_price) as total_spent')) // Tổng tiền chi tiêu từ trường total_price trong bảng orders
                    ->whereMonth('orders.created_at', Carbon::now()->month) // Lọc theo tháng hiện tại
                    ->whereYear('orders.created_at', Carbon::now()->year)  // Lọc theo năm hiện tại
                    ->where('orders.payment_status', 'đã thanh toán')  // Chỉ tính các đơn hàng đã thanh toán
                    ->groupBy('orders.user_id')
                    ->orderByDesc('total_orders')  // Sắp xếp theo số đơn hàng
                    ->take(5)  // Lấy 5 khách hàng đầu tiên
                    ->get();


        // Trả về dữ liệu cho view
        return view('admin.statistics.index', compact('revenue', 'dailyRevenue', 'totalProducts', 'totalOrders', 'topProducts', 'pendingOrders', 'topCustomers'));
    }
    public function getRevenueByYear(Request $request)
    {
        $year = $request->input('year', now()->year); // Lấy năm từ request, mặc định là năm hiện tại

        // Truy vấn doanh thu theo tháng trong năm
        $revenue = Order::selectRaw('MONTH(date_order) as month, SUM(total_price) as total')
            ->whereYear('date_order', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Trả dữ liệu dạng JSON
        return response()->json([
            'year' => $year,
            'revenue' => $revenue,
        ]);
    }

}