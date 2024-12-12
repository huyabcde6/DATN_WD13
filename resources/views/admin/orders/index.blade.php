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
                <div class="d-flex m-3">
                    <form action="{{ route('admin.orders.index') }}" method="get" class="">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" value="{{ request('search') }}" name="search" id="search"
                                class="form-control" placeholder="Nhập mã đơn hàng..">
                            <button type="submit" class="btn btn-dark">Tìm kiếm</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-12">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Mã đơn hàng</th>
                                <th>Người nhận</th>
                                <th>SĐT</th>
                                <th>Ngày tạo</th>
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
                                    <span class="badge {{ $order->status->getStatusColor() }}"
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
        <div class="m-2">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
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
                <form action="{{ route('admin.orders.update', $order->id) }}" method="post" class="order-status-form">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="status">Trạng thái</label>
                        <select class="form-select" name="status" id="status" required>
                            <option value="1" {{ $order->status_donhang_id === 1 ? 'selected' : '' }}>Chờ xác nhận
                            </option>
                            <option value="2" {{ $order->status_donhang_id === 2 ? 'selected' : '' }}>Đã xác nhận
                            </option>
                            <option value="3" {{ $order->status_donhang_id === 3 ? 'selected' : '' }}>Đang vận chuyển
                            </option>
                            <option value="4" {{ $order->status_donhang_id === 4 ? 'selected' : '' }}>Đã giao hàng
                            </option>
                            <option value="5" {{ $order->status_donhang_id === 5 ? 'selected' : '' }}>Hoàn thành
                            </option>
                            <option value="6" {{ $order->status_donhang_id === 6 ? 'selected' : '' }}>Hoàn hàng</option>
                            <option value="8" {{ $order->status_donhang_id === 8 ? 'selected' : '' }}>Chờ xác nhận hoàn
                                hàng</option>
                            <option value="7" {{ $order->status_donhang_id === 7 ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                    </div>

                    <!-- Phần lý do trả hàng nếu trạng thái là "Chờ xác nhận hoàn hàng" -->
                    @if($order->status_donhang_id == 8)
                    <!-- Kiểm tra trạng thái Chờ xác nhận hoàn hàng -->
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
    var currentStatus = button.getAttribute('data-current-status'); // Lấy trạng thái hiện tại
    var returnReason = button.getAttribute('data-return-reason'); // Lấy lý do trả hàng (nếu có)

    // Cập nhật lại action của form trong modal
    var form = orderStatusModal.querySelector('form');
    form.action = `/admin/orders/${orderId}`; // Đảm bảo action chứa đúng ID của đơn hàng

    // Cập nhật trạng thái đơn hàng trong select
    var statusSelect = orderStatusModal.querySelector('#status');
    statusSelect.value = currentStatus;

    // Cập nhật lý do trả hàng (nếu có) vào textarea
    var returnReasonTextarea = orderStatusModal.querySelector('#return_reason');
    returnReasonTextarea.value = returnReason || ''; // Nếu không có lý do trả hàng thì để trống

    // Hiển thị hoặc ẩn textarea lý do trả hàng nếu trạng thái là "Chờ xác nhận hoàn hàng"
    if (currentStatus == 8) {
        returnReasonTextarea.closest('.form-group').style.display = 'block';
    } else {
        returnReasonTextarea.closest('.form-group').style.display = 'none';
    }
});
</script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
@endsection