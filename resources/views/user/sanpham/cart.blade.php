@extends('layouts.home')
@section('css')
<style>

</style>
@endsection
@section('content')
<!-- Breadcrumb Section Start -->
<div class="section">

    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb">
        <a href="http://datn_wd13.test/"><i class="fa fa-home"></i> Trang Chủ</a>
        <span class="breadcrumb-separator"> > </span>
        <span><a href="http://datn_wd13.test/cart">Giỏ hàng</a></span>
    </div>


    <!-- Breadcrumb Area End -->

</div>
<!-- Breadcrumb Section End -->

<!-- Shopping Cart Section Start -->
<div class="section section-margin">
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
            <div class="col-12">

                <!-- Kiểm tra giỏ hàng trống -->
                @if (empty($cartItems) || count($cartItems) === 0)
                <div class=" text-center">
                    <img src="{{ asset('ngdung/assets/images/cart/empty-cart1.png')}}" alt="Giỏ hàng trống"
                        style="max-width: 400px; margin-bottom: 20px;">
                    <p>Giỏ hàng của bạn đang trống. <a href="{{ route('home.index') }}">Tiếp tục mua sắm</a>.</p>
                </div>
                @else

                <!-- Cart Table Start -->
                <div class="cart-table table-responsive">
                    <table class="table table-bordered">

                        <!-- Table Head Start -->
                        <thead>
                            <tr>    
                                <th class="pro-select">
                                    <input type="checkbox" id="select-all" style="display: block;"> 
                                </th>
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
                            @foreach ($cartItems as $index => $item)
                            <tr>
                                <td class="pro-select">
                                <input type="checkbox" class="product-checkbox"   data-index="{{ $index }}"
                                        style="display: block;">
                                </td>
                                <td class="pro-thumbnail">
                                    <a href="#"><img class="img-fluid" src="{{ url('storage/'. $item['image']) }}"
                                            height="auto" width="60" alt="Product" /></a>
                                </td>
                                <td class="pro-title">
                                    <a href="{{ route('product.show', $item['slug']) }}">
                                        {{ $item['name'] }}<br>
                                        @foreach ($item['attributes'] as $attribute)

                                        {{ $attribute['value'] }}{{ !$loop->last ? ' / ' : '' }}
                                        @endforeach
                                    </a>
                                </td>
                                <td class="pro-price"><span>{{ number_format($item['price'] ?? 0, 0, ',', '.') }}
                                        đ</span></td>
                                <td class="pro-quantity">
                                    <div class="quantity">
                                        <div class="cart-plus-minus" style="margin-left: 15px;">
                                            <input class="cart-plus-minus-box" value="{{ $item['quantity'] }}"
                                                type="text" data-id="{{ $item['variant_id'] }}"
                                                data-available-quantity="{{ $item['stock_quantity'] }}"
                                                data-product-id="{{ $item['product_id'] }}" readonly>
                                            <!-- Lưu product_id ở đây -->
                                            <div class="dec qtybutton"
                                                data-id="{{ $item['variant_id'] }}"
                                                data-product-id="{{ $item['product_id'] }}">-
                                                <!-- Lưu product_id ở đây -->
                                            </div>
                                            <div class="inc qtybutton"
                                                data-id="{{ $item['variant_id'] }}"
                                                data-product-id="{{ $item['product_id'] }}">+
                                                <!-- Lưu product_id ở đây -->
                                            </div>
                                        </div>
                                    </div>

                                </td>
                                <td class="pro-subtotal">
                                    <span class="subtotal-{{ $item['variant_id'] ?? $item['product_id'] }} subtotal-{{ $index }}">
                                        {{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 0), 0, ',', '.') }}
                                        đ
                                    </span>
                                </td>
                                <td class="pro-remove">
                                    <form id="delete-form-{{ $item['variant_id'] ?? $item['product_id'] }}"
                                        action="{{ route('cart.remove', ['productId' => $item['product_id'], 'variantId' => $item['variant_id'] ?? null]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="pe-7s-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                        <!-- Table Body End -->

                    </table>
                </div>
                @endif

            </div>
        </div>

        @if (!empty($cartItems) && count($cartItems) > 0)
        <div class="row">
            <div class="col-lg-5 ms-auto col-custom">

                <!-- Cart Calculation Area Start -->
                <div class="cart-calculator-wrapper">
                    <div class="cart-calculate-items">

                        <!-- Cart Calculate Items Title Start -->
                        <!-- <h3 class="title">Tổng giỏ hàng</h3> -->
                        <!-- Cart Calculate Items Title End -->

                        <!-- Responsive Table Start -->
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <td>Tổng giỏ hàng</td>
                                    <td class="sub-total">0 đ</td>
                                </tr>

                            </table>
                        </div>
                        <!-- Responsive Table End -->

                    </div>
                    <button id="proceed-to-checkout" class="btn btn-dark btn-hover-primary rounded-0 w-100">Tiến
                        hành thanh toán</button>
                </div>

                <!-- Cart Calculation Area End -->

            </div>
        </div>
        @endif

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
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        // Cập nhật tổng tiền các sản phẩm được chọn
        function updateSelectedTotal() {
            var total = 0;

            // Lặp qua các sản phẩm được chọn
            $('.product-checkbox:checked').each(function () {
                var index = $(this).data('index'); // Lấy index của sản phẩm
                var subtotalText = $('.subtotal-' + index).text(); // Tìm tổng tiền của sản phẩm
                var subtotal = parseFloat(subtotalText.replace(' đ', '').replace(/\./g, '').replace(/,/g, '')); // Chuyển đổi chuỗi thành số
                total += subtotal;
            });

            // Hiển thị tổng tiền đã chọn
            $('.sub-total').text(total.toLocaleString('vi-VN') + ' đ');
        }

        // Khi checkbox được chọn hoặc bỏ chọn
        $('.product-checkbox').on('change', function () {
            updateSelectedTotal(); // Cập nhật tổng tiền khi trạng thái checkbox thay đổi
        });

        // Khi checkbox "Chọn tất cả" được chọn hoặc bỏ chọn
        $('#select-all').on('change', function () {
            var isChecked = $(this).is(':checked'); // Kiểm tra trạng thái của checkbox "Chọn tất cả"
            $('.product-checkbox').prop('checked', isChecked); // Đặt trạng thái cho tất cả checkbox trong tbody
            updateSelectedTotal(); // Cập nhật tổng tiền
        });

        // Cập nhật số lượng khi nhấn dấu cộng hoặc trừ
        $('.qtybutton').on('click', function () {
            var $button = $(this);
            var $input = $button.siblings('input');
            var quantity = parseInt($input.val());
            var availableQuantity = parseInt($input.data('available-quantity'));

            // Lấy variant_id và product_id từ data-id và data-product-id
            var variantId = $input.data('id');
            var productId = $button.data('product-id'); // Lấy product_id từ data-product-id của nút

            var $subtotal = $('.subtotal-' + variantId);

            // Lấy giá trị giá của sản phẩm từ cột Giá (pro-price)
            var priceText = $button.closest('tr').find('.pro-price span').text();
            // Xóa " đ" và dấu phẩy nếu có
            var price = parseFloat(priceText.replace(' đ', '').replace(/,/g, ''));

            if ($button.hasClass('inc')) {
                if (quantity < availableQuantity) {
                    quantity++;
                } else {
                    Swal.fire({
                        title: 'Thông báo',
                        text: 'Số lượng tối đa bạn có thể mua là ' + availableQuantity + '.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return; // Dừng lại nếu vượt quá giới hạn
                }
            } else if ($button.hasClass('dec')) {
                if (quantity > 1) {
                    quantity--;
                } else {
                    Swal.fire({
                        title: 'Thông báo',
                        text: 'Số lượng tối thiểu là 1 sản phẩm.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return; // Dừng lại nếu số lượng là 1
                }
            }

            // Cập nhật số lượng trong input
            $input.val(quantity);

            // Tính toán lại subtotal (số tiền của sản phẩm sau khi thay đổi số lượng)
            var subtotal = price * quantity;
            $subtotal.text(subtotal.toLocaleString('vi-VN') + '.000' + ' đ');

            // Gửi AJAX cập nhật số lượng
            $.ajax({
                url: "{{ route('cart.update') }}", // Đảm bảo route này đúng
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    product_id: productId,
                    variant_id: variantId,
                    quantity: quantity
                },
                success: function (response) {
                    if (response.success) {
                        updateSelectedTotal(); // Cập nhật tổng tiền sau khi cập nhật số lượng
                    } else {
                        Swal.fire('Thông báo', response.message, 'error');
                    }
                },
                error: function () {
                    Swal.fire('Lỗi', 'Có lỗi xảy ra, vui lòng thử lại!', 'error');
                }
            });
        });

        // Khi nhấn nút "Tiến hành thanh toán"
        $('#proceed-to-checkout').on('click', function () {
            var selectedIndexes = [];
            $('.product-checkbox:checked').each(function () {
                var index = $(this).data('index'); // Lấy chỉ số sản phẩm được chọn
                selectedIndexes.push(index);
            });

            if (selectedIndexes.length === 0) {
                Swal.fire('Thông báo', 'Bạn chưa chọn sản phẩm nào!', 'warning');
                return;
            }

            // Gửi danh sách chỉ số qua AJAX
            $.ajax({
                url: "{{ route('cart.move.to.selected') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    indexes: selectedIndexes
                },
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            title: 'Thành công',
                            text: 'Chuyển sản phẩm thành công!',
                            icon: 'success',
                            timer: 1000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = "{{ route('orders.create') }}";
                        });
                    } else {
                        Swal.fire('Thông báo', response.message, 'error');
                    }
                },
                error: function () {
                    Swal.fire('Lỗi', 'Có lỗi xảy ra, vui lòng thử lại!', 'error');
                }
            });
        });

        // Xử lý tải lại trang khi người dùng quay lại từ cache
        window.addEventListener('pageshow', function (event) {
            if (event.persisted) { // Trang được tải từ cache
                location.reload(); // Tải lại trang để đảm bảo dữ liệu mới nhất
            }
        });
    });
</script>


@endsection