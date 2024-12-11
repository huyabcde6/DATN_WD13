<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StatusDonHang;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function index(Request $request)
    {
        // Nhận filter từ request
        $filter = $request->query('filter');
        $query = Order::query();

        // Lọc theo khoảng thời gian
        if ($filter === 'day') {
            $query->whereDate('date_order', Carbon::today());
        } elseif ($filter === 'week') {
            $query->whereBetween('date_order', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        } elseif ($filter === 'month') {
            $query->whereMonth('date_order', Carbon::now()->month)
                  ->whereYear('date_order', Carbon::now()->year);
        } elseif ($filter === 'year') {
            $query->whereYear('date_order', Carbon::now()->year);
        }
        
        // Lấy tổng số đơn hàng hiện tại
        $currentTotalOrders = $query->count();

        // Lấy tổng số đơn hàng trong khoảng thời gian trước đó (ví dụ, ngày hôm qua, tuần trước, tháng trước)
        $previousQuery = Order::query();
        if ($filter === 'day') {
            $previousQuery->whereDate('date_order', Carbon::yesterday());
        } elseif ($filter === 'week') {
            $previousQuery->whereBetween('date_order', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]);
        } elseif ($filter === 'month') {
            $previousQuery->whereMonth('date_order', Carbon::now()->subMonth()->month)
                        ->whereYear('date_order', Carbon::now()->subMonth()->year);
        } elseif ($filter === 'year') {
            $previousQuery->whereYear('date_order', Carbon::now()->subYear()->year);
        }

        $previousTotalOrders = $previousQuery->count();

        // Tính phần trăm tăng trưởng
        $growthPercentage = 0;
        if ($previousTotalOrders > 0) {
            $growthPercentage = (($currentTotalOrders - $previousTotalOrders) / $previousTotalOrders) * 100;
        }

        // Lấy trạng thái đơn hàng với số lượng đơn hàng theo trạng thái
        $orderStatuses = StatusDonHang::withCount(['orders' => function ($q) use ($filter) {
            if ($filter === 'day') {
                $q->whereDate('date_order', Carbon::today());
            } elseif ($filter === 'week') {
                $q->whereBetween('date_order', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            } elseif ($filter === 'month') {
                $q->whereMonth('date_order', Carbon::now()->month)
                  ->whereYear('date_order', Carbon::now()->year);
            } elseif ($filter === 'year') {
                $q->whereYear('date_order', Carbon::now()->year);
            }
        }])->get();

        // Tính phần trăm của mỗi trạng thái đơn hàng
        $totalOrders = $orderStatuses->sum('orders_count');
        $orderStatuses->each(function ($status) use ($totalOrders) {
            $status->percentage = $totalOrders > 0 ? ($status->orders_count / $totalOrders) * 100 : 0;
        });

        // Tính doanh thu tổng
        $revenue = $query->where('payment_status', 'đã thanh toán')->sum('total_price');

        // Lấy các sản phẩm bán chạy nhất
        $bestSellingProducts = OrderDetail::select('product_detail_id', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('product_detail_id')
            ->orderByDesc('total_quantity')
            ->with('productDetail.products')
            ->take(8)
            ->get();

        // Lấy doanh thu theo ngày
        $dailyRevenue = $query->select(DB::raw('DATE(date_order) as date'), DB::raw('SUM(total_price) as total'))
            ->groupBy('date')
            ->orderByDesc('date')
            ->get();

        // Trả về view với dữ liệu cần thiết
        return view('admin.statistics.index', compact(
            'orderStatuses',
            'revenue',
            'bestSellingProducts',
            'dailyRevenue',
            'totalOrders',
            'growthPercentage'
        ));
    }
}


