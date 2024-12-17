@extends('layouts.admin')

@section('title')
Danh sách danh mục
@endsection
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection
@section('content')
    @if (session()->has('status_error'))
        <div class="alert alert-danger">
            {{ session()->get('status_error') }}
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
            <h4 class="fs-18 fw-semibold m-0">Danh sách danh mục</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="d-flex m-3 justify-content-between align-items-center">
                    <form method="GET" action="{{ route('admin.categories.index') }}" class="d-flex">
                        <div class="input-group">
                            <span class="input-group-text">
                                Tìm kiếm
                            </span>
                            <input type="text" name="search" class="form-control" placeholder="Nhập từ khóa cần tìm..."
                                value="{{ request('search') }}">

                            <button type="submit" class="btn btn-sm btn-dark">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Thêm Mới</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped text-center">
                            <thead>
                                <tr>
                                    <th>
                                        <a
                                            href="{{ request()->fullUrlWithQuery(['sort' => 'id', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}">
                                            #
                                            @if (request('sort') === 'id')
                                            <i class="bi bi-arrow-{{ request('order') === 'asc' ? 'down' : 'up' }}"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th>
                                        <a
                                            href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'order' => request('order') === 'asc' ? 'desc' : 'asc']) }}">
                                            Tên danh mục
                                            @if (request('sort') === 'name')
                                            <i class="bi bi-arrow-{{ request('order') === 'asc' ? 'down' : 'up' }}"></i>
                                            @endif
                                        </a>
                                    </th>
                                    <th>
                                        Trạng thái
                                    </th>
                                    <th>Số lượng sản phẩm</th>
                                    <th class="text-center">
                                        Tương tác
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="category-table">
    @forelse ($categories as $key => $item)
    <tr>
        <td>{{ $key + 1 }}</td>
        <td>{{ $item->name }}</td>
        <td>{{ $item->status == 1 ? 'Hiển thị' : 'Ẩn' }}</td>
        <td>{{ $item->product_count ?? 0 }}</td><!-- Hiển thị số lượng sản phẩm -->
        <td>
            <div class="d-flex justify-content-center align-items-center">
                <a class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1 " href="{{ route('admin.categories.edit', $item->id ) }}">
                    <i class="fa fa-pencil-alt"></i>
                </a>
                <button
                    class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1 text-danger"
                    data-bs-toggle="modal" data-bs-target="#deleteModal"
                    data-id="{{ $item->id }}">
                    <i class="fa fa-fw fa-times text-danger"></i>
                </button>
            </div>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="5">Không có danh mục nào!</td>
    </tr>
    @endforelse
</tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="" method="POST" id="deleteForm">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Xóa danh mục</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa danh mục này?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger">Xóa</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('js')


<script>
// Logic to handle Edit and Delete modals
document.querySelectorAll('[data-bs-target="#editModal"]').forEach(button => {
    button.addEventListener('click', function() {
        const id = this.dataset.id;
        const name = this.dataset.name;
        const status = this.dataset.status;

        document.getElementById('edit-id').value = id;
        document.getElementById('edit-name').value = name;
        document.getElementById('edit-status').value = status;
        document.getElementById('editForm').action = `/admin/categories/${id}`;
    });
});

document.querySelectorAll('[data-bs-target="#deleteModal"]').forEach(button => {
    button.addEventListener('click', function() {
        const id = this.dataset.id;
        document.getElementById('deleteForm').action = `/admin/categories/${id}`;
    });
});
</script>

<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $('#categoryTable').DataTable({
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