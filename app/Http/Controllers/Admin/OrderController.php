<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\StatusDonHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Events\OrderUpdated;
use Carbon\Carbon;
use App\Mail\OrderStatusChanged;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

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

            // Lấy trạng thái mới từ request
            $statusId = $request->input('status');

            if ($statusId && is_numeric($statusId)) {
                // Chuyển trạng thái đơn hàng theo quy định
                if ($order->status_donhang_id == 1 && in_array($statusId, [2, 7])) { // Chờ xác nhận -> Đã xác nhận, Hoàn hàng
                    $order->status_donhang_id = $statusId;
                } elseif ($order->status_donhang_id == 2 && $statusId == 3) { // Đã xác nhận -> Đang vận chuyển
                    $order->status_donhang_id = $statusId;
                } elseif ($order->status_donhang_id == 3 && $statusId == 4) { // Đang vận chuyển -> Đã giao hàng
                    $order->status_donhang_id = $statusId;
                } elseif ($order->status_donhang_id == 4 && in_array($statusId, [5, 8])) { // Đã giao hàng -> Hoàn thành, Chờ
                    $order->status_donhang_id = $statusId;
                } elseif ($order->status_donhang_id == 5) { // Hoàn thành không thể thay đổi trạng thái
                    return redirect()->route('admin.orders.index')->with('error', 'Đơn hàng đã hoàn thành và không thể thay đổi trạng thái.');
                }elseif ($order->status_donhang_id == 8 && $statusId == 6) { // Chờ xác nhận hoàn hàng -> Hoàn hàng
                    $order->status_donhang_id = $statusId;
                }else {
                    return redirect()->route('admin.orders.index')->with('error', 'Không thể chuyển trạng thái theo quy định.');
                }

                // Lưu đơn hàng và gửi sự kiện cập nhật
                $order->save();
                event(new OrderUpdated($order)); 
                Mail::to(Auth::user()->email)->send(new OrderStatusChanged($order));
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