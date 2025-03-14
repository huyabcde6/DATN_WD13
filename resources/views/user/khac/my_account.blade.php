@extends('layouts.home')
@section('css')
<style>
    .filter-link {
        position: relative;
        /* Đảm bảo dải màu đỏ sẽ hiển thị đúng dưới liên kết */
        padding-bottom: 2px;
        /* Thêm một chút khoảng cách dưới để dải màu đỏ không bị dính vào chữ */
        text-decoration: none;
        /* Loại bỏ gạch dưới mặc định */
    }

    .filter-link::after {
        content: '';
        /* Không có nội dung */
        position: absolute;
        /* Đặt dải màu dưới */
        left: 0;
        /* Căn trái */
        right: 0;
        /* Căn phải */
        bottom: 0;
        /* Căn dưới */
        height: 2px;
        /* Dải màu có chiều cao 2px */
        background-color: red;
        /* Màu đỏ */
        transform: scaleX(0);
        /* Ẩn dải màu ban đầu */
        transform-origin: bottom right;
        /* Đặt điểm gốc của hiệu ứng là phía dưới bên phải */
        transition: transform 0.3s ease;
        /* Hiệu ứng chuyển động mượt mà */
    }

    .myaccount-content {
        padding: 15px;
    }

    .filter-link:hover::after {
        transform: scaleX(1);
        /* Khi hover, dải màu đỏ sẽ hiển thị */
        transform-origin: bottom left;
        /* Thay đổi điểm gốc khi hover */
    }

    #loading p {
        font-size: 14px;
        color: #666;
        font-style: italic;
    }
</style>
@endsection

@section('content')
<div class="section">

    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb">
        <a href="http://datn_wd13.test/"><i class="fa fa-home"></i> Trang Chủ</a>
        <span class="breadcrumb-separator"> > </span>
        <span><a href="http://datn_wd13.test/orders">Thông tin người dùng</a></span>
    </div>
    <!-- Breadcrumb Area End -->

</div>
<!-- Breadcrumb Section Start -->
<div class="section mt-4 mb-5">
    <div class="container">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        <div class="row">
            <div class="col-lg-12">
                <div class="myaccount-page-wrapper">
                    <div class="row">
                        <div class="col-lg-3 col-md-4">
                            <div class="myaccount-tab-menu nav" role="tablist">
                                <!-- <a href="#dashboad" class="active" data-bs-toggle="tab"><i class="fa fa-dashboard"></i>
                                    Trang chủ</a> -->
                                <a href="#orders" data-bs-toggle="tab" class="active"><i class="fa fa-cart-arrow-down"></i>
                                    Đơn hàng</a>
                                <a href="#account-info" data-bs-toggle="tab"><i class="fa fa-user"></i>Chi tiết tài
                                    khoản </a>
                                @if($role)
                                <a href="/admin"><i class="fa fa-user"></i>Chuyển trang Admin</a>
                                @endif
                                <a class='dropdown-item notify-item' href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="mdi mdi-location-exit fs-16 align-middle"></i>
                                    <span>Đăng xuất</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-8">
                            <div class="tab-content" id="myaccountContent">
                                <!-- Single Tab Content Start -->
                                <!-- <div class="tab-pane fade show active" id="dashboad" role="tabpanel">
                                    <div class="myaccount-content" style="">
                                        <h3 class="title">Tài khoản</h3>
                                        <div class="welcome">
                                            <p>Xin chào, <strong>{{ $user->name }} </strong>!!!</p>
                                            <p>Địa chỉ: {{ $user->address  ?? ''}}</p>
                                            <p>Số điện thoại: {{ $user->number_phone ??''}}</p>
                                            <hr>

                                        </div>

                                    </div>
                                </div> -->
                                <div class="tab-pane fade show active" id="orders" role="tabpanel">
                                    <h5 class="mb-3">Đơn Hàng Của Bạn</h5>
                                    <div class="d-flex justify-content-evenly mb-3 fs-12">
                                        <a class="mx-1 filter-link active" data-status="all">Tất cả</a>
                                        <a class="mx-1 filter-link" data-status="1">Chờ xác nhận</a>
                                        <a class="mx-1 filter-link" data-status="2" href="#">Đã xác nhận</a>
                                        <a class="mx-1 filter-link" data-status="3" href="#">Vận chuyển</a>
                                        <a class="mx-1 filter-link" data-status="4" href="#">Đã giao hàng</a>
                                        <a class="mx-1 filter-link" data-status="5" href="#">Hoàn thành</a>
                                        <a class="mx-1 filter-link" data-status="7" href="#">Đã hủy</a>
                                    </div>
                                    <div class="myaccount-content" id="orders-container">
                                        @include('user.khac.partials.orders')
                                        <!-- Hiển thị danh sách đơn hàng ban đầu -->
                                    </div>
                                    <div id="loading" class="text-center my-3" style="display: none;">
                                        <p>Đang tải...</p>
                                    </div>
                                </div>
                                <!-- Single Tab Content Start -->
                                <div class="tab-pane fade" id="address-edit" role="tabpanel">
                                    <div class="myaccount-content">
                                        <h3 class="title">Address</h3>
                                        <form action="{{ route('user.updateAddress') }}" method="POST">
                                            @csrf
                                            <div class="checkout-form-list">
                                                <label>Địa chỉ <span class="required">*</span></label>
                                                <input placeholder="Street address" name="address" type="text"
                                                    value="{{ Auth::user()->address }}"><br>
                                                <label>Số điện thoại <span class="required">*</span></label>
                                                <input type="text" placeholder="number phone" name="number_phone"
                                                    value="{{ Auth::user()->number_phone }}">
                                            </div>
                                            <button type="submit" class="btn btn-dark btn-hover-primary rounded-0">
                                                <i class="fa fa-edit me-2"></i>Cập nhật địa chỉ
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <!-- end -->
                                <div class="tab-pane fade" id="account-info" role="tabpanel">
                                    <div class="myaccount-content">
                                        <h3 class="title">Account Details</h3>
                                        <div class="account-details-form">
                                            <form method="POST" action="{{ route('profile.updateAccount') }}">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="single-input-item mb-3">
                                                            <label for="name" class="required mb-1">Họ tên</label>
                                                            <input type="text" name="name" id="name"
                                                                value="{{ $user->name }}" />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="single-input-item mb-3">
                                                            <label for="email" class="required mb-1">Email</label>
                                                            <input type="text" name="email" id="email"
                                                                value="{{ $user->email }}" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="single-input-item mb-3">
                                                    <label for="address" class="required mb-1">Địa chỉ</label>
                                                    <input type="text" name="address" id="address"
                                                        value="{{ $user->address }}" />
                                                </div>
                                                <div class="single-input-item mb-3">
                                                    <label for="number_phone" class="required mb-1">Số điện
                                                        thoại</label>
                                                    <input type="number" name="number_phone" id="number_phone"
                                                        value="{{ $user->number_phone }}" />
                                                </div>
                                                <div class="form-group">
                                                    <button class="btn btn-success">Lưu</button>
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
<!-- ount Section End -->

