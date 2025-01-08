<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo thay đổi trạng thái đơn hàng</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f9f9f9;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f9f9f9; margin: 0; padding: 0;">
        <tr>
            <td align="center" style="padding: 20px 0;">
                <table width="600px" cellpadding="0" cellspacing="0" border="0" style="background-color: #ffffff; border: 1px solid #ddd; border-radius: 8px; overflow: hidden;">
                    <!-- Header -->
                    <tr>
                        <td align="center" style="padding: 20px; background-color: #28a745; color: #ffffff;">
                            <h1 style="margin: 0; font-size: 24px;">Cập nhật trạng thái đơn hàng</h1>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 20px;">
                            <p style="font-size: 16px; color: #333;">Xin chào,</p>
                            <p style="font-size: 16px; color: #333;">Chúng tôi muốn thông báo rằng trạng thái đơn hàng của bạn đã được thay đổi. Dưới đây là thông tin chi tiết:</p>

                            <!-- Order Details -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 20px;">
                                <tr>
                                    <td style="font-size: 16px; color: #333; padding: 8px 0;"><strong>Mã đơn hàng:</strong></td>
                                    <td style="font-size: 16px; color: #007BFF; padding: 8px 0;">{{ $order->order_code }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 16px; color: #333; padding: 8px 0;"><strong>Ngày đặt hàng:</strong></td>
                                    <td style="font-size: 16px; color: #333; padding: 8px 0;">{{ $order->created_at->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 16px; color: #333; padding: 8px 0;"><strong>Trạng thái hiện tại:</strong></td>
                                    <td style="font-size: 16px; color: #333; padding: 8px 0;">{{ $order->status->type }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 16px; color: #333; padding: 8px 0;"><strong>Trạng thái thanh toán:</strong></td>
                                    <td style="font-size: 16px; color: #333; padding: 8px 0;">{{ $order->payment_status }}</td>
                                </tr>
                            </table>

                            <!-- Product Details -->
                            <h3 style="margin-top: 20px; font-size: 18px; color: #333;">Sản phẩm trong đơn hàng</h3>
                            <table width="100%" cellpadding="0" cellspacing="0" border="1" style="border-collapse: collapse; margin-top: 10px; text-align: center;">
                                <thead>
                                    <tr style="background-color: #f5f5f5;">
                                        <th style="padding: 10px; font-size: 14px; color: #333;">#</th>
                                        <th style="padding: 10px; font-size: 14px; color: #333;">Tên sản phẩm</th>
                                        <th style="padding: 10px; font-size: 14px; color: #333;">Phân loại</th>
                                        <th style="padding: 10px; font-size: 14px; color: #333;">Số lượng</th>
                                        <th style="padding: 10px; font-size: 14px; color: #333;">Giá</th>
                                        <th style="padding: 10px; font-size: 14px; color: #333;">Tổng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderDetails as $key => $detail)
                                    <tr>
                                        <td style="padding: 10px; font-size: 14px; color: #333;">{{ $key + 1 }}</td>
                                        <td style="padding: 10px; font-size: 14px; color: #333;">{{ $detail->product_name }}</td>
                                        <td style="padding: 10px; font-size: 14px; color: #333;">@foreach($detail->attributes as $attribute)
                                            {{ $attribute['name'] }}:
                                            {{ $attribute['value'] }}{{ !$loop->last ? ', ' : '' }}
                                            @endforeach</td>
                                        <td style="padding: 10px; font-size: 14px; color: #333;">{{ $detail->quantity }}</td>
                                        <td style="padding: 10px; font-size: 14px; color: #333;">{{ number_format($detail->price, 0, ',', '.') }} ₫</td>
                                        <td style="padding: 10px; font-size: 14px; color: #333;">{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }} ₫</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Total Summary -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 20px;">
                                <tr>
                                    <td style="font-size: 16px; color: #333; padding: 8px 0;"><strong>Tạm tính:</strong></td>
                                    <td style="font-size: 16px; color: #007BFF; padding: 8px 0;">{{ number_format($order->subtotal, 0, ',', '.') }} ₫</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 16px; color: #333; padding: 8px 0;"><strong>Phí ship:</strong></td>
                                    <td style="font-size: 16px; color: #007BFF; padding: 8px 0;">{{ number_format($order->shipping_fee, 0, ',', '.') }} ₫</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 16px; color: #333; padding: 8px 0;"><strong>Giảm giá:</strong></td>
                                    <td style="font-size: 16px; color: #007BFF; padding: 8px 0;">-{{ number_format($order->discount, 0, ',', '.') }} ₫</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 18px; color: #333; padding: 8px 0;"><strong>Tổng cộng:</strong></td>
                                    <td style="font-size: 18px; color: #FF0000; padding: 8px 0;">{{ number_format($order->total_price, 0, ',', '.') }} ₫</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="padding: 20px; background-color: #f5f5f5; color: #888; font-size: 12px;">
                            <p>© PolyStore trân thành cảm ơn!!! <a href="http://datn_wd13.test/orders/show/{{ $order->id }}">Xem chi tiết đơn hàng.</a></p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
