<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;

class RevenueController extends Controller
{
    public function getRevenueByYear(Request $request)
{
    // Lấy năm và tháng từ request, mặc định là năm hiện tại và tháng không chọn
    $year = $request->input('year', now()->year);
    $month = $request->input('month');

    $revenue = [];

    if ($month) {
        // Nếu có tháng, lấy doanh thu theo ngày trong tháng
        $daysInMonth = now()->year($year)->month($month)->daysInMonth;

        $dailyRevenue = Invoice::selectRaw('DAY(date_invoice) as day, SUM(total_price) as total')
            ->whereYear('date_invoice', $year)
            ->whereMonth('date_invoice', $month)
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $revenue = array_fill(1, $daysInMonth, 0);

        foreach ($dailyRevenue as $item) {
            $revenue[$item->day] = $item->total;
        }

        $revenue = array_map(function ($total, $day) {
            return [
                'day' => $day,
                'total' => $total,
            ];
        }, $revenue, array_keys($revenue));
    } else {
        // Nếu không có tháng, lấy doanh thu theo tháng
        $revenue = Invoice::selectRaw('MONTH(date_invoice) as month, SUM(total_price) as total')
            ->whereYear('date_invoice', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }

    return response()->json([
        'year' => $year,
        'revenue' => $revenue,
    ]);
}


}

