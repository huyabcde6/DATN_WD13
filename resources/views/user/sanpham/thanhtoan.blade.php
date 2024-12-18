@extends('layouts.home')
@section('css')
<style>
.your-order-area {
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 8px;
}

.your-order-table th,
.your-order-table td {
    vertical-align: middle;
    padding: 10px;
}

.your-order-table th {
    background-color: #343a40;
    color: #fff;
    font-weight: 500;
}

.your-order-table td {
    background-color: #fff;
}

.cart-update-option {
    margin-top: 20px;
    gap: 10px;
}

.apply-coupon-wrapper input {
    max-width: 300px;
    border-radius: 0;
    margin-right: 10px;
}

.order-button-payment button {
    font-weight: bold;
}

.single-payment {
    border: 1px solid #dee2e6;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 10px;
    background-color: #fff;
}

.payment-accordion-order-button {
    margin-top: 20px;
}
</style>

@endsection
@section('content')
<!-- Breadcrumb Section Start -->
<div class="section">

    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb">
        <a href="http://datn_wd13.test/"><i class="fa fa-home"></i> Trang Chủ</a>
        <span class="breadcrumb-separator"> > </span>
        <span><a href="http://datn_wd13.test/orders/create">Thanh toán</a></span>
    </div>
    <!-- Breadcrumb Area End -->

</div>
<!-- Breadcrumb Section End -->

