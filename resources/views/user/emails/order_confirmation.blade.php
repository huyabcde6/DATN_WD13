@component('mail::message')
# Cảm ơn bạn đã đặt hàng!

Đơn hàng của bạn đã được xác nhận với mã đơn hàng: **{{ $order->order_code }}**.

Tổng giá trị: **{{ number_format($order->total_price, 0, ',', '.') }} VNĐ**.

Chúng tôi sẽ liên hệ với bạn sớm nhất có thể.

Cảm ơn bạn!<br>
{{ config('app.name') }}
@endcomponent
