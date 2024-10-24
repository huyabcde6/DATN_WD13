@extends('layouts.home')

@section('content')
<!-- Breadcrumb Section Start -->
<div class="section">

    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb-area bg-light">
        <div class="container-fluid">
            <div class="breadcrumb-content text-center">
                <h1 class="title">Checkout</h1>
                <ul>
                    <li>
                        <a href="index.html">Home </a>
                    </li>
                    <li class="active"> Checkout</li>
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
        <div class="row">
            <div class="col-12">
                <!-- Coupon Accordion Start -->
                <div class="coupon-accordion">

                    <!-- Title Start -->
                    <h3 class="title">Returning customer? <span id="showlogin">Click here to login</span></h3>
                    <!-- Title End -->

                    <!-- Checkout Login Start -->
                    <div id="checkout-login" class="coupon-content">
                        <div class="coupon-info">
                            <p class="coupon-text mb-2">Quisque gravida turpis sit amet nulla posuere lacinia. Cras sed est sit amet ipsum luctus.</p>

                            <!-- Form Start -->
                            <form action="#">
                                <!-- Input Email Start -->
                                <p class="form-row-first">
                                    <label>Username or email <span class="required">*</span></label>
                                    <input type="text">
                                </p>
                                <!-- Input Email End -->

                                <!-- Input Password Start -->
                                <p class="form-row-last">
                                    <label>Password <span class="required">*</span></label>
                                    <input type="password">
                                </p>
                                <!-- Input Password End -->

                                <!-- Remember Password Start -->
                                <p class="form-row mb-2">
                                    <input type="checkbox" id="remember_me">
                                    <label for="remember_me" class="checkbox-label">Remember me</label>
                                </p>
                                <!-- Remember Password End -->

                                <!-- Lost Password Start -->
                                <p class="lost-password"><a href="#">Lost your password?</a></p>
                                <!-- Lost Password End -->

                            </form>
                            <!-- Form End -->

                        </div>
                    </div>
                    <!-- Checkout Login End -->

                    <!-- Title Start -->
                    <h3 class="title">Have a coupon? <span id="showcoupon">Click here to enter your code</span></h3>
                    <!-- Title End -->

                    <!-- Checkout Coupon Start -->
                    <div id="checkout_coupon" class="coupon-checkout-content">
                        <div class="coupon-info">
                            <form action="#">
                                <p class="checkout-coupon d-flex">
                                    <input placeholder="Coupon code" type="text">
                                    <input class="btn btn-dark btn-hover-primary rounded-0" value="Apply Coupon" type="submit">
                                </p>
                            </form>
                        </div>
                    </div>
                    <!-- Checkout Coupon End -->

                </div>
                <!-- Coupon Accordion End -->
            </div>
        </div>
        <div class="row mb-n4">
            <div class="col-lg-6 col-12 mb-4">

                <!-- Checkbox Form Start -->
                <form action="#">
                    <div class="checkbox-form">

                        <!-- Checkbox Form Title Start -->
                        <h3 class="title">Billing Details</h3>
                        <!-- Checkbox Form Title End -->

                        <div class="row">
                            <!-- First Name Input Start -->
                            <div class="col-md-6">
                                <div class="checkout-form-list">
                                    <label>Họ và tên <span class="required">*</span></label>
                                    <input placeholder="" type="text" name="nguoi_nhan">
                                </div>
                            </div>

                            <!-- Email Address Input Start -->
                            <div class="col-md-6">
                                <div class="checkout-form-list">
                                    <label>Email Address <span class="required">*</span></label>
                                    <input placeholder="" name="email" type="email">
                                </div>
                            </div>
                            <!-- Email Address Input End -->

                            <div class="col-md-12">
                                <div class="checkout-form-list">
                                    <label>Address <span class="required">*</span></label>
                                    <input placeholder="Street address" name="address" type="text">
                                </div>
                            </div>

                            <!-- Phone Number Input Start -->
                            <div class="col-md-6">
                                <div class="checkout-form-list">
                                    <label>Phone <span class="required">*</span></label>
                                    <input type="text" name="number_phone">
                                </div>
                            </div>
                            <!-- Phone Number Input End -->
                            <!-- Checkout Form List checkbox End -->
                            <div class="order-notes mt-3 mb-n2">
                                <div class="checkout-form-list checkout-form-list-2">
                                    <label>Order Notes</label>
                                    <textarea id="checkout-mess" cols="30" rows="10" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
                <!-- Checkbox Form End -->

            </div>

            <div class="col-lg-6 col-12 mb-4">

                <!-- Your Order Area Start -->
                <div class="your-order-area border">
                    <h3 class="title">Your order</h3>
                    <div class="your-order-table table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="cart-product-name text-start">Product</th>
                                    <th class="cart-product-total text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cartItems as $item)
                                    <tr>
                                        <td class="cart-product-name text-start">{{ $item['product_name'] }} <strong> × {{ $item['quantity'] }}</strong></td>
                                        <td class="cart-product-total text-end">{{ number_format($item['price'] * $item['quantity'], 2) }}$</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-start">Subtotal</th>
                                    <td class="text-end">{{ number_format($subTotal, 2) }}$</td>
                                </tr>
                                <tr>
                                    <th class="text-start">Shipping Fee</th>
                                    <td class="text-end">{{ number_format($shippingFee, 2) }}$</td>
                                </tr>
                                <tr>
                                    <th class="text-start">Total</th>
                                    <td class="text-end"><strong>{{ number_format($total, 2) }}$</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-dark btn-hover-primary rounded-0 w-100">Place Order</button>
                    </form>
                </div>
                <!-- Your Order Area End -->
            </div>
        </div>
    </div>
</div>
<!-- Checkout Section End -->

<!-- Scroll Top Start -->
<a href="#" class="scroll-top" id="scroll-top">
    <i class="arrow-top fa fa-long-arrow-up"></i>
    <i class="arrow-bottom fa fa-long-arrow-up"></i>
</a>
<!-- Scroll Top End -->
@endsection