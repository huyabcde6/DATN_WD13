<!DOCTYPE html>
<html>
<head>
    <title>Thông báo thay đổi trạng thái đơn hàng</title>
</head>
<body>
    <h2>Thông báo từ cửa hàng</h2>
    <p>Chúng tôi xin thông báo rằng trạng thái đơn hàng của bạn đã thay đổi:</p>
    <ul>
        <li>Mã đơn hàng: {{ $order->order_code}}</li>
        <li>Trạng thái mới: {{ $order->status->type }}</li>
    <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!</p> <!-- Giả sử bạn có quan hệ với bảng Status -->
    </ul>
    <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!</p>
</body>
</html>
