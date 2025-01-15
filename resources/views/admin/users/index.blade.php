@extends('layouts.admin')

@section('title')
Quản lý người dùng
@endsection
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            <h4 class="fs-18 fw-semibold m-0">Danh sách người dùng</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered text-center" id="userTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-center">Họ Tên</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Ngày tạo</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center">Tương tác</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($users as $key => $user)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>
                                    @if ($user->status == 1)
                                        <span class="badge bg-success">Kích Hoạt</span>
                                    @else
                                        <span class="badge bg-danger">Không Kích Hoạt</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.users.show', $user->id) }}"
                                        class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1 "
                                        data-bs-toggle="tooltip" title="Xem">
                                        <i class="mdi mdi-eye "></i>
                                    </a>
                                    <a href="{{ route('admin.users.toggle', $user->id) }}" class="btn btn-warning btn-sm">
                                        {{ $user->status == 1 ? 'Vô Hiệu Hóa' : 'Kích Hoạt' }}
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            {{ $users->links() }}
        </div>
    </div>

</div>
@endsection
@section('js')
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $('#userTable').DataTable({
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