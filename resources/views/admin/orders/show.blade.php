@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-end mb-4">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-primary">Quay lại</a>
    </div>
    <div class="card">
        <h2 class="title text-center mb-4">Thông tin đơn hàng: <span class="text-danger">{{ $order->order_code }}</span>
        </h2>

        <div class="order-info mb-4 mx-3">
            <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d-m-Y') }}</p>
            <p><strong>Trạng thái:</strong> {{ $order->status->type ?? 'N/A' }}</p>
            <p><strong>Người nhận:</strong> {{ $order->nguoi_nhan }}</p>
            <p><strong>Email:</strong> {{ $order->email }}</p>
            <p><strong>Số điện thoại:</strong> {{ $order->number_phone }}</p>
            <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
            <p><strong>Ghi chú:</strong> {{ $order->ghi_chu }}</p>
            <p><strong>Tổng tiền:</strong> <span
                    class="text-danger ">{{ number_format($order->orderDetails->sum(fn($detail) => $detail->price * $detail->quantity) + $order->shipping_fee, 0, '', ',') }}₫</span></p>
        </div>

        <h2 class="my-4 text-center">Sản phẩm trong đơn hàng</h2>
        <div class="table-responsive mx-3">
            <table class="table table-bordered table-striped">
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
                        <td>{{ $detail->product_name }}</td>
                        <td>
                            <img src="{{ url('storage/' . $detail->product_avata ?? '' )}}" alt="{{ $detail->product_name }}"
                                class="img-thumbnail" style="width: 70px; height: auto;">
                        </td>
                        <td>{{ $detail->color }}</td>
                        <td>{{ $detail->size }}</td>
                        <td>{{ $detail->quantity }}</td>
                        <td>{{ number_format($detail->price, 0, ',', '.') }} đ</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection