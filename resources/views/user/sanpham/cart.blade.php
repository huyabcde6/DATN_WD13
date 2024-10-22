@extends('layouts.home')

@section('content')
<!-- Breadcrumb Section Start -->
<div class="section">

    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb-area bg-light">
        <div class="container-fluid">
            <div class="breadcrumb-content text-center">
                <h1 class="title">Shopping Cart</h1>
                <ul>
                    <li>
                        <a href="/">Home</a>
                    </li>
                    <li class="active">Shopping Cart</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End -->

</div>
<!-- Breadcrumb Section End -->

<!-- Shopping Cart Section Start -->
<div class="section section-margin">
    <div class="container">

        <div class="row">
            <div class="col-12">

                <!-- Cart Table Start -->
                <div class="cart-table table-responsive">
                    <table class="table table-bordered">

                        <!-- Table Head Start -->
                        <thead>
                            <tr>
                                <th class="pro-thumbnail">Image</th>
                                <th class="pro-title">Product</th>
                                <th class="pro-price">Price</th>
                                <th class="pro-quantity">Quantity</th>
                                <th class="pro-subtotal">Total</th>
                                <th class="pro-remove">Remove</th>
                            </tr>
                        </thead>
                        <!-- Table Head End -->

                        <!-- Table Body Start -->
                        <tbody>
                            @foreach ($cartItems as $item)
                            <tr>
                                <td class="pro-thumbnail">
                                    <a href="#"><img class="img-fluid" src="{{ $item['image'] ?? '' }}" alt="Product" /></a>
                                </td>
                                <td class="pro-title">
                                    <a href="#">{{ $item['product_name'] ?? 'Product Name' }} <br> {{ $item['size'] ?? '' }} / {{ $item['color'] ?? '' }}</a>
                                </td>
                                <td class="pro-price"><span>{{ number_format($item['price'] ?? 0, 2) }} $</span></td>
                                <td class="pro-quantity">
                                    <div class="quantity">
                                        <div class="cart-plus-minus">
                                            <input class="cart-plus-minus-box" value="{{ $item['quantity'] }}" type="text" data-id="{{ $item['product_detail_id'] }}">
                                            <div class="dec qtybutton" data-id="{{ $item['product_detail_id'] }}">-</div>
                                            <div class="inc qtybutton" data-id="{{ $item['product_detail_id'] }}">+</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="pro-subtotal">
                                    <span class="subtotal-{{ $item['product_detail_id'] }}">{{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 0), 2) }} $</span>
                                </td>
                                <td class="pro-remove">
                                    <form action="{{ route('cart.remove', $item['product_detail_id']) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"><i class="pe-7s-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <!-- Table Body End -->

                    </table>
                </div>
                <!-- Cart Table End -->

                <!-- Cart Update Option Start -->
                <div class="cart-update-option d-block d-md-flex justify-content-between">

                    <!-- Apply Coupon Wrapper Start -->
                    <div class="apply-coupon-wrapper">
                        <form action="#" method="post" class=" d-block d-md-flex">
                            <input type="text" placeholder="Enter Your Coupon Code" required />
                            <button class="btn btn-dark btn-hover-primary rounded-0">Apply Coupon</button>
                        </form>
                    </div>
                    <!-- Apply Coupon Wrapper End -->

                    <!-- Cart Update Start -->
                    <div class="cart-update mt-sm-16">
                        <a href="#" class="btn btn-dark btn-hover-primary rounded-0">Update Cart</a>
                    </div>
                    <!-- Cart Update End -->

                </div>
                <!-- Cart Update Option End -->

            </div>
        </div>

        <div class="row">
            <div class="col-lg-5 ms-auto col-custom">

                <!-- Cart Calculation Area Start -->
                <div class="cart-calculator-wrapper">

                    <!-- Cart Calculate Items Start -->
                    <div class="cart-calculate-items">

                        <!-- Cart Calculate Items Title Start -->
                        <h3 class="title">Cart Totals</h3>
                        <!-- Cart Calculate Items Title End -->

                        <!-- Responsive Table Start -->
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <td>Sub Total</td>
                                    <td>{{ number_format(Cart::getSubTotal(), 2) }} $</td>
                                </tr>
                                <tr>
                                    <td>Shipping</td>
                                    <td>Free</td>
                                </tr>
                                <tr class="total">
                                    <td>Total</td>
                                    <td class="total-amount">{{ number_format(Cart::getTotal(), 2) }} $</td>
                                </tr>
                            </table>
                        </div>
                        <!-- Responsive Table End -->

                    </div>
                    <!-- Cart Calculate Items End -->

                    <!-- Cart Checkout Button Start -->
                    <a href="" class="btn btn-dark btn-hover-primary rounded-0 w-100">Proceed To Checkout</a>
                    <!-- Cart Checkout Button End -->

                </div>
                <!-- Cart Calculation Area End -->

            </div>
        </div>

    </div>
</div>
<!-- Shopping Cart Section End -->

<!-- Scroll Top Start -->
<a href="#" class="scroll-top" id="scroll-top">
    <i class="arrow-top fa fa-long-arrow-up"></i>
    <i class="arrow-bottom fa fa-long-arrow-up"></i>
</a>
<!-- Scroll Top End -->
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Xử lý sự kiện tăng/giảm số lượng
        $('.qtybutton').on('click', function() {
            var productDetailId = $(this).data('id');
            var inputField = $(this).siblings('.cart-plus-minus-box');
            var quantity = parseInt(inputField.val());

            // Tăng hoặc giảm số lượng
            if ($(this).hasClass('inc')) {
                quantity++;
            } else if ($(this).hasClass('dec') && quantity > 1) {
                quantity--;
            }

            // Gửi AJAX để cập nhật số lượng
            $.ajax({
                url: '{{ route("cart.update") }}',
                method: 'POST',
                data: {
                    product_detail_id: productDetailId,
                    quantity: quantity,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 'success') {
                        inputField.val(quantity);

                        // Cập nhật subtotal trong giao diện
                        var subtotalCell = inputField.closest('tr').find('.subtotal-' + productDetailId);
                        subtotalCell.text(response.item_price + ' $');
                        
                        // Cập nhật tổng giá trị đơn hàng
                        $('.total-amount').text(response.total_price + ' $');
                    }
                }
            });
        });
    });
</script>
@endsection
