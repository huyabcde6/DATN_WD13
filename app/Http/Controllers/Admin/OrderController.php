<?php

namespace App\Http\Controllers\Admin;

use App\Events\OderEvent;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\StatusDonHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Events\OrderUpdated;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('status')->paginate(7);
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['orderDetails.productDetail.products', 'status'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $order = Order::findOrFail($id);

            $statusId = $request->input('status');

            if ($statusId && is_numeric($statusId)) {
                if ($order->status_donhang_id == 1 && in_array($statusId, [2, 5])) {
                    $order->status_donhang_id = $statusId;
                } elseif ($order->status_donhang_id == 2 && $statusId == 3) {
                    $order->status_donhang_id = $statusId;
                } elseif ($order->status_donhang_id == 3 && $statusId == 4) {
                    $order->status_donhang_id = $statusId;
                } else {
                    return redirect()->route('admin.orders.index')->with('error', 'Không thể chuyển trạng thái theo quy định.');
                }
                $order->update();
                broadcast(new OderEvent(Order::findOrFail($id)));
            }

            DB::commit();

            return redirect()->route('admin.orders.index')->with('success', 'Đơn hàng đã được cập nhật thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Order update error: ' . $e->getMessage());
            return redirect()->route('admin.orders.index')->with('error', 'Có lỗi xảy ra trong quá trình cập nhật đơn hàng: ' . $e->getMessage());
        }
    }
}
