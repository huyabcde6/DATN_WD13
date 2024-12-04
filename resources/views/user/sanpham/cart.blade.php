@extends('layouts.home')

@section('content')
<!-- Breadcrumb Section Start -->
<div class="section">

    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb-area bg-light">
        <div class="container-fluid">
            <div class="breadcrumb-content text-center">
<<<<<<< HEAD
                <h1 class="title">Giỏ Hàng</h1>
                <ul>
                    <li>
                        <a href="/">Trang Chủ</a>
                    </li>
                    <li class="active">Giỏ Hàng</li>
=======
                <h1 class="title">Shopping Cart</h1>
                <ul>
                    <li>
                        <a href="index.html">Home </a>
                    </li>
                    <li class="active"> Shopping Cart</li>
>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19
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
<<<<<<< HEAD
                                <th class="pro-thumbnail">Hình ảnh</th>
                                <th class="pro-title">Sản phẩm</th>
                                <th class="pro-price">Giá</th>
                                <th class="pro-quantity">Số lượng</th>
                                <th class="pro-subtotal">Tổng</th>
                                <th class="pro-remove">Xóa</th>
=======
                                <th class="pro-thumbnail">Image</th>
                                <th class="pro-title">Product</th>
                                <th class="pro-price">Price</th>
                                <th class="pro-quantity">Quantity</th>
                                <th class="pro-subtotal">Total</th>
                                <th class="pro-remove">Remove</th>
>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19
                            </tr>
                        </thead>
                        <!-- Table Head End -->

                        <!-- Table Body Start -->
                        <tbody>
<<<<<<< HEAD
                            @foreach ($cartItems as $item)
                            <tr>
                                <td class="pro-thumbnail">
                                    <a href="#"><img class="img-fluid" src="{{ url('storage/'. $item['image']) }}"
                                            alt="Product" /></a>
                                </td>
                                <td class="pro-title">
                                    <a href="#">{{ $item['product_name'] }} <br> {{ $item['size'] }} /
                                        {{ $item['color'] }}</a>
                                </td>
                                <td class="pro-price"><span>{{ number_format($item['price'] ?? 0, 0, ',', '.') }}
                                        đ</span></td>
                                <td class="pro-quantity">
                                    <div class="quantity">
                                        <div class="cart-plus-minus">
                                            <input class="cart-plus-minus-box" value="{{ $item['quantity'] }}"
                                                type="text" data-id="{{ $item['product_detail_id'] }}">
                                            <div class="dec qtybutton" data-id="{{ $item['product_detail_id'] }}">-
                                            </div>
                                            <div class="inc qtybutton" data-id="{{ $item['product_detail_id'] }}">+
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="pro-subtotal">
                                    <span
                                        class="subtotal-{{ $item['product_detail_id'] }}">{{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 0), 0, ',', '.') }}
                                        đ</span>
                                </td>
                                <td class="pro-remove">
                                    <form action="{{ route('cart.remove', $item['product_detail_id']) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"><i
                                                class="pe-7s-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
=======
                            <tr>
                                <td class="pro-thumbnail"><a href="#"><img class="img-fluid" src="assets/images/products/small-product/1.jpg" alt="Product" /></a></td>
                                <td class="pro-title"><a href="#">Brother Hoddies in Grey <br> s / green</a></td>
                                <td class="pro-price"><span>$95.00</span></td>
                                <td class="pro-quantity">
                                    <div class="quantity">
                                        <div class="cart-plus-minus">
                                            <input class="cart-plus-minus-box" value="0" type="text">
                                            <div class="dec qtybutton">-</div>
                                            <div class="inc qtybutton">+</div>
                                            <div class="dec qtybutton"><i class="fa fa-minus"></i></div>
                                            <div class="inc qtybutton"><i class="fa fa-plus"></i></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="pro-subtotal"><span>$95.00</span></td>
                                <td class="pro-remove"><a href="#"><i class="pe-7s-trash"></i></a></td>
                            </tr>
                            <tr>
                                <td class="pro-thumbnail"><a href="#"><img class="img-fluid" src="assets/images/products/small-product/2.jpg" alt="Product" /></a></td>
                                <td class="pro-title"><a href="#">Basic Jogging Shorts <br> Blue</a></td>
                                <td class="pro-price"><span>$75.00</span></td>
                                <td class="pro-quantity">
                                    <div class="quantity">
                                        <div class="cart-plus-minus">
                                            <input class="cart-plus-minus-box" value="0" type="text">
                                            <div class="dec qtybutton">-</div>
                                            <div class="inc qtybutton">+</div>
                                            <div class="dec qtybutton"><i class="fa fa-minus"></i></div>
                                            <div class="inc qtybutton"><i class="fa fa-plus"></i></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="pro-subtotal"><span>$75.00</span></td>
                                <td class="pro-remove"><a href="#"><i class="pe-7s-trash"></i></a></td>
                            </tr>
                            <tr>
                                <td class="pro-thumbnail"><a href="#"><img class="img-fluid" src="assets/images/products/small-product/10.jpg" alt="Product" /></a></td>
                                <td class="pro-title"><a href="#">Lust For Life <br> Bulk/S</a></td>
                                <td class="pro-price"><span>$295.00</span></td>
                                <td class="pro-quantity">
                                    <div class="quantity">
                                        <div class="cart-plus-minus">
                                            <input class="cart-plus-minus-box" value="0" type="text">
                                            <div class="dec qtybutton">-</div>
                                            <div class="inc qtybutton">+</div>
                                            <div class="dec qtybutton"><i class="fa fa-minus"></i></div>
                                            <div class="inc qtybutton"><i class="fa fa-plus"></i></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="pro-subtotal"><span>$295.00</span></td>
                                <td class="pro-remove"><a href="#"><i class="pe-7s-trash"></i></a></td>
                            </tr>
                            <tr>
                                <td class="pro-thumbnail"><a href="#"><img class="img-fluid" src="assets/images/products/small-product/4.jpg" alt="Product" /></a></td>
                                <td class="pro-title"><a href="#">Simple Woven Fabrics</a></td>
                                <td class="pro-price"><span>$60.00</span></td>
                                <td class="pro-quantity">
                                    <div class="quantity">
                                        <div class="cart-plus-minus">
                                            <input class="cart-plus-minus-box" value="2" type="text">
                                            <div class="dec qtybutton">-</div>
                                            <div class="inc qtybutton">+</div>
                                            <div class="dec qtybutton"><i class="fa fa-minus"></i></div>
                                            <div class="inc qtybutton"><i class="fa fa-plus"></i></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="pro-subtotal"><span>$110.00</span></td>
                                <td class="pro-remove"><a href="#"><i class="pe-7s-trash"></i></a></td>
                            </tr>
