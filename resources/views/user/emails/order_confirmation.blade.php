@component('mail::message')
# Cảm ơn bạn đã đặt hàng!

Đơn hàng của bạn đã được xác nhận với mã đơn hàng: **{{ $order->order_code }}**.

Tổng giá trị: **{{ $order->total_price }} VNĐ**.

Chúng tôi sẽ liên hệ với bạn sớm nhất có thể.

Cảm ơn bạn!<br>
{{ config('app.name') }}
@endcomponent