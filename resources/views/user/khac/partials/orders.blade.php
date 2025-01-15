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
                    <p id="order-status-{{ $order->id }}" class="text-center mx-3">{{ $order->status->type ?? 'N/A' }}
                    </p>
                </div>
                <div class="d-flex justify-content-between">
                    <p style="font-size: 14px;"><strong>Ngày đặt:</strong> {{ $order->created_at->format('d-m-Y') }}</p>
                    <p style="font-size: 14px;"><strong>Trạng thái thanh toán:</strong> <mark>
                            {{ $order->payment_status }}</mark></p>
                </div>
            </div>

            <!-- Chi tiết sản phẩm đầu tiên -->
            @foreach($order->orderDetails as $index => $detail)
            @if($index === 0)
            <div class="card-body border">
                <div class="container d-flex justify-content-start align-items-center">
                    <!-- Hình ảnh sản phẩm -->
                    <div class="me-3">
                        <img src="{{ url('storage/'. $detail->product_avata) }}" alt="{{ $detail->product_name }}"
                            class="img-fluid" style="max-width: 60px; height: auto;">
                    </div>
                    <!-- Thông tin sản phẩm -->
                    <div class="w-75">
                        <h6 class="mb-0 mx-3 text-start"><strong>Sản phẩm:</strong> {{ $detail->product_name }}</h6>
                        <p class="mb-0 mx-3 text-muted text-start" style="font-size: 14px;"><strong>Phân loại:</strong>
                            @foreach($detail->attributes as $attribute)

                            {{ $attribute['value'] }}{{ !$loop->last ? ' / ' : '' }}
                            @endforeach
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
                @if($order->status_donhang_id == 5)
                <div class="d-flex justify-content-end">
                    @if(in_array($order->product_id, $reviewedProductIds))
                    <span class="text-success mx-5">Đã đánh giá</span>
                    @else
                    <button type="button" class="btn btn-info btn-sm mx-5" data-bs-toggle="modal" data-bs-target="#commentModal"
                        data-product-name="{{ $detail->product_name }}">
                        Đánh giá
                    </button>
                    @endif
                </div>
                @endif
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
                            <img src="{{ url('storage/'. $detail->product_avata) }}" alt="{{ $detail->product_name }}"
                                class="img-fluid" style="max-width: 60px; height: auto;">
                        </div>
                        <!-- Thông tin sản phẩm -->
                        <div class="w-75">
                            <h6 class="mb-0 mx-3 text-start"><strong>Sản phẩm:</strong> {{ $detail->product_name }}
                            </h6>
                            <p class="mb-0 mx-3 text-muted text-start" style="font-size: 14px;"><strong>Phân loại:</strong>
                                @foreach($detail->attributes as $attribute)

                                {{ $attribute['value'] }}{{ !$loop->last ? ' / ' : '' }}
                                @endforeach
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

                    @if($order->status_donhang_id == 5)
                    <div class="d-flex justify-content-end">
                        @if(in_array($detail->product_id, $reviewedProductIds))
                        <button type="button" class="btn btn-secondary btn-sm mx-5" disabled>
                            Đã đánh giá
                        </button>
                        @else
                        <button type="button" class="btn btn-info btn-sm mx-5" data-bs-toggle="modal" data-bs-target="#commentModal"
                            data-product-name="{{ $detail->product_name }}">
                            Đánh giá
                        </button>
                        @endif
                    </div>
                    @endif
                </div>
                @endif

                @endforeach
            </div>

            <!-- Nút Xem thêm -->
            @if($order->orderDetails->count() > 1)
            <div class="d-flex justify-content-start">
                <button class="btn btn-link toggle-details-btn" style="font-size: 10px;" data-bs-toggle="collapse"
                    data-bs-target="#details-{{ $order->id }}" aria-expanded="false"
                    aria-controls="details-{{ $order->id }}">
                    <span class="show-text" style="font-size: 12px;">Hiện/ẩn</span>
                    <span class="hide-text d-none" style="font-size: 12x;">Hiện/ẩn</span>
                </button>
            </div>
            @endif

            <!-- Tổng tiền -->
            <div class="d-flex justify-content-end mx-3 mb-3 mt-2">
                <h6><strong>Tổng tiền:</strong>
                    {{ number_format($order->total_price, 0, ',', '.') }} đ
                </h6>
            </div>

            <!-- Nút chi tiết và hủy/nhận hàng -->
            <div class="d-flex justify-content-between">
                <div class=""><a href="{{ route('orders.show', $order->id) }}" class="btn btn-dark mx-5 py-3"
                        style="margin-top:0px; font-size: 12px;">Chi
                        tiết</a></div>

                <form id="confirm-order-{{ $order->id }}" action="{{ route('orders.update', $order->id) }}"
                    method="POST" style="display:inline;">
                    @csrf
                    @method('POST')
                    @if($order->status->type === \App\Models\StatusDonHang::CHO_XAC_NHAN)
                    <input type="hidden" name="huy_don_hang" value="1">
                    <button id="cancel-order-{{ $order->id }}" type="submit" class="btn btn-primary mx-3"
                        style="font-size: 12px; margin-top: 19px;"
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
<div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commentModalLabel">Đánh giá sản phẩm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('comment.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="product_name" id="modal-product-name">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="product-name"><strong>Tên sản phẩm:</strong></label>
                        <input type="text" id="modal-product-name-display" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="images">Chọn hình ảnh (Tối đa 3):</label>
                        <input type="file" name="images[]" id="images" class="form-control" accept="image/*" multiple>
                        <small class="text-muted">Chỉ được chọn tối đa 3 hình ảnh.</small>
                        <div id="preview-images" class="mt-3 d-flex flex-wrap"></div>
                    </div>

                    <div class="form-group">
                        <label for="comment">Nội dung:</label>
                        <textarea name="comment" id="comment" class="form-control" rows="4" required placeholder="Nhập bình luận của bạn vào đây."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Gửi bình luận</button>
                </div>
            </form>

        </div>
    </div>
