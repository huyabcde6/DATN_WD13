<?php

namespace App\Http\Controllers\Admin;

use App\Events\OderEvent;
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
    public function index(Request $request)
    {
        $query = Order::query();

        // Lọc theo ngày
        if ($request->has('from_date') && $request->from_date) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->has('to_date') && $request->to_date) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // Lọc theo trạng thái
        if ($request->has('status_donhang_id') && $request->status_donhang_id) {
            $query->where('status_donhang_id', $request->status_donhang_id);
        }

        // Lọc theo phương thức thanh toán
        if ($request->has('method') && $request->method) {
            $query->where('method', $request->method);
        }

        // Lọc theo trạng thái thanh toán
        if ($request->has('payment_status') && $request->payment_status) {
            $query->where('payment_status', $request->payment_status);
        }

        // Xử lý sắp xếp
        $validSortColumns = ['created_at', 'status_donhang_id', 'method', 'payment_status']; // Danh sách cột hợp lệ để sắp xếp
        $sortBy = in_array($request->get('sort_by'), $validSortColumns) ? $request->get('sort_by') : 'created_at'; // Chọn cột sắp xếp hợp lệ
        $sortOrder = $request->get('sort_order', 'asc') === 'desc' ? 'desc' : 'asc'; // Chỉ cho phép 'asc' hoặc 'desc'

        $query->orderBy($sortBy, $sortOrder);

        // Paginate kết quả
        $orders = $query->paginate(10);

        // Truyền các biến cần thiết vào view
        return view('admin.orders.index', [
            'orders' => $orders,
            'statuses' => StatusDonhang::all(),
            'sort_by' => $sortBy,  // Truyền lại tham số sắp xếp để giữ giá trị trong view
            'sort_order' => $sortOrder, // Truyền lại thứ tự sắp xếp
        ]);
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
                    if ($statusId == 5) {
                        $this->moveOrderToInvoice($order);
                    }
                } elseif ($order->status_donhang_id == 5) { // Hoàn thành không thể thay đổi trạng thái
                    return redirect()->route('admin.orders.index')->with('error', 'Đơn hàng đã hoàn thành và không thể thay đổi trạng thái.');
                }elseif ($order->status_donhang_id == 8 && $statusId == 6) { // Chờ xác nhận hoàn hàng -> Hoàn hàng
                    $order->status_donhang_id = $statusId;
                }else {
                    return redirect()->route('admin.orders.index')->with('error', 'Không thể chuyển trạng thái theo quy định.');
                }

   // Lưu đơn hàng và gửi sự kiện cập nhật
                $order->update();
                broadcast(new OderEvent(Order::findOrFail($id)));
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

    protected function moveOrderToInvoice(Order $order)
    {
        // Kiểm tra nếu hóa đơn đã tồn tại (tránh trùng lặp)
        if ($order->toInvoice()->exists()) {
            return;
        }

        $invoice = \App\Models\Invoice::create([
            'invoice_code' => $order->order_code,
            'user_id' => $order->user_id,
            'order_id' => $order->id,
            'nguoi_nhan' => $order->nguoi_nhan,
            'email' => $order->email,
            'number_phone' => $order->number_phone,
            'address' => $order->address,
            'status_donhang_id' => $order->status_donhang_id,
            'ghi_chu' => $order->ghi_chu,
            'method' => $order->method,
            'subtotal' => $order->subtotal,
            'discount' => $order->discount,
            'shipping_fee' => $order->shipping_fee,
            'total_price' => $order->total_price,
            'date_invoice' => now(),
        ]);

        // Sao chép chi tiết đơn hàng sang chi tiết hóa đơn
        foreach ($order->orderDetails as $orderDetail) {
            $invoice->invoiceDetails()->create([
                'product_name' => $orderDetail->productDetail->products->name,
                'color' => $orderDetail->color,
                'size' => $orderDetail->size,
                'quantity' => $orderDetail->quantity,
                'price' => $orderDetail->price,
            ]);
        }
    }

}
