<!-- resources/views/thank_you.blade.php -->
@extends('layouts.home')

@section('content')
<div class="section">

    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb">
        <a href="http://datn_wd13.test/"><i class="fa fa-home"></i> Trang Chủ</a>
        <span class="breadcrumb-separator"> > </span>
        <span><a href="http://datn_wd13.test/shop">Cảm ơn</a></span>
    </div>
    <!-- Breadcrumb Area End -->

</div>
<div class="section section-margin">

    <div class="container">
        <div class="text-center mb-3">
            <h1>Cảm ơn bạn đã mua sắm !</h1>
            <img src="{{ asset('ngdung/assets/images/icons/cam-on-ban-da-dang-ky-form-4.png')}}" width="80px"
                heigh="auto" class="my-2" alt="">
            <p>Đặt hàng thành công. <a href="{{ url('/') }}">Tiếp tục mua sắm</a></p>

        </div>
        <div class="card">

            <div class="card-body">
                <h3>Thông tin đơn hàng</h3>
                <p><strong>Mã đơn hàng:</strong> {{ $order->order_code }}</p>
                <p><strong>Ngày đặt hàng:</strong> {{ $order->created_at->format('d/m/Y') }}</p>
                <p><strong>Phương thức thanh toán:</strong> {{ $order->method }}</p>
                <p><strong>Trạng thái thanh toán:</strong> {{ $order->payment_status }}</p>
            </div>
            <div class="card-body">
                <h4>Sản phẩm trong đơn hàng</h4>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive rounded-2">
                            <table class="table table-bordered text-center">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Hình ảnh</th>
                                        <th>Màu</th>
                                        <th>Size</th>
                                        <th>Số lượng</th>
                                        <th>Giá</th>
                                        <th>Tổng tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderDetails as $key => $detail)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $detail->products->name }}</td>
                                        <td>
                                            <img src="{{ url('storage/'. $detail->products->avata) }}"
                                                alt="{{ $detail->products->name }}" style="width: 70px; height: auto;">
                                        </td>
                                        <td>{{ $detail->color }}</td>
                                        <td>{{ $detail->size }}</td>
                                        <td>{{ $detail->quantity }}</td>
                                        <td>{{ number_format($detail->price, 0, '', ',') }} ₫</td>
                                        <td>{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }} đ</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <table class="d-flex justify-content-end text-nowrap mb-0 table-borderless">
                                <tbody>
                                    <tr>
                                        <td>
                                            <p class="mb-0">Tạm tính :</p>
                                        </td>
                                        <td>
                                            <p class="mb-0 fw-medium fs-15">
                                                {{ number_format($order->subtotal, 0, ',', '.') }} đ
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="2">
                                            <p class="mb-0">Phí ship :</p>
                                        </td>
                                        <td>
                                            <p class="mb-0 fw-medium fs-15">
                                                {{ number_format($order->shipping_fee, 0, ',', '.') }} đ
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="2">
                                            <p class="mb-0">Giảm giá :</p>
                                        </td>
                                        <td>
                                            <p class="mb-0 fw-medium fs-15">
                                                - {{ number_format($order->discount, 0, ',', '.') }} đ
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class=""><strong>Tổng tiền phải trả</strong> :</p>
                                        </td>
                                        <td>
                                            <p class="">
                                                {{ number_format($order->total_price, 0, ',', '.') }} đ
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection