@extends('layouts.admin')

@section('title')
Quản lý hóa đơn
@endsection
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection
@section('content')

<div class="row m-3">
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Quản lý hóa đơn</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered text-center" id="invoiceTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-center">Mã đơn hàng</th>
                                <th class="text-center">Người nhận</th>
                                <th class="text-center">Ngày tạo</th>
                                <th class="text-center">Tổng tiền</th>
                                <th class="text-center">Hình thức thanh toán</th>
                                <th class="text-center">Trạng thái thanh toán</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>

                        <tbody class="text-center">
                            @foreach($invoices as $key => $invoice)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $invoice->order_code }}</td>
                                <td>{{ $invoice->user->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($invoice->date_invoice)->format('d-m-Y') }}</td>
                                <td>{{ number_format($invoice->total_price, 0, ',', '.') }} đ</td>
                                <td>{{ $invoice->method }}</td>
                                <td>{{ $invoice->payment_status }}</td>
                                <td>
                                    <span class="badge bg-success 
                                    
                                        style="height: 30px; line-height: 17px; font-size: 15px;">{{ optional($invoice->status)->type ?? 'Không xác định' }}</span>

                                </td>
                                <td>
                                    <a href="{{ route('admin.invoices.show', $invoice->id) }}"
                                        class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1 "
                                        data-bs-toggle="tooltip" title="Xem">
                                        <i class="mdi mdi-eye "></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{ $invoices->links('pagination::bootstrap-5') }}
    </div>
</div>

@endsection
@section('js')
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $('#invoiceTable').DataTable({
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

@endsection