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

        $totalOrders = $orderStatuses->sum('orders_count');
        $orderStatuses->each(function ($status) use ($totalOrders) {
            $status->percentage = $totalOrders > 0 ? ($status->orders_count / $totalOrders) * 100 : 0;
        });

        $revenue = $query->
        where('payment_status', 'đã thanh toán')
        ->sum('total_price');

        $bestSellingProducts = OrderDetail::select('product_detail_id', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('product_detail_id')
            ->orderByDesc('total_quantity')
            ->with('productDetail.products')
            ->take(8)
            ->get();

        $dailyRevenue = $query->select(DB::raw('DATE(date_order) as date'), DB::raw('SUM(total_price) as total'))
            ->groupBy('date')
            ->orderByDesc('date')
            ->get();

        return view('admin.statistics.index', compact(
            'orderStatuses',
            'revenue',
            'bestSellingProducts',
            'dailyRevenue',
            'totalOrders'
        ));
    }
}
