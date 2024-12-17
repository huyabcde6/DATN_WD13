@extends('layouts.admin')
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection
@section('content')
<div class="row m-3">
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Danh Sách Mã Giảm Giá</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="d-flex m-3">
                    <a href="{{ route('admin.Coupons.create') }}" class="btn btn-success">+ Thêm Mã Giảm Giá</a>
                </div>

                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                <div class="card-body">
                    <table class="table table-bordered" id="couponTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Mã giảm giá</th>
                                <th>Loại giảm giá</th>
                                <th>Giá trị</th>
                                <th>Thời gian áp dụng</th>
                                <th>Số lượng</th>
                                <th>Trạng thái</th>
                                <th>Điều kiện áp dụng</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($coupons as $coupon)
                            <tr>
                                <td>{{ $coupon->id }}</td>
                                <td>{{ $coupon->code }}</td>
                                <td>{{ $coupon->discount_type == 'percentage' ? 'Phần trăm' : 'Số tiền cố định' }}</td>
                                <td>
                                    @if($coupon->discount_type == 'percentage')
                                    {{ $coupon->discount_value }}%
                                    @else
                                    {{ number_format($coupon->discount_value, 0, ',', '.') }} VNĐ
                                    @endif
                                </td>
                                <td> Từ
                                    {{ $coupon->start_date->format('d/m/Y H:i') }} đến
                                    {{ $coupon->end_date->format('d/m/Y H:i') }}
                                </td>
                                <td>{{ $coupon->total_quantity }}</td>
                                <td>{{ $coupon->status == 'active' ? 'Hoạt động' : 'Tạm dừng' }}</td>
                                <td>
                                    @if($coupon->conditions->isNotEmpty())
                                    <ul>
                                        @foreach($coupon->conditions as $condition)
                                        @if($condition->product_id)
                                        <li>Áp dụng cho sản phẩm ID: {{ $condition->product_id }}</li>
                                        @endif
                                        @if($condition->category_id)
                                        <li>Áp dụng cho danh mục ID: {{ $condition->category_id }}</li>
                                        @endif
                                        @endforeach
                                    </ul>
                                    @else
                                    Không có
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.Coupons.edit', $coupon->id) }}"
                                        class="btn btn-sm btn-primary">Sửa</a>
                                    <form action="{{ route('admin.Coupons.destroy', $coupon->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center">Không có mã giảm giá nào!</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Phân trang -->
                <div class="mt-3">
                    {{ $coupons->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $('#couponTable').DataTable({
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