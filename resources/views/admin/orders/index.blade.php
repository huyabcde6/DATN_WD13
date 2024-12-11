@extends('layouts.admin')

@section('title')
Quản lý đơn hàng
@endsection

@section('content')
@if (session()->has('error'))
<div class="alert alert-danger">
    {{ session()->get('error') }}
</div>
@endif

@if (session()->has('success'))
<div class="alert alert-success">
    {{ session()->get('success') }}
</div>
@endif

<div class="row m-3">
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Danh sách đơn hàng</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="d-flex m-3 justify-content-between align-items-center">
                    <form action="{{ route('admin.orders.index') }}" class="d-flex" method="get" id="search-form">
                        <div class="input-group">
                            <span class="input-group-text">
                                Tìm kiếm
                            </span>
                            <input type="text" value="{{ request('search') }}" name="search" id="search"
                                class="form-control" placeholder="Nhập từ khóa cần tìm..">
                            <button type="submit" class="btn btn-sm btn-dark"><i class="bi bi-search"></i></button>
                        </div>
                    </form>
                    <form action="{{ route('admin.orders.index') }}" method="get" class="ms-2">
                        <div class="d-flex justify-content-between">
                            <!-- Lọc theo ngày -->

                            <input type="date" name="from_date" id="from_date" class="form-control"
                                value="{{ request('from_date') }}">

                            <input type="date" name="to_date" id="to_date" class="form-control"
                                value="{{ request('to_date') }}">

                            <select name="status_donhang_id" id="status_donhang_id" class="form-select">
                                <option value="">Chọn trạng thái</option>
                                @foreach($statuses as $status)
                                <option value="{{ $status->id }}"
                                    {{ request('status_donhang_id') == $status->id ? 'selected' : '' }}>
                                    {{ $status->type }}
                                </option>
                                @endforeach
                            </select>

                            <select name="method" id="method" class="form-select">
                                <option value="">Chọn phương thức</option>
                                <option value="COD" {{ request('method') == 'COD' ? 'selected' : '' }}>COD</option>
                                <option value="credit_card" {{ request('method') == 'credit_card' ? 'selected' : '' }}>
                                    Thẻ tín dụng</option>
                                <option value="paypal" {{ request('method') == 'paypal' ? 'selected' : '' }}>PayPal
                                </option>
                                <option value="momo" {{ request('method') == 'momo' ? 'selected' : '' }}>Momo
                                </option>
                            </select>

                            <select name="payment_status" id="payment_status" class="form-select">
                                <option value="">Chọn trạng thái thanh toán</option>
                                <option value="chưa thanh toán"
                                    {{ request('payment_status') == 'chưa thanh toán' ? 'selected' : '' }}>Chưa
                                    thanh toán</option>
                                <option value="đã thanh toán"
                                    {{ request('payment_status') == 'đã thanh toán' ? 'selected' : '' }}>Đã thanh
                                    toán</option>
                                <option value="đang xử lý"
                                    {{ request('payment_status') == 'đang xử lý' ? 'selected' : '' }}>Đang xử lý
                                </option>
                                <option value="thất bại"
                                    {{ request('payment_status') == 'thất bại' ? 'selected' : '' }}>Thất bại
                                </option>
                                <option value="đã hoàn lại"
                                    {{ request('payment_status') == 'đã hoàn lại' ? 'selected' : '' }}>Đã hoàn lại
                                </option>
                            </select>
                            <button type="submit" class="btn btn-dark">Lọc</button>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>
                                    <a
                                        href="{{ request()->fullUrlWithQuery(['sort' => 'id', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                                        #
                                    </a>
                                </th>
                                <th>
                                    <a
                                        href="{{ request()->fullUrlWithQuery(['sort' => 'order_code', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                                        Mã đơn hàng
                                    </a>
                                </th>
                                <th>
                                    <a
                                        href="{{ request()->fullUrlWithQuery(['sort' => 'user_name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                                        Người nhận
                                    </a>
                                </th>
                                <th>SĐT</th>
                                <th>
                                    <a
                                        href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                                        Ngày tạo
                                    </a>
                                </th>
                                <th>Tổng tiền</th>
                                <th>Hình thức thanh toán</th>
                                <th>Trạng thái thanh toán</th>
                                <th>Trạng thái</th>
                                <th>Tương tác</th>
                            </tr>
                        </thead>

                        <tbody id="order-list">
                            @foreach($orders as $key => $order)
                            <tr data-order-id="{{ $order->id }}">
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $order->order_code }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>{{ $order->number_phone }}</td>
                                <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                <td>{{ number_format($order->total_price, 0, ',', '.') }} đ</td>
                                <td>{{ $order->method }}</td>
                                <td>{{ $order->payment_status }}</td>
                                <td>
                                    <span id="order-{{$order->id}}" class="badge {{ $order->status->getStatusColor() }}"
                                        style="height: 20px; line-height: 11px; font-size: 11px;">
                                        {{ $order->status->type }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                        class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1 "
                                        data-bs-toggle="tooltip" title="Xem">
                                        <i class="mdi mdi-eye "></i>
                                    </a>
                                    <button class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1"
                                        data-bs-toggle="modal" data-bs-target="#orderStatusModal"
                                        data-order-id="{{ $order->id }}"
                                        data-current-status="{{ $order->status_donhang_id }}"
                                        data-return-reason="{{ $order->return_reason }}">
                                        <i class="fa fa-pencil-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{ $orders->links('pagination::bootstrap-5') }}
    </div>
</div>

<!-- Modal sửa trạng thái đơn hàng -->
<div class="modal fade" id="orderStatusModal" tabindex="-1" aria-labelledby="orderStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderStatusModalLabel">Chỉnh sửa trạng thái đơn hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.orders.update', $order->id) }}" method="post" class="order-status-form" data-ajax="true">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="status">Trạng thái</label>
                        <select class="form-select" name="status" id="status" required>
                            @if($order->status_donhang_id === 1) <!-- Chờ xác nhận -->
                                <option value="2">Đã xác nhận</option>
                                <option value="7">Hủy đơn</option>
                            @elseif($order->status_donhang_id === 2) <!-- Đã xác nhận -->
                                <option value="3">Đang vận chuyển</option>
                            @elseif($order->status_donhang_id === 3) <!-- Đang vận chuyển -->
                                <option value="4">Đã giao hàng</option>
                            @elseif($order->status_donhang_id === 8) <!-- Chờ xác nhận hoàn hàng -->
                                <option value="6">Hoàn hàng</option>
                            @else
                                <option value="1" {{ $order->status_donhang_id === 1 ? 'selected' : '' }}>Chờ xác nhận</option>
                                <option value="2" {{ $order->status_donhang_id === 2 ? 'selected' : '' }}>Đã xác nhận</option>
                                <option value="3" {{ $order->status_donhang_id === 3 ? 'selected' : '' }}>Đang vận chuyển</option>
                                <option value="4" {{ $order->status_donhang_id === 4 ? 'selected' : '' }}>Đã giao hàng</option>
                                <option value="5" {{ $order->status_donhang_id === 5 ? 'selected' : '' }}>Hoàn thành</option>
                                <option value="6" {{ $order->status_donhang_id === 6 ? 'selected' : '' }}>Hoàn hàng</option>
                                <option value="8" {{ $order->status_donhang_id === 8 ? 'selected' : '' }}>Chờ xác nhận hoàn hàng</option>
                                <option value="7" {{ $order->status_donhang_id === 7 ? 'selected' : '' }}>Hủy đơn</option>
                            @endif
                        </select>
                    </div>

                    <!-- Phần lý do trả hàng nếu trạng thái là "Chờ xác nhận hoàn hàng" -->
                    @if($order->status_donhang_id === 8)
                    <div class="mt-2">
                        <label for="return_reason">Lý do trả hàng</label>
                        <textarea name="return_reason" id="return_reason"
                            class="form-control">{{ old('return_reason', $order->return_reason) }}</textarea>
                    </div>
                    @endif

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@vite('resources/js/public.js');

@vite('resources/js/adminoder.js');

@endsection

@section('js')
<script>
    window.Echo.channel('order-updated')
        .listen('.order.updated', (e) => {
            const orderRow = document.querySelector(`[data-order-id="${e.order.id}"]`);
            if (orderRow) {
                orderRow.querySelector('select[name="status"]').value = e.order.status_donhang_id;
            }
        });
</script>
<script>
    var orderStatusModal = document.getElementById('orderStatusModal');
    orderStatusModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget; // Nút bấm "Sửa" được nhấn
        var orderId = button.getAttribute('data-order-id'); // Lấy ID của đơn hàng
        var currentStatus = parseInt(button.getAttribute('data-current-status')); // Lấy trạng thái hiện tại
        var returnReason = button.getAttribute('data-return-reason'); // Lấy lý do trả hàng (nếu có)

        // Cập nhật lại action của form trong modal
        var form = orderStatusModal.querySelector('form');
        form.action = `/admin/orders/${orderId}`; // Đảm bảo action chứa đúng ID của đơn hàng

        // Lấy dropdown trạng thái và làm sạch các tùy chọn cũ
        var statusSelect = orderStatusModal.querySelector('#status');
        statusSelect.innerHTML = ''; // Xóa toàn bộ các tùy chọn

        // Tùy chọn trạng thái dựa trên trạng thái hiện tại
        if (currentStatus === 1) {
            // Nếu trạng thái là "Chờ xác nhận", chỉ hiển thị 2 tùy chọn
            statusSelect.innerHTML += `<option value="2">Đã xác nhận</option>`;
            statusSelect.innerHTML += `<option value="7">Hủy đơn</option>`;
        } else if (currentStatus === 2) {
            statusSelect.innerHTML += `<option value="3">Đang vận chuyển</option>`;
        } else if (currentStatus === 3) {
            statusSelect.innerHTML += `<option value="4">Đã giao hàng</option>`;
        } else if (currentStatus === 8) {
            statusSelect.innerHTML += `<option value="6">Hoàn hàng</option>`;
        } else {
            var options = [
                { value: 1, text: 'Chờ xác nhận' },
                { value: 2, text: 'Đã xác nhận' },
                { value: 3, text: 'Đang vận chuyển' },
                { value: 4, text: 'Đã giao hàng' },
                { value: 5, text: 'Hoàn thành' },
                { value: 6, text: 'Hoàn hàng' },
                { value: 8, text: 'Chờ xác nhận hoàn hàng' },
                { value: 7, text: 'Hủy đơn' }
            ];

            options.forEach(function(option) {
                statusSelect.innerHTML += `<option value="${option.value}" ${
                    option.value === currentStatus ? 'selected' : ''
                }>${option.text}</option>`;
            });
        }

        // Cập nhật textarea lý do trả hàng
        var returnReasonTextarea = orderStatusModal.querySelector('#return_reason');
        returnReasonTextarea.value = returnReason || '';

        // Hiển thị hoặc ẩn textarea lý do trả hàng nếu trạng thái là "Chờ xác nhận hoàn hàng"
        if (currentStatus === 8) {
            returnReasonTextarea.closest('.form-group').style.display = 'block';
        } else {
            returnReasonTextarea.closest('.form-group').style.display = 'none';
        }
    });
</script>

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
@endsection