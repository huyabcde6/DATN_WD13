@extends('layouts.home')

@section('content')
<!-- Breadcrumb Section Start -->
<div class="section">

    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb-area bg-light">
        <div class="container-fluid">
            <div class="breadcrumb-content text-center">
                <h1 class="title">Thanh toán</h1>
                <ul>
                    <li>
                        <a href="{{ url('/') }}">Trang chủ </a>
                    </li>
                    <li class="active"> Thanh toán</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End -->

</div>
<!-- Breadcrumb Section End -->

<!-- Checkout Section Start -->
<div class="section section-margin">
    <div class="container">
    <form action="{{ route('orders.store') }}" method="POST">
    @csrf
        <div class="row mb-n4">
            
            <div class="col-lg-6 col-12 mb-4">
            
                <!-- Checkbox Form Start -->
                <div class="checkbox-form">

                    <!-- Checkbox Form Title Start -->
                    <h3 class="title">Chi tiết thanh toán</h3>
                    <!-- Checkbox Form Title End -->

                    <div class="row">
                        <!-- First Name Input Start -->
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <div class="col-md-12">
                            <div class="checkout-form-list">
                                <label>Tên người nhận<span class="required">*</span></label>
                                <input placeholder="" type="text" name="nguoi_nhan" value="{{ Auth::user()->name }}">
                            </div>
                        </div>

                        <!-- Email Address Input Start -->
                        <div class="col-md-12">
                            <div class="checkout-form-list">
                                <label>Email <span class="required">*</span></label>
                                <input placeholder="" name="email" type="email" value="{{ Auth::user()->email }}">
                            </div>
                        </div>
                        <!-- Email Address Input End -->

                        <!-- Phone Input Start -->
                        <div class="col-md-12">
                            <div class="checkout-form-list">
                                <label>Số điện thoại <span class="required">*</span></label>
                                <input type="text" placeholder="number phone" name="number_phone" value="{{ Auth::user()->number_phone }}">
                            </div>
                        </div>

                        <!-- Address Input Start -->
                        <div class="col-md-12">
                            <div class="checkout-form-list">
                                <label>Địa chỉ <span class="required">*</span></label>
                                <input placeholder="Street address" name="address" type="text" value="{{ Auth::user()->address }}">
                            </div>
                        </div>

                        <!-- Order Notes Start -->
                        <div class="order-notes mt-3 mb-n2">
                            <div class="checkout-form-list checkout-form-list-2">
                                <label>Ghi chú đặt hàng</label>
                                <textarea id="checkout-mess" name="ghi_chu" cols="30" rows="10" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Checkbox Form End -->
            </div>

            <div class="col-lg-6 col-12 mb-4">

                <!-- Your Order Area Start -->
                <div class="your-order-area border">
                    <h3 class="title">Đơn hàng của bạn</h3>
                    <div class="your-order-table table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="cart-product-name text-start">Sản phẩm</th>
                                    <th class="cart-product-total text-end">Tổng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cartItems as $item)
                                    <tr>
                                        <td class="cart-product-name text-start">
                                            <a href="{{ route('product.show', $item['product_id']) }}">
                                                {{ $item['product_name'] }}
                                            </a> 
                                            <strong> × {{ $item['quantity'] }}</strong>
                                        </td>
                                        <td class="cart-product-total text-end">{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}₫</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-start">Tổng phụ</th>
                                    <td class="text-end">{{ number_format($subTotal, 0, ',', '.') }} ₫</td>
                                    <input type="hidden" name="subtotal" value="{{ $subTotal }}">
                                </tr>
                                <tr>
                                    <th class="text-start">Phí vận chuyển</th>
                                    <td class="text-end">{{ number_format($shippingFee, 0, ',', '.') }} ₫</td>
                                    <input type="hidden" name="shipping_fee" value="{{ $shippingFee }}">
                                </tr>
                                <tr>
                                    <th class="text-start">Tổng cộng</th>
                                    <td class="text-end"><strong>{{ number_format($total, 0, ',', '.') }} ₫</strong></td>
                                    <input type="hidden" name="total_price" value="{{ $total }}">
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
                <!-- Your Order Area End -->

                <!-- Payment Method Start -->
                <div class="payment-accordion-order-button">
                    <div class="payment-accordion">
                        <div class="single-payment">
                            <h5 class="panel-title mb-3">
                                <input type="radio" id="cod" name="method" value="cod" checked>
                                <label for="cod">COD</label>
                            </h5>
                            <div class="card card-body rounded-0">
                                <p>Thanh toán khi nhận hàng</p>
                            </div>
                        </div>
                    </div>

                    <div class="order-button-payment">
                        <button type="submit" class="btn btn-dark btn-hover-primary rounded-0 w-100">ĐẶT HÀNG</button>
                    </div>
                </div>
                <!-- Payment Method End -->

            </div>
            
        </div>
        </form>
    </div>
</div>
<!-- Checkout Section End -->
<div id="loading-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 9999; text-align: center; justify-content: center; align-items: center;">
    <div class="spinner-border text-light" role="status" style="width: 3rem; height: 3rem;">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>
<!-- Scroll Top Start -->
<a href="#" class="scroll-top" id="scroll-top">
    <i class="arrow-top fa fa-long-arrow-up"></i>
    <i class="arrow-bottom fa fa-long-arrow-up"></i>
</a>
<!-- Scroll Top End -->
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form');
        const loadingOverlay = document.getElementById('loading-overlay');

        // Hiển thị loading overlay khi form submit
        form.addEventListener('submit', function (e) {
            loadingOverlay.style.display = 'flex';
        });

        const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
        const momoDescription = document.getElementById('momo-description');

        paymentRadios.forEach(radio => {
            radio.addEventListener('change', function () {
                if (this.value === 'momo') {
                    momoDescription.classList.remove('d-none');
                } else {
                    momoDescription.classList.add('d-none');
                }
            });
        });
    });
</script>
@endsection

