@extends('layouts.home')

@section('content')
<!-- Breadcrumb Section Start -->
<div class="section">

    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb-area bg-light">
        <div class="container-fluid">
            <div class="breadcrumb-content text-center">
                <h1 class="title">Giỏ Hàng</h1>
                <ul>
                    <li>
                        <a href="/">Trang Chủ</a>
                    </li>
                    <li class="active">Giỏ Hàng</li>
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
                                <th class="pro-thumbnail">Hình ảnh</th>
                                <th class="pro-title">Sản phẩm</th>
                                <th class="pro-price">Giá</th>
                                <th class="pro-quantity">Số lượng</th>
                                <th class="pro-subtotal">Tổng</th>
                                <th class="pro-remove">Xóa</th>
                            </tr>
                        </thead>
                        <!-- Table Head End -->

                        <!-- Table Body Start -->
                        <tbody id="cartItems">
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
                        </tbody>
                        <!-- Table Body End -->

                    </table>
                </div>
                <!-- Cart Table End -->

                <!-- Cart Update Option Start -->
                <div class="cart-update-option d-block d-md-flex justify-content-between">

                    <!-- Apply Coupon Wrapper Start -->
                    <div class="apply-coupon-wrapper">
                        <form action="{{route ('vocher')}}" method="post" class="d-block d-md-flex">
                            @csrf
                            <input type="hidden" name="total" value="{{$total}}">
                            <input type="text" name="vocher" placeholder="Nhập mã giảm giá của bạn" required />
                            <button class="btn btn-dark btn-hover-primary rounded-0">Áp dụng mã</button>
                        </form>
                    </div>
                    <!-- Hiển thị lỗi dưới form -->
                    @if (session('vocher'))
                    <p class="text-success">{{ session('vocher') }}</p>
                    @endif

                    @if ($errors->has('vocher'))
                    <p class="text-danger">{{ $errors->first('vocher') }}</p>
                    @endif
                </div>
                <!-- Cart Update Option End -->

            </div>
        </div>

        <div class="row">
            <div class="col-lg-5 ms-auto col-custom">

                <!-- Cart Calculation Area Start -->
                <!-- Cart Calculation Area Start -->
                <div class="cart-calculator-wrapper">
                    <div class="cart-calculate-items">
                        <h3 class="title">Tổng giỏ hàng</h3>
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <td>Tổng phụ</td>
                                    <td class="sub-total">{{ number_format($subTotal, 0, ',', '.') }} đ</td>
                                </tr>
                                <tr>
                                    <td>Phí vận chuyển</td>
                                    <td class="shipping-fee">{{ number_format(30000, 0, ',', '.') }} đ</td>
                                </tr>
                                @if (session('discount_applied'))
                                <tr class="discount-row">
                                    <td>Mã giảm giá</td>
                                    <td class="discount-value">{{ number_format(session('discount_applied'), 0, ',', '.') }} đ</td>
                                </tr>
                                @endif
                                <tr class="total">
                                    <td>Tổng cộng</td>
                                    <td class="total-amount">
                                        @php
                                        $totalAfterDiscount = $subTotal + 30000 - session('discount_applied', 0);
                                        @endphp
                                        {{ number_format($totalAfterDiscount, 0, ',', '.') }} đ
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <a href="{{ route('orders.create') }}" class="btn btn-dark btn-hover-primary rounded-0 w-100">Tiến hành thanh toán</a>
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

                    // Cập nhật subtotal cho sản phẩm
                    var subtotalCell = inputField.closest('tr').find('.subtotal-' + productDetailId);
                    var formattedSubtotal = response.item_price; // Đảm bảo format giá
                    subtotalCell.text(formattedSubtotal);

                    // Tính toán lại tổng giỏ hàng
                    var subTotal = 0;
                    $('.pro-subtotal span').each(function() {
                        var currentSubtotal = $(this).text().replace(' đ', '').replace('.', '').trim();
                        subTotal += parseFloat(currentSubtotal);
                    });

                    // Cập nhật tổng số tiền hiển thị
                    $('.sub-total').text(subTotal.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, '.') + ' đ');
                    $('.total-amount').text((subTotal + shippingFee - session('discount_applied', 0)).toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, '.') + ' đ');
                }
            },
            error: function() {
                alert('Có lỗi xảy ra khi cập nhật giỏ hàng. Vui lòng thử lại.');
            }
        });
    });
</script>
<script>
    $('.pro-remove form').on('submit', function(event) {
        event.preventDefault(); // Ngừng hành động submit form mặc định

        var form = $(this);
        var productDetailId = form.find('button').data('id');

        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(), // Gửi dữ liệu form đi
            success: function(response) {
                if (response.status === 'success') {
                    // Cập nhật các giá trị trong giỏ hàng
                    $('.sub-total').text(response.sub_total);
                    $('.shipping-fee').text(response.shipping_fee);
                    $('.discount-value').text(response.discount_value);
                    $('.total-amount').text(response.total_after_discount);

                    // Xóa sản phẩm khỏi giao diện
                    form.closest('tr').remove(); // Xóa dòng sản phẩm khỏi bảng giỏ hàng
                } else {
                    alert(response.message); // Hiển thị thông báo lỗi nếu có
                }
            },
            error: function() {
                alert('Có lỗi xảy ra khi xóa sản phẩm. Vui lòng thử lại.');
            }
        });
    });
</script>
@endsection