<!-- Scroll Top Start -->
<a href="#" class="scroll-top" id="scroll-top">
    <i class="arrow-top fa fa-long-arrow-up"></i>
    <i class="arrow-bottom fa fa-long-arrow-up"></i>
</a>

<!-- Scroll Top End -->
@vite('resources/js/public.js');
@endsection
@section('js')
<script>
    let page = 1;
    let isLoading = false;
    let currentStatus = 'all'; // Trạng thái mặc định là "Tất cả"

    window.addEventListener('scroll', function() {
        if (isLoading) return;

        const scrollable = document.documentElement.scrollHeight - window.innerHeight;
        const scrolled = window.scrollY;
        if (scrollable - scrolled <= 100) {
            loadMoreOrders();
        }
    });

    document.querySelectorAll('.filter-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();

            // Đặt lại trạng thái lọc
            document.querySelectorAll('.filter-link').forEach(link => link.classList.remove('active'));
            this.classList.add('active');

            // Cập nhật trạng thái hiện tại
            currentStatus = this.getAttribute('data-status');
            page = 1; // Reset về trang đầu tiên

            // Xóa danh sách hiện tại và tải lại
            document.getElementById('orders-container').innerHTML = '';
            loadMoreOrders();
        });
    });

    function loadMoreOrders() {
        isLoading = true;
        document.getElementById('loading').style.display = 'block';

        fetch(`{{ route('orders.index') }}?page=${page}&status=${currentStatus}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                const container = document.getElementById('orders-container');
                if (page === 1) container.innerHTML = ''; // Xóa nội dung cũ nếu là trang đầu
                container.insertAdjacentHTML('beforeend', html); // Chèn thêm dữ liệu vào container
                page++; // Tăng số trang
                isLoading = false;
                document.getElementById('loading').style.display = 'none';
            })
            .catch(error => {
                console.error(error);
                isLoading = false;
                document.getElementById('loading').style.display = 'none';
            });
    }
</script>
@endsection