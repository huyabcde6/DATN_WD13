@foreach($orders as $order)
<div class="container">
    <div class="card mb-3">
        <div class="col-lg-12 mb-3">
            <div class="row mx-3 mt-2">
                <!-- Thẻ thông tin đơn hàng -->
                <div class="d-flex justify-content-between">
                    <h5 class="text-center">Mã đơn:
                        <span class="text-danger">{{ $order->order_code }}</span>
                    </h5>
                    <p id="order-status-{{ $order->id }}" class="text-center mx-3">{{ $order->status->type ?? 'N/A' }}</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p style="font-size: 14px;"><strong>Ngày đặt:</strong> {{ $order->created_at->format('d-m-Y') }}</p>
                    <p style="font-size: 14px;"><strong>Trạng thái thanh toán:</strong> <mark> {{ $order->payment_status }}</mark></p>
                </div>
            </div>

            <!-- Chi tiết sản phẩm đầu tiên -->
            @foreach($order->orderDetails as $index => $detail)
            @if($index === 0)
            <div class="card-body border">
                <div class="container d-flex justify-content-start align-items-center">
                    <!-- Hình ảnh sản phẩm -->
                    <div class="me-3">
                        <img src="{{ url('storage/'. $detail->product_avata) }}"
                            alt="{{ $detail->product_name }}" class="img-fluid"
                            style="max-width: 60px; height: auto;">
                    </div>
                    <!-- Thông tin sản phẩm -->
                    <div class="w-75">
                        <h6 class="mb-0 mx-3 text-start"><strong>Sản phẩm:</strong> {{ $detail->product_name }}</h6>
                        <p class="mb-0 mx-3 text-muted text-start" style="font-size: 14px;"><strong>Loại:</strong>
                            {{ $detail->color }} / {{ $detail->size }}
                        </p>
                        <p class="mb-0 mx-3 text-start" style="font-size: 14px;"><strong>Số lượng:</strong>
                            {{ $detail->quantity }}
                        </p>
                    </div>
                    <div class="w-75 d-flex justify-content-end">
                        <p class="mb-0 text-start" style="font-size: 14px;"><strong>Giá:</strong>
                            {{ number_format($detail->price, 0, '', ',') }}₫
                        </p>
                    </div>
                </div>
            </div>
            @endif
            @endforeach

            <!-- Các sản phẩm còn lại (ẩn mặc định) -->
            <div class="collapse" id="details-{{ $order->id }}">
                @foreach($order->orderDetails as $index => $detail)
                @if($index > 0)
                <div class="card-body border my-1">
                    <div class="container d-flex justify-content-start align-items-center">
                        <!-- Hình ảnh sản phẩm -->
                        <div class="me-3">
                            <img src="{{ url('storage/'. $detail->product_avata) }}"
                                alt="{{ $detail->product_name }}" class="img-fluid"
                                style="max-width: 60px; height: auto;">
                        </div>
                        <!-- Thông tin sản phẩm -->
                        <div class="w-75">
                            <h6 class="mb-0 mx-3 text-start"><strong>Sản phẩm:</strong> {{ $detail->product_name }}
                            </h6>
                            <p class="mb-0 mx-3 text-muted text-start" style="font-size: 14px;"><strong>Loại:</strong>
                                {{ $detail->color }} / {{ $detail->size }}
                            </p>
                            <p class="mb-0 mx-3 text-start" style="font-size: 14px;"><strong>Số lượng:</strong>
                                {{ $detail->quantity }}
                            </p>
                        </div>
                        <div class="w-75 d-flex justify-content-end">
                            <p class="mb-0 text-start" style="font-size: 14px;"><strong>Giá:</strong>
                                {{ number_format($detail->price, 0, '', ',') }}₫
                            </p>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>

            <!-- Nút Xem thêm -->
            @if($order->orderDetails->count() > 1)
            <div class="d-flex justify-content-start">
                <button class="btn btn-link toggle-details-btn" style="font-size: 13px;" data-bs-toggle="collapse"
                    data-bs-target="#details-{{ $order->id }}" aria-expanded="false"
                    aria-controls="details-{{ $order->id }}">
                    <span class="show-text" style="font-size: 12px;">Hiện/ẩn</span>
                    <span class="hide-text d-none" style="font-size: 12x;">Hiện/ẩn</span>
                </button>
            </div>
            @endif

            <!-- Tổng tiền -->
            <div class="d-flex justify-content-end mx-3 mb-3">
                <h6><strong>Tổng tiền:</strong>
                    {{ number_format($order->total_price, 0, ',', '.') }} đ
                </h6>
            </div>

            <!-- Nút chi tiết và hủy/nhận hàng -->
            <div class="d-flex justify-content-between">
                <div class=""><a href="{{ route('orders.show', $order->id) }}" class="btn btn-dark mx-5 py-3" style="margin-top:0px; font-size: 12px;">Chi
                tiết</a></div>
                
                <form id="confirm-order-{{ $order->id }}" action="{{ route('orders.update', $order->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('POST')
                    @if($order->status->type === \App\Models\StatusDonHang::CHO_XAC_NHAN)
                    <input type="hidden" name="huy_don_hang" value="1">
                    <button id="cancel-order-{{ $order->id }}" type="submit" class="btn btn-primary mx-3" style="font-size: 12px; margin-top: 19px;"
                        onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?');">Hủy đơn hàng</button>
                    @elseif($order->status->type === \App\Models\StatusDonHang::DA_GIAO_HANG)
                    <input type="hidden" name="hoan_thanh" value="5">
                    <button type="submit" class="btn btn-success mx-3" style="font-size: 12px; margin-top: 19px;"
                        onclick="return confirm('Bạn xác nhận đã nhận hàng?');">Xác nhận nhận hàng</button>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
<script>
    document.querySelectorAll('.toggle-details-btn').forEach(button => {
        button.addEventListener('click', () => {
            const showText = button.querySelector('.show-text');
            const hideText = button.querySelector('.hide-text');
            showText.classList.toggle('d-none');
            hideText.classList.toggle('d-none');
        });
    });
</script>