>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19
                        </tbody>
                        <!-- Table Body End -->

                    </table>
                </div>
                <!-- Cart Table End -->

                <!-- Cart Update Option Start -->
                <div class="cart-update-option d-block d-md-flex justify-content-between">

                    <!-- Apply Coupon Wrapper Start -->
                    <div class="apply-coupon-wrapper">
<<<<<<< HEAD
                        <form action="#" method="post" class="d-block d-md-flex">
                            <input type="text" placeholder="Nhập mã giảm giá của bạn" required />
                            <button class="btn btn-dark btn-hover-primary rounded-0">Áp dụng mã</button>
=======
                        <form action="#" method="post" class=" d-block d-md-flex">
                            <input type="text" placeholder="Enter Your Coupon Code" required />
                            <button class="btn btn-dark btn-hover-primary rounded-0">Apply Coupon</button>
>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19
                        </form>
                    </div>
                    <!-- Apply Coupon Wrapper End -->

                    <!-- Cart Update Start -->
                    <div class="cart-update mt-sm-16">
<<<<<<< HEAD
                        <a href="#" class="btn btn-dark btn-hover-primary rounded-0">Cập nhật giỏ hàng</a>
=======
                        <a href="#" class="btn btn-dark btn-hover-primary rounded-0">Update Cart</a>
>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19
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
<<<<<<< HEAD
                        <h3 class="title">Tổng giỏ hàng</h3>
=======
                        <h3 class="title">Cart Totals</h3>
>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19
                        <!-- Cart Calculate Items Title End -->

                        <!-- Responsive Table Start -->
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
<<<<<<< HEAD
                                    <td>Tổng phụ</td>
                                    <td class="sub-total">{{ number_format($subTotal, 0, ',', '.') }} đ</td>
                                </tr>
                                <tr>
                                    <td>Phí vận chuyển</td>
                                    <td>{{ number_format(30000, 0, ',', '.') }} đ</td> <!-- Hiển thị phí vận chuyển -->
                                </tr>
                                <tr class="total">
                                    <td>Tổng cộng</td>
                                    <td class="total-amount">
                                        {{ number_format($total, 0, ',', '.') }} đ
                                        <!-- Hiển thị tổng tiền bao gồm phí ship -->
                                    </td>
=======
                                    <td>Sub Total</td>
                                    <td>$230</td>
                                </tr>
                                <tr>
                                    <td>Shipping</td>
                                    <td>$70</td>
                                </tr>
                                <tr class="total">
                                    <td>Total</td>
                                    <td class="total-amount">$300</td>
>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19
                                </tr>
                            </table>
                        </div>
                        <!-- Responsive Table End -->

                    </div>
                    <!-- Cart Calculate Items End -->

<<<<<<< HEAD
                    <!-- Cart Checkout Button Start -->
                    <a href="{{ route('orders.create') }}" class="btn btn-dark btn-hover-primary rounded-0 w-100">Tiến
                        hành thanh toán</a>
                    <!-- Cart Checkout Button End -->
=======
                    <!-- Cart Checktout Button Start -->
                    <a href="checkout.html" class="btn btn-dark btn-hover-primary rounded-0 w-100">Proceed To Checkout</a>
                    <!-- Cart Checktout Button End -->
>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19

                </div>
                <!-- Cart Calculation Area End -->

            </div>
        </div>

    </div>
</div>
<!-- Shopping Cart Section End -->
<<<<<<< HEAD

=======
>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19
<!-- Scroll Top Start -->
<a href="#" class="scroll-top" id="scroll-top">
    <i class="arrow-top fa fa-long-arrow-up"></i>
    <i class="arrow-bottom fa fa-long-arrow-up"></i>
</a>
<!-- Scroll Top End -->
<<<<<<< HEAD
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {

    var shippingFee = 30000; // Phí vận chuyển 30000 đồng

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

                    // Update the subtotal for this product
                    var subtotalCell = inputField.closest('tr').find('.subtotal-' + productDetailId);
                    var formattedSubtotal = response.item_price;  // Ensure price formatting here
                    subtotalCell.text(formattedSubtotal);

                    // Calculate the total for the cart
                    var subTotal = 0;
                    $('.pro-subtotal span').each(function() {
                        var currentSubtotal = $(this).text().replace(' đ', '').replace('.', '').trim();
                        subTotal += parseFloat(currentSubtotal);
                    });

                    // Update the displayed totals
                    $('.sub-total').text(subTotal.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, '.') + ' đ');
                    $('.total-amount').text((subTotal + shippingFee).toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, '.') + ' đ');
                }
            },
            error: function() {
                alert('Có lỗi xảy ra khi cập nhật giỏ hàng. Vui lòng thử lại.');
            }
        });
    });
});
</script>

=======
>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19
@endsection