</div>

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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const commentModal = document.getElementById('commentModal');
        commentModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const productName = button.getAttribute('data-product-name');
            const modalProductNameDisplay = document.getElementById('modal-product-name-display');
            modalProductNameDisplay.value = productName;
            const modalProductName = document.getElementById('modal-product-name');
            modalProductName.value = productName; // Gán giá trị product_name vào input
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gán sự kiện khi modal được hiển thị
        const commentModal = document.getElementById('commentModal');
        commentModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const productName = button.getAttribute('data-product-name');
            const modalProductNameDisplay = document.getElementById('modal-product-name-display');
            const modalProductName = document.getElementById('modal-product-name');

            modalProductNameDisplay.value = productName; // Hiển thị tên sản phẩm
            modalProductName.value = productName; // Gán giá trị cho input ẩn
        });

        // Hiển thị hình ảnh được chọn
        const imageInput = document.getElementById('images');
        const previewContainer = document.getElementById('preview-images');

        imageInput.addEventListener('change', function() {
            // Xóa nội dung cũ trong vùng preview
            previewContainer.innerHTML = '';

            // Lấy danh sách file
            const files = Array.from(this.files);

            // Kiểm tra số lượng file
            if (files.length > 3) {
                alert('Bạn chỉ được chọn tối đa 3 hình ảnh!');
                this.value = ''; // Reset input
                return;
            }

            // Hiển thị từng hình ảnh
            files.forEach(file => {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = 'Preview';
                    img.classList.add('img-thumbnail', 'me-2', 'mb-2');
                    img.style.width = '100px';
                    img.style.height = 'auto';
                    previewContainer.appendChild(img);
                };

                reader.readAsDataURL(file);
            });
        });
    });
</script>