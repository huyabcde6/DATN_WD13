<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo đặt hàng</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f9f9f9;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f9f9f9; margin: 0; padding: 0;">
        <tr>
            <td align="center" style="padding: 20px 0;">
                <table width="600px" cellpadding="0" cellspacing="0" border="0" style="background-color: #ffffff; border: 1px solid #ddd; border-radius: 8px; overflow: hidden;">
                    <!-- Header -->
                    <tr>
                        <td align="center" style="padding: 20px; background-color: #007BFF; color: #ffffff;">
                            <h1 style="margin: 0; font-size: 24px;">Cảm ơn bạn đã mua sắm!</h1>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 20px;">
                            <p style="font-size: 16px; color: #333;">Xin chào,</p>
                            <p style="font-size: 16px; color: #333;">Đơn hàng của bạn đã được đặt thành công! Dưới đây là thông tin chi tiết:</p>

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
                                    <td style="font-size: 16px; color: #333; padding: 8px 0;"><strong>Phương thức thanh toán:</strong></td>
                                    <td style="font-size: 16px; color: #333; padding: 8px 0;">{{ $order->method }}</td>
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
                                        <th style="padding: 10px; font-size: 14px; color: #333;">Màu</th>
                                        <th style="padding: 10px; font-size: 14px; color: #333;">Size</th>
                                        <th style="padding: 10px; font-size: 14px; color: #333;">Số lượng</th>
                                        <th style="padding: 10px; font-size: 14px; color: #333;">Giá</th>
                                        <th style="padding: 10px; font-size: 14px; color: #333;">Tổng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderDetails as $key => $detail)
                                    <tr>
                                        <td style="padding: 10px; font-size: 14px; color: #333;">{{ $key + 1 }}</td>
                                        <td style="padding: 10px; font-size: 14px; color: #333;">{{ $detail->products->name }}</td>
                                        <td style="padding: 10px; font-size: 14px; color: #333;">{{ $detail->color }}</td>
                                        <td style="padding: 10px; font-size: 14px; color: #333;">{{ $detail->size }}</td>
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
