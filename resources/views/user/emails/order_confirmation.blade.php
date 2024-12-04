@component('mail::message')
# Cảm ơn bạn đã đặt hàng!

Đơn hàng của bạn đã được xác nhận với mã đơn hàng: **{{ $order->order_code }}**.

<<<<<<< HEAD
Tổng giá trị: **{{ number_format($order->total_price, 0, ',', '.') }} VNĐ**.
=======
Tổng giá trị: **{{ $order->total_price }} VNĐ**.
>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19

Chúng tôi sẽ liên hệ với bạn sớm nhất có thể.

Cảm ơn bạn!<br>
{{ config('app.name') }}
<<<<<<< HEAD
@endcomponent
=======
@endcomponent
>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19
