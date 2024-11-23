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
    private function moveOrderToInvoice(Order $order)
    {
        $invoiceCode = 'Invoice-' . Carbon::now()->format('Y-m-d') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        // Tạo bản ghi hóa đơn
        $invoiceCode = $order->order_code;
        \App\Models\Invoice::create([
            'invoice_code' => $invoiceCode,
            'order_code' => $order->order_code,
            'user_id' => $order->user_id,
            'date_order' => $order->date_order,
            'nguoi_nhan' => $order->nguoi_nhan,
            'email' => $order->email,
            'number_phone' => $order->number_phone,
            'address' => $order->address,
            'ghi_chu' => $order->ghi_chu,
            'method' => $order->method,
            'subtotal' => $order->subtotal,
            'discount' => $order->discount,
            'shipping_fee' => $order->shipping_fee,
            'total_price' => $order->total_price,
            'date_invoice' => Carbon::now(),
        ]);

        // Sao chép chi tiết đơn hàng sang bảng hóa đơn chi tiết
        foreach ($order->orderDetails as $detail) {
            \App\Models\InvoiceDetail::create([
                'invoice_id' => $order->id, // Chuyển ID hóa đơn mới
                'product_detail_id' => $detail->product_detail_id,
                'product_name'  => $orderDetail->product->name,
                'quantity' => $detail->quantity,
                'color' => $detail->color,
                'size' => $detail->size,
                'price' => $detail->price,
            ]);
        }  
    }        
}