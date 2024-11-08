@extends('layouts.home')

@section('content')
<div class="section section-margin">
    <div class="container">
        <div class="col-lg-12 mb-5">
            <h2 class="title text-center">Thông tin đơn hàng: <span class="text-danger">{{ $order->order_code }}</span>
            </h2>
            <div class="order-info">
                <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d-m-Y') }}</p>
                <p><strong>Trạng thái:</strong> {{ $order->status->type ?? 'N/A' }}</p>
                <p><strong>Người nhận:</strong> {{ $order->nguoi_nhan }}</p>
                <p><strong>Email:</strong> {{ $order->email }}</p>
                <p><strong>Số điện thoại:</strong> {{ $order->number_phone }}</p>
                <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
                <p><strong>Ghi chú:</strong> {{ $order->ghi_chu }}</p>
                <p><strong>Tổng tiền:</strong>
                    {{ number_format($order->orderDetails->sum(fn($detail) => $detail->price * $detail->quantity) + $order->shipping_fee, 2) }}
                    $</p>
            </div>

            <table class="table table-bordered mt-4 text-center">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Tên sản phẩm</th>
                        <th>Hình ảnh</th>
                        <th>Màu</th>
                        <th>Size</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderDetails as $key => $detail)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $detail->products->name }}</td>
                        <td>
                            <img src="{{ url('storage/'. $detail->products->avata)}}" alt="{{ $detail->products->name }}"
                                style="width: 70px; height: auto;">
                        </td>
                        <td>{{ $detail->color }}</td>
                        <td>{{ $detail->size }}</td>
                        <td>{{ $detail->quantity }}</td>
                        <td>{{ number_format($detail->price, 0, '', '.') }}
                        đ</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-center mt-4">
                <a href="{{route('orders.index')}}" class="btn btn-primary">Quay lại Tài khoản của tôi</a>
            </div>
        </div>
    </div>
</div>
@endsection