<!-- Checkout Section Start -->
<div class="section section-margin">
    <div class="container">
        <div class=" mt-4">
            <div class="apply-coupon-wrapper d-flex">
                <form id="voucher-form" action="{{ route('vocher') }}" method="post" class="d-flex">
                    @csrf
                    @method ('POST')
                    <input type="hidden" name="total" value="{{ $total }}">
                    @foreach ($cartItems as $item)
                    <input type="hidden" name="id_sp[]" value="{{$item['product_id']}}">
                    @endforeach
                    <input type="text" name="voucher" class="form-control" placeholder="Nhập mã giảm giá" />
                    <button id="apply-voucher" class="btn btn-dark btn-hover-primary rounded-0 ms-2" style="margin:0px">Áp dụng
                        mã</button>
                </form>
            </div>
            <div id="voucher-message" class="mt-3"></div>
        </div>
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
                                    <input placeholder="" type="text" name="nguoi_nhan"
                                        value="{{ Auth::user()->name }}">
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
                                    <input type="text" placeholder="number phone" name="number_phone"
                                        value="{{ Auth::user()->number_phone }}">
                                </div>
                            </div>

                            <!-- Address Input Start -->
                            <div class="col-md-12">
                                <div class="checkout-form-list">
                                    <label>Địa chỉ <span class="required">*</span></label>
                                    <input placeholder="Street address" name="address" type="text"
                                        value="{{ Auth::user()->address }}">
                                </div>
                            </div>

                            <!-- Order Notes Start -->
                            <div class="order-notes mt-3 mb-n2">
                                <div class="checkout-form-list checkout-form-list-2">
                                    <label>Ghi chú đặt hàng</label>
                                    <textarea id="checkout-mess" name="ghi_chu" cols="30" rows="10"
                                        placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
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
                        <div class="your-order-table table-responsive" >
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="cart-product-name text-start" style="background-color: #ffffff; color: #000000;">Sản phẩm</th>
                                        <th class="cart-product-total text-end" style="background-color: #ffffff; color: #000000;">Tổng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cartItems as $item)
                                    <tr>
                                        @if (!empty($item['product_avata']))
                                        <img src="{{ asset('storage/' . $item['product_avata']) }}" alt="Product Image">
                                        @endif

                                        <td class="cart-product-name text-start">
                                            <a href="{{ route('product.show', $item['product_id']) }}">
                                                {{ $item['product_name'] }}
                                            </a>
                                            <strong> × {{ $item['quantity'] }}</strong>
                                        </td>
                                        <td class="cart-product-total text-end">
                                            {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}₫
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-start" style="background-color: #ffffff; color: #000000;">Tổng phụ</th>
                                        <td class="text-end" >{{ number_format($subTotal, 0, ',', '.') }} ₫</td>
                                        <input type="hidden" name="subtotal" value="{{ $subTotal }}">
                                    </tr>
                                    <tr>
                                        <th class="text-start" style="background-color: #ffffff; color: #000000;">Mã giảm giá</th>
                                        <td class="text-end" id="discount-display">0 ₫</td>
                                        <input type="hidden" id="discount-input" name="discount" value="0">
                                    </tr>
                                    <tr>
                                        <th class="text-start" style="background-color: #ffffff; color: #000000;">Phí vận chuyển</th>
                                        <td class="text-end">{{ number_format($shippingFee, 0, ',', '.') }} ₫</td>
                                        <input type="hidden" name="shipping_fee" value="{{ $shippingFee }}">
                                    </tr>
                                    <tr>
                                        <th class="text-start" style="background-color: #ffffff; color: #000000;">Tổng cộng</th>
                                        <td class="text-end"><strong
                                                id="total-display">{{ number_format($total, 0, ',', '.') }} ₫</strong>
                                        </td>
                                        <input type="hidden" id="total-input" name="total_price" value="{{ $total }}">
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                    <!-- Your Order Area End -->
                    <!-- Payment Method Start -->
                    <div class="checkout-payment mt-3">
                        <h3 class="checkout-title">Phương thức thanh toán</h3>
                        <div class="block-border">
                            <p>Mọi giao dịch đều được bảo mật và mã hóa. Thông tin thanh toán sẽ không bao giờ được lưu
                                lại.</p>
                            <div class="d-flex flex-column">
                                <div class="d-flex align-items-center mb-2">
                                    <input type="radio" name="method" value="COD" id="cod">
                                    <input type="hidden" name="mua" value="{{$mua}}">
                                    @if($mua === 'muangay')
                                    @foreach ($cartItems as $item)
                                    <input type="hidden" name="product_detail_id"
                                        value="{{ $item['product_detail_id'] }}">
                                    <input type="hidden" name="size" value="{{ $item['size'] }}">
                                    <input type="hidden" name="color" value="{{ $item['color'] }}">
                                    <input type="hidden" name="quantity" value="{{ $item['quantity'] }}">
                                    <input type="hidden" name="product_name" value="{{ $item['product_name'] }}">
                                    <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
                                    <input type="hidden" name="price" value="{{ $item['price'] }}">
                                    <input type="hidden" name="image" value="{{ $item['image'] }}">
                                    @endforeach
                                    @endif
                                    <label for="cod" class="ms-2">Thanh toán khi nhận hàng</label>
                                </div>
                                <div class="d-flex align-items-center">
                                    <input type="radio" name="method" value="VNPAY" id="vnpay">
                                    <input type="hidden" name="mua" value="{{$mua}}">
                                    @if($mua === 'muangay')
                                    @foreach ($cartItems as $item)
                                    <input type="hidden" name="product_detail_id"
                                        value="{{ $item['product_detail_id'] }}">
                                    <input type="hidden" name="size" value="{{ $item['size'] }}">
                                    <input type="hidden" name="color" value="{{ $item['color'] }}">
                                    <input type="hidden" name="quantity" value="{{ $item['quantity'] }}">
                                    <input type="hidden" name="product_name" value="{{ $item['product_name'] }}">
                                    <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
                                    <input type="hidden" name="price" value="{{ $item['price'] }}">
                                    <input type="hidden" name="image" value="{{ $item['image'] }}">
                                    @endforeach
                                    @endif
                                    <label for="vnpay" class="ms-2">Thanh toán bằng VNPAY</label>
                                </div>
                            </div>
                        </div>
                    </div><br>
                    <div class="order-button-payment">
                        <button type="submit" class="btn btn-dark btn-hover-primary rounded-0 w-100">Đặt Hàng</button>
                    </div>
                </div>
                <!-- Payment Method End -->
            </div>


    </div>
    </form>
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

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Lấy form và nút "Áp dụng mã"
    const voucherForm = document.getElementById('voucher-form');
    const voucherInput = document.querySelector('input[name="voucher"]');
    const applyVoucherButton = document.getElementById('apply-voucher');
    const voucherMessage = document.getElementById('voucher-message');
    const discountDisplay = document.getElementById('discount-display');
    const totalDisplay = document.getElementById('total-display');
    const discountInput = document.getElementById('discount-input');
    const totalinput = document.getElementById('total-input');

    voucherForm.addEventListener('submit', function(e) {
        e.preventDefault(); // Ngăn chặn form submit mặc định

        // Lấy giá trị mã giảm giá từ input
        const voucherCode = voucherInput.value;

        // Kiểm tra nếu voucher không rỗng
        if (voucherCode.trim() === '') {
            alert('Vui lòng nhập mã giảm giá.');
            return;
        }

        // Tạo FormData để gửi tất cả dữ liệu từ form
        const formData = new FormData(voucherForm);
        formData.append('voucher', voucherCode); // Thêm mã giảm giá vào FormData

        // Gửi AJAX để kiểm tra và áp dụng mã giảm giá
        fetch("{{ route('vocher') }}", {
                method: 'POST',
                body: formData, // Gửi dữ liệu dưới dạng FormData
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Kiểm tra nếu có lỗi
                if (data.error) {
                    voucherMessage.innerHTML =
                        `<div class="alert alert-danger">${data.error}</div>`;
                    discountDisplay.textContent = '0 ₫'; // Reset giá trị giảm giá
                    totalDisplay.textContent =
                        `{{ number_format($total, 0, ',', '.') }} ₫`; // Reset tổng giá trị
                    discountInput.value = 0;
                    totalinput.value = '{{ str_replace(".", "", $total) }}';
                } else {
                    // Hiển thị thông tin giảm giá
                    voucherMessage.innerHTML =
                        `<div class="alert alert-success">${data.message}</div>`;
                    discountDisplay.textContent = `${data.discount} ₫`;
                    totalDisplay.textContent = `${data.total} ₫`;
                    discountInput.value = data.discount.replace(/\./g, '');;
                    totalinput.value = data.total.replace(/\./g, '');;
                }
            })
            .catch(error => {
                console.error('Có lỗi xảy ra khi áp dụng mã:', error);
                voucherMessage.innerHTML =
                    `<div class="alert alert-danger">Đã xảy ra lỗi, vui lòng thử lại sau.</div>`;
            });
    });
});
</script>

@endsection