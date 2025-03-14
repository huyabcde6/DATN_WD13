@extends('layouts.admin')

@section('title')
Quản lý đơn hàng
@endsection
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection
@section('content')
<div class="row m-3">
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Danh sách đơn hàng</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="d-flex mt-3 justify-content-between align-items-center">
                    <form action="{{ route('admin.orders.index') }}" method="get" class="ms-2">
                        <div class="d-flex justify-content-between ">
                            <!-- Lọc theo ngày -->

                            <input type="date" name="from_date" id="from_date" class="form-control mx-2"
                                value="{{ request('from_date') }}">

                            <input type="date" name="to_date" id="to_date" class="form-control mx-2"
                                value="{{ request('to_date') }}">

                            <select name="status_donhang_id" id="status_donhang_id" class="form-select  mx-2">
                                <option value="">Chọn trạng thái</option>
                                @foreach($statuses as $status)
                                <option value="{{ $status->id }}"
                                    {{ request('status_donhang_id') == $status->id ? 'selected' : '' }}>
                                    {{ $status->type }}
                                </option>
                                @endforeach
                            </select>

                            <select name="method" id="method" class="form-select mx-2">
                                <option value="">Chọn phương thức</option>
                                <option value="COD" {{ request('method') == 'COD' ? 'selected' : '' }}>COD</option>

                                <option value="VNPAY" {{ request('method') == 'VNPAY' ? 'selected' : '' }}>VNPAY
                                </option>
                            </select>

                            <select name="payment_status" id="payment_status" class="form-select mx-2">
                                <option value="">Chọn trạng thái thanh toán</option>
                                <option value="chưa thanh toán"
                                    {{ request('payment_status') == 'chưa thanh toán' ? 'selected' : '' }}>Chưa
                                    thanh toán</option>
                                <option value="đã thanh toán"
                                    {{ request('payment_status') == 'đã thanh toán' ? 'selected' : '' }}>Đã thanh
                                    toán</option>
                                <option value="thất bại"
                                    {{ request('payment_status') == 'thất bại' ? 'selected' : '' }}>Thất bại
                                </option>
                                <option value="đã hoàn lại"
                                    {{ request('payment_status') == 'đã hoàn lại' ? 'selected' : '' }}>Đã hoàn lại
                                </option>
                            </select>
                            <button type="submit" class="btn btn-dark mx-2">Lọc</button>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    <table class="table table-bordered text-center" id="orderTable">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    #
                                </th>
                                <th class="text-center">
                                    Mã đơn hàng
                                </th>
                                <th class="text-center">
                                    Người nhận
                                </th>
                                <th class="text-center">
                                    Ngày tạo
                                </th>
                                <th class="text-center">Tổng tiền</th>
                                <th class="text-center">Hình thức thanh toán</th>
                                <th class="text-center">Trạng thái thanh toán</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center">Tương tác</th>
                            </tr>
                        </thead>

                        <tbody id="order-list">
                            @foreach($orders as $key => $order)
                            <tr data-order-id="{{ $order->id }}">
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $order->order_code }}</td>
                                <td>{{ $order->user->name }}</td>
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
                <form action="{{ route('admin.orders.update', $order->id) }}" method="post" class="order-status-form"
                    data-ajax="true">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="status">Trạng thái</label>
                        <select class="form-select" name="status" id="status" required>
                            @if($order->status_donhang_id === 1)
                            <!-- Chờ xác nhận -->
                            <option value="2">Đã xác nhận</option>
                            <option value="7">Hủy đơn</option>
                            @elseif($order->status_donhang_id === 2)
                            <!-- Đã xác nhận -->
                            <option value="3">Đang vận chuyển</option>
                            @elseif($order->status_donhang_id === 3)
                            <!-- Đang vận chuyển -->
                            <option value="4">Đã giao hàng</option>
                            @elseif($order->status_donhang_id === 8)
                            <!-- Chờ xác nhận hoàn hàng -->
                            <option value="6">Hoàn hàng</option>
                            @else
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
                            <option value="7" {{ $order->status_donhang_id === 7 ? 'selected' : '' }}>Hủy đơn</option>
                            @endif
                        </select>
                    </div>

                    <!-- Phần lý do trả hàng nếu trạng thái là "Chờ xác nhận hoàn hàng" -->
                    @if($order->status_donhang_id == 8)
                    <div class="mt-2 return-reason-div" style="display: block;">
                        <label for="return_reason">Lý do trả hàng</label>
                        <textarea name="return_reason" id="return_reason"
                            class="form-control">{{ old('return_reason', $order->return_reason) }}</textarea>
                    </div>
                    @else
                    <div class="mt-2 return-reason-div" style="display: none;">
                        <label for="return_reason">Lý do trả hàng</label>
                        <textarea name="return_reason" readonly id="return_reason" class="form-control"></textarea>
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
@vite('resources/js/adminoder.js')

@endsection

@section('js')
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $('#orderTable').DataTable({
        "paging": false, // Cho phép phân trang
        "searching": true, // Tìm kiếm
        "ordering": true, // Sắp xếp cột
        "lengthChange": false, // Ẩn lựa chọn số lượng bản ghi trên mỗi trang
        "info": false,
        "language": {
            "lengthMenu": "Hiển thị _MENU_ mục",
            "zeroRecords": "Không tìm thấy dữ liệu phù hợp",
            "info": "Hiển thị _START_ đến _END_ của _TOTAL_ mục",
            "infoEmpty": "Không có dữ liệu",
            "search": "Tìm kiếm:",
            "paginate": {
                "first": "Đầu",
                "last": "Cuối",
                "next": "Tiếp",
                "previous": "Trước"
            }
        }
    });
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
    }else if (currentStatus === 4) {
        statusSelect.innerHTML = `<option value="4" selected>Đã giao hàng</option>`;
        statusSelect.disabled = true;
    }else if (currentStatus === 5) {
        statusSelect.innerHTML = `<option value="4" selected>Hoàn thành</option>`;
        statusSelect.disabled = true;
    } else if (currentStatus === 8) {
        statusSelect.innerHTML += `<option value="6">Hoàn hàng</option>`;
    } else {
        var options = [{
                value: 1,
                text: 'Chờ xác nhận'
            },
            {
                value: 2,
                text: 'Đã xác nhận'
            },
            {
                value: 3,
                text: 'Đang vận chuyển'
            },
            {
                value: 4,
                text: 'Đã giao hàng'
            },
            {
                value: 5,
                text: 'Hoàn thành'
            },
            {
                value: 6,
                text: 'Hoàn hàng'
            },
            {
                value: 8,
                text: 'Chờ xác nhận hoàn hàng'
            },
            {
                value: 7,
                text: 'Hủy đơn'
            }
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
    var returnReasonDiv = orderStatusModal.querySelector('.return-reason-div');
    if (currentStatus === 8) {
        returnReasonDiv.style.display = 'block'; // Hiển thị phần lý do trả hàng
        returnReasonTextarea.closest('.form-group').style.display = 'block'; // Hiển thị textarea
    } else {
        returnReasonDiv.style.display = 'none'; // Ẩn phần lý do trả hàng
        returnReasonTextarea.closest('.form-group').style.display = 'none'; // Ẩn textarea
    }
});
</script>
@if (session('error'))
<script>
$(document).ready(function() {
    toastr.error("{{ session('error') }}", "Thất bại", {
        timeOut: 5000
    });
});
</script>
@endif

@if (session('success'))
<script>
$(document).ready(function() {
    toastr.success("{{ session('success') }}", "Thành công", {
        timeOut: 5000
    });
});
</script>
@endif
@endsection