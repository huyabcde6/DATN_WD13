<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function repeatCustomerRate(Request $request)
    {
        $year = $request->input('year', Carbon::now()->year);
        $monthRange = range(1, 12); // Các tháng từ 1 đến 12
    
        $repeatCustomerRate = [];
    
        foreach ($monthRange as $month) {
            // Lấy tất cả khách hàng đã mua hàng trong tháng đó
            $newCustomers = Order::select('user_id')
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->distinct()
                ->get()
                ->pluck('user_id')
                ->toArray();
    
            // Lấy những khách hàng trong tháng đó đã quay lại mua hàng trong tháng tiếp theo
            $repeatCustomers = Order::select('user_id')
                ->whereIn('user_id', $newCustomers) // Lọc khách hàng đã mua trong tháng đó
                ->whereYear('created_at', $year) // Kiểm tra trong năm đó
                ->whereMonth('created_at', '>', $month) // Chỉ tính những khách hàng mua sau tháng đó
                ->distinct()
                ->get()
                ->pluck('user_id')
                ->toArray();
    
            // Tính tỷ lệ khách hàng quay lại
            $repeatCustomerCount = count($repeatCustomers);
            $newCustomerCount = count($newCustomers);
    
            // Nếu không có khách hàng mới trong tháng, tỷ lệ quay lại là 0
            $repeatRate = $newCustomerCount > 0 ? ($repeatCustomerCount / $newCustomerCount) * 100 : 0;
    
            // Lưu kết quả tỷ lệ khách hàng quay lại theo tháng
            $repeatCustomerRate[] = [
                'month' => Carbon::createFromDate($year, $month, 1)->format('F'), // Chuyển tháng sang tên
                'repeat_rate' => $repeatRate,
                'new_customers' => $newCustomerCount,
                'repeat_customers' => $repeatCustomerCount
            ];
        }
    
        return response()->json($repeatCustomerRate);
    }
    
}
