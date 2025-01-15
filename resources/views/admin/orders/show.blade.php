@extends('layouts.admin')

@section('content')
<div class="container mt-5">

    <div class="card">
        
        <h2 class="title text-center my-3">Thông tin đơn hàng: <span class="text-danger">{{ $order->order_code }}</span>
        </h2>
        <div class="card-body">
            <div class="container">
                <div class="order-info d-flex justify-content-between mx-3">

                    <div class="">
                        <p><strong>Người nhận:</strong> {{ $order->nguoi_nhan }}</p>
                        <p><strong>Email:</strong> {{ $order->email }}</p>
                        <p><strong>Số điện thoại:</strong> {{ $order->number_phone }}</p>
                        <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
                        <p><strong>Ghi chú:</strong> {{ $order->ghi_chu }}</p>
                    </div>
                    <div class="">
                        <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d-m-Y') }}</p>
                        <p id="order-status-{{ $order->id }}"><strong>Trạng thái đơn hàng:</strong>
                            <mark>{{ $order->status->type ?? 'N/A' }}</mark>
                        </p>
                        <p style="font-size: 14px;"><strong>Trạng thái thanh toán:</strong> <mark>
                                {{ $order->payment_status }}</mark></p>
                    </div>
                </div>

            </div>
        </div>
    <hr>
        <div class="card-body">
            <h2 class=" text-center">Sản phẩm trong đơn hàng</h2>
            <div class="table-responsive mx-3">
                <table class="table table-bordered table-striped text-center">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Tên sản phẩm</th>
                            <th class="text-center">Hình ảnh</th>
                            <th class="text-center">Phân loại</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                            <th>Tổng tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderDetails as $key => $detail)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $detail->product_name }}</td>
                            <td class="text-center">
                                <img src="{{ url('storage/' . $detail->product_avata ?? '' )}}"
                                    alt="{{ $detail->product_name }}" class="img-thumbnail"
                                    style="width: 70px; height: auto;">
                            </td>
                            <td class="text-center">@foreach($detail->attributes as $attribute)
                                            {{ $attribute['name'] }}:
                                            {{ $attribute['value'] }}{{ !$loop->last ? ', ' : '' }}
                                            @endforeach</td>
                            <td>{{ $detail->quantity }}</td>
                            <td>{{ number_format($detail->price, 0, ',', '.') }} đ</td>
                            <td>{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }} đ</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex flex-column justify-content-end mx-3">
                    <h5 class="d-flex justify-content-between w-100">
                        <strong>Tổng phụ :</strong> <span
                            class="text-end">{{ number_format($totalAmount, 0, ',', '.') }}
                            đ</span>
                    </h5>
                    <h5 class="d-flex justify-content-between w-100">
                        <strong>Ship :</strong> <span class="text-end">30.000 đ</span>
                    </h5>
                    <h5 class="d-flex justify-content-between w-100">
                        <strong>Mã giảm giá :</strong> <span class="text-end"> -
                            {{ $order->discount ? number_format($order->discount, 0, ',', '.') : '0' }} đ</span>
                    </h5>
                    <h5 class="d-flex justify-content-between w-100">
                        <strong>Tổng tiền:</strong> <span
                            class="text-end">{{ number_format($order->total_price, 0, ',', '.') }} đ</span>
                    </h5>
                </div>
            </div>
        </div>
        <hr>
        <div class="card-body mx-3">
            <h3 class="me-5">Lịch sử thay đổi trạng thái</h3>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Thời gian</th>
                        <th>Trạng thái trước</th>
                        <th>Trạng thái sau</th>
                        <th>Người thay đổi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($statusHistory as $history)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($history->changed_at)->format('H:i (d-m-Y)') }}</td>

                        <td>{{ $history->previousStatus ? $history->previousStatus->type : 'N/A' }}</td>
                        <td>{{ $history->currentStatus ? $history->currentStatus->type : 'N/A' }}</td>
                        <td>
                            @if ($history->user)
                                {{ $history->user->roles->pluck('name')->first() }} : {{ $history->user->name }}
                            @else
                                N/A
                            @endif
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Không có lịch sử thay đổi trạng thái.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
        <div class="d-flex justify-content-end ">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-primary mx-4 mb-3">Quay lại</a>
        </div>
    </div>
</div>

@endsection