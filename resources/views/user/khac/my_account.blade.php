@extends('layouts.home')

@section('content')
<!-- Breadcrumb Section Start -->
<div class="section">

    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb-area bg-light">
        <div class="container-fluid">
            <div class="breadcrumb-content text-center">
                <h1 class="title">Tài khoản của tôi</h1>
                <ul>
                    <li>
                        <a href="index.html">Trang chủ </a>
                    </li>
                    <li class="active"> Tài khoản</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End -->

</div>
<!-- Breadcrumb Section End -->

<!-- My Account Section Start -->
<div class="section section-margin">
    <div class="container">

        <div class="row">
            <div class="col-lg-12">

                <!-- My Account Page Start -->
                <div class="myaccount-page-wrapper">
                    <!-- My Account Tab Menu Start -->
                    <div class="row">
                        <div class="col-lg-3 col-md-4">
                            <div class="myaccount-tab-menu nav" role="tablist">
                                <a href="#dashboad" class="active" data-bs-toggle="tab"><i class="fa fa-dashboard"></i>
                                    Dashboard</a>
                                <a href="#orders" data-bs-toggle="tab"><i class="fa fa-cart-arrow-down"></i> Orders</a>
                                <a href="#download" data-bs-toggle="tab"><i class="fa fa-cloud-download"></i>
                                    Download</a>
                                <a href="#payment-method" data-bs-toggle="tab"><i class="fa fa-credit-card"></i> Payment
                                    Method</a>
                                <a href="#address-edit" data-bs-toggle="tab"><i class="fa fa-map-marker"></i>
                                    address</a>
                                <a href="#account-info" data-bs-toggle="tab"><i class="fa fa-user"></i> Account
                                    Details</a>
                                <a class='dropdown-item notify-item' href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="mdi mdi-location-exit fs-16 align-middle"></i>
                                    <span>Đăng xuất</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                        <!-- My Account Tab Menu End -->

                        <!-- My Account Tab Content Start -->
                        <div class="col-lg-9 col-md-8">
                            <div class="tab-content" id="myaccountContent">
                                <!-- Single Tab Content Start -->
                                <div class="tab-pane fade show active" id="dashboad" role="tabpanel">
                                    <div class="myaccount-content">
                                        <h3 class="title">Dashboard</h3>
                                        <div class="welcome">
                                            <p>Hello, <strong>Alex Aya</strong> (If Not <strong>Aya !</strong><a
                                                    href="login-register.html" class="logout"> Logout</a>)</p>
                                        </div>
                                        <p class="mb-0">From your account dashboard. you can easily check & view your
                                            recent orders, manage your shipping and billing addresses and edit your
                                            password and account details.</p>
                                    </div>
                                </div>
                                <!-- Single Tab Content End -->

                                <!-- Single Tab Content Start -->
                                <div class="tab-pane fade" id="orders" role="tabpanel">
                                    <div class="myaccount-content">
                                        <h3 class="title">Orders</h3>
                                        <div class="myaccount-table table-responsive text-center">
                                            @foreach($orders as $order)
                                            <div class="container">
                                                <div class="card mb-3">
                                                    <div class="col-lg-12 mb-5">
                                                        <div class="row mx-3 my-3">
                                                            <!-- Thẻ thông tin đơn hàng -->
                                                            <div class="d-flex  justify-content-between">
                                                                <h4 class="text-center">Mã đơn: <span
                                                                        class="text-danger">{{ $order->order_code }}</span>
                                                                </h4>
                                                                <h5 class="text-center mx-3">
                                                                    {{ $order->status->type ?? 'N/A' }}
                                                                </h5>

                                                            </div>
                                                            <div class="d-flex  justify-content-start">
                                                                <p><strong>Ngày đặt:</strong>
                                                                    {{ $order->created_at->format('d-m-Y') }}</p>
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <!-- Bảng thông tin chi tiết đơn hàng -->
                                                        @foreach($order->orderDetails as $detail)
                                                        <div class="card-body border my-3">
                                                            <div
                                                                class="container d-flex justify-content-start align-items-center">
                                                                <!-- Hình ảnh sản phẩm -->
                                                                <div class="me-3">
                                                                    <img src="{{ url('storage/'. $detail->products->avata) }}"
                                                                        alt="{{ $detail->products->name }}"
                                                                        class="img-fluid"
                                                                        style="max-width: 100px; height: auto;">
                                                                </div>

                                                                <!-- Thông tin sản phẩm -->
                                                                <div class="w-75">
                                                                    <h6 class="mb-0 mx-3 text-start"><strong>Sản phẩm:</strong>
                                                                        {{ $detail->products->name }}</h6>
                                                                    <p class="mb-0 mx-3 text-muted text-start"><strong>Loại:</strong>
                                                                        {{ $detail->color }} / {{ $detail->size }}</p>

                                                                        <p class="mb-0 mx-3 text-start"><strong>Số lượng:</strong>
                                                                            {{ $detail->quantity }}</p>
                                                                        <p class="mb-0  mx-3 text-start"><strong>Giá:</strong>
                                                                            {{ number_format($detail->price, 0, '', ',') }}₫
                                                                        </p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        @endforeach
                                                        <div class="d-flex justify-content-end mx-3 mb-5">
                                                            <h6><strong>Tổng
                                                                    tiền:</strong>
                                                                {{ number_format($order->orderDetails->sum(fn($detail) => $detail->price * $detail->quantity) + $order->shipping_fee, 0, '', ',') }}₫
                                                            </h6>
                                                        </div>
                                                        <div class="d-flex justify-content-between">
                                                            <a href="{{ route('orders.show', $order->id) }}"
                                                                class="btn btn-dark mx-5 padding-bottom:-20px; ">Chi
                                                                tiết</a>
                                                            <form action="{{ route('orders.update', $order->id) }}"
                                                                method="POST"
                                                                style="display:inline; padding-top: 20px; ">
                                                                @csrf
                                                                @method('POST')

                                                                @if($order->status->type ===
                                                                \App\Models\StatusDonHang::CHO_XAC_NHAN)
                                                                <!-- Nếu trạng thái là 'Chờ xác nhận' -->
                                                                <input type="hidden" name="huy_don_hang" value="1">
                                                                <button type="submit" class="btn btn-primary mx-3"
                                                                    onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?');">
                                                                    Hủy đơn hàng
                                                                </button>
                                                                @elseif($order->status->type ===
                                                                \App\Models\StatusDonHang::DANG_VAN_CHUYEN)
                                                                <!-- Nếu trạng thái là 'Đang vận chuyển' -->
                                                                <input type="hidden" name="da_giao_hang" value="3">
                                                                <button type="submit" class="btn btn-success mx-3"
                                                                    onclick="return confirm('Bạn xác nhận đã nhận hàng?');">
                                                                    Đã nhận hàng
                                                                </button>
                                                                @endif
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <!-- Single Tab Content End -->


                                <!-- Single Tab Content Start -->
                                <div class="tab-pane fade" id="payment-method" role="tabpanel">
                                    <div class="myaccount-content">
                                        <h3 class="title">Payment Method</h3>
                                        <p class="saved-message">You Can't Saved Your Payment Method yet.</p>
                                    </div>
                                </div>
                                <!-- Single Tab Content End -->

                                <!-- Single Tab Content Start -->
                                <div class="tab-pane fade" id="address-edit" role="tabpanel">
                                    <div class="myaccount-content">
                                        <h3 class="title">Billing Address</h3>
                                        <address>
                                            <p><strong>Alex Aya</strong></p>
                                            <p>1234 Market ##, Suite 900 <br>
                                                Lorem Ipsum, ## 12345</p>
                                            <p>Mobile: (123) 123-456789</p>
                                        </address>
                                        <a href="#" class="btn btn btn-dark btn-hover-primary rounded-0"><i
                                                class="fa fa-edit me-2"></i>Edit Address</a>
                                    </div>
                                </div>
                                <!-- Single Tab Content End -->

                                <!-- Single Tab Content Start -->
                                <div class="tab-pane fade" id="account-info" role="tabpanel">
                                    <div class="myaccount-content">
                                        <h3 class="title">Chi tiết tài khoản</h3>
                                        <div class="account-details-form">
                                            <form action="#">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="single-input-item mb-3">
                                                            <label for="name" class="required mb-1">Họ tên</label>
                                                            <input type="text" id="name" value="{{ $user->name }}"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="single-input-item mb-3">
                                                            <label for="email" class="required mb-1">Email</label>
                                                            <input type="text" id="email" value="{{ $user->name }}"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="single-input-item mb-3">
                                                    <label for="address" class="required mb-1">Địa chỉ</label>
                                                    <input type="text" id="address"/>
                                                </div>
                                                <div class="single-input-item mb-3">
                                                    <label for="number_phone" class="required mb-1">Số điện thoại</label>
                                                    <input type="number" id="number_phone"/>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div> <!-- Single Tab Content End -->


                            </div>
                        </div> <!-- My Account Tab Content End -->
                    </div>
                </div>
                <!-- My Account Page End -->

            </div>
        </div>

    </div>
</div>
<!-- My Account Section End -->

<!-- Scroll Top Start -->
<a href="#" class="scroll-top" id="scroll-top">
    <i class="arrow-top fa fa-long-arrow-up"></i>
    <i class="arrow-bottom fa fa-long-arrow-up"></i>
</a>
<!-- Scroll Top End -->
@vite('resources/js/public.js');
@endsection