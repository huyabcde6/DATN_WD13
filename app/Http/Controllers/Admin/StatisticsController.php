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
use App\Models\product;
use App\Models\product_varianit;
use App\Models\InvoiceDetail;

class StatisticsController extends Controller
{
    public function index(Request $request)
    {
        // Lấy giá trị ngày bắt đầu và ngày kết thúc từ request
        $startDate = $request->input('start_date'); // Ngày bắt đầu
        $endDate = $request->input('end_date'); // Ngày kết thúc

        // Tổng doanh thu tháng (từ bảng Invoice)
        $revenue = Invoice::whereMonth('date_invoice', Carbon::now()->month)
                            ->whereYear('date_invoice', Carbon::now()->year)
                            ->sum('total_price');

        $dailyRevenue = Invoice::whereDate('date_invoice', Carbon::today())
                            ->sum('total_price');

        $totalProducts = product::count();

        $totalOrders = Order::whereMonth('created_at', Carbon::now()->month)
                                ->whereYear('created_at', Carbon::now()->year)
                                ->count();

        $topProducts = Product::select(
                'products.id',
                'products.name',
                'products.avata',
                'products.discount_price',
                'categories.name as category_name',
                DB::raw('SUM(order_details.quantity) as total_sold')
            )
            ->join('categories', 'categories.id', '=', 'products.categories_id') // Liên kết với danh mục
            ->join('product_variants', 'products.id', '=', 'product_variants.product_id') // Liên kết với ProductVariant
            ->join('order_details', 'product_variants.id', '=', 'order_details.product_variant_id') // Liên kết với OrderDetail
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('order_details.created_at', [$startDate, $endDate]);
            })
            ->groupBy(
                'products.id',
                'products.name',
                'products.avata',
                'products.discount_price',
                'categories.name'
            )
            ->orderByDesc('total_sold') // Sắp xếp theo số lượng bán
            ->take(5) // Lấy top 5 sản phẩm
            ->get();


        // Truy vấn Top Customers
        $topCustomers = Order::select('orders.user_id', 
                        DB::raw('COUNT(orders.id) as total_orders'),
                        DB::raw('SUM(orders.total_price) as total_spent'))
                        ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                            return $query->whereBetween('orders.created_at', [$startDate, $endDate]);
                        })
                        ->where('orders.payment_status', 'đã thanh toán')
                        ->groupBy('orders.user_id')
                        ->orderByDesc('total_orders')
                        ->take(5)
                        ->get();

        // Truy vấn các đơn hàng chờ xác nhận
        $pendingOrders = Order::where('status_donhang_id', '1')
                        ->orderBy('created_at', 'desc')
                        ->take(5)
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