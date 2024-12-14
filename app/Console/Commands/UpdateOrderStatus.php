<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use Carbon\Carbon;

class UpdateOrderStatus extends Command
{
    protected $signature = 'orders:update-status'; // Tên lệnh
    protected $description = 'Update order status to completed after 3 days if not confirmed by user';
    public function handle()
    {
        $orders = Order::where('status_donhang_id', 4) // Trạng thái "đã giao"
                       ->where('updated_at', '<=', Carbon::now()->subMinutes(1))
                       ->get();

        foreach ($orders as $order) {
            $order->status_donhang_id = 5;
            $order->payment_status = 'đã thanh toán'; // Cập nhật trạng thái "hoàn thành"
            $order->save();
            
            $this->moveOrderToInvoice($order);
        }

        $this->info('Order statuses updated successfully.');
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
            'payment_status' => $order->payment_status,
            'subtotal' => $order->subtotal,
            'discount' => $order->discount,
            'shipping_fee' => $order->shipping_fee,
            'total_price' => $order->total_price,
            'date_invoice' => $order->created_at,
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
