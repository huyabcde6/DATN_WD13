<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;

class RevenueController extends Controller
{
    public function getRevenueByYear(Request $request)
    {
        // Lấy năm từ request, mặc định là năm hiện tại
        $year = $request->input('year', now()->year);

        // Truy vấn doanh thu theo từng tháng trong bảng invoices
        $revenue = Invoice::selectRaw('MONTH(date_invoice) as month, SUM(total_price) as total')
            ->whereYear('date_invoice', $year) // Lọc theo năm
            ->groupBy('month') // Nhóm theo tháng
            ->orderBy('month') // Sắp xếp theo tháng
            ->get();

        return response()->json([
            'year' => $year,
            'revenue' => $revenue,
        ]);
    }

}
