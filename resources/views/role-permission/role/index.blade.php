@extends('layouts.admin')

@section('title')
Vai trò & quyền
@endsection

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection

@section('content')
@if (session()->has('status'))
<div class="alert alert-success">
    {{ session('status') }}
</div>
@endif

<div class="row m-3">
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Danh sách vai trò & quyền</h4>
        </div>

    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="d-flex m-3 justify-content-between align-items-center">
                    <button class="btn btn-sm btn-alt-secondary fs-18 rounded-2 border p-1 me-1" data-bs-toggle="modal"
                        data-bs-target="#addRoleModal" title="Thêm vai trò">
                        <i class="mdi mdi-plus text-muted">Thêm vai trò</i>
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-bordered text-center" id="roleTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên vai trò</th>
                                <th class="text-center">Tương tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <a href="{{ url('roles/' . $role->id . '/give-permission') }}"
                                            class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1"
                                            title="Cấp / sửa quyền">
                                            <i class="fa fa-key text-warning"></i>
                                        </a>
                                        <button
                                            class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1"
                                            data-bs-toggle="modal" data-bs-target="#editRoleModal"
                                            data-id="{{ $role->id }}" data-name="{{ $role->name }}" title="Sửa">
                                            <i class="fa fa-pencil-alt"></i>
                                        </button>
                                        <button
                                            class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1"
                                            data-bs-toggle="modal" data-bs-target="#deleteRoleModal"
                                            data-id="{{ $role->id }}" title="Xóa">
                                            <i class="fa fa-fw fa-times text-danger"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{ $roles->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<!-- Modal Thêm Vai Trò -->
<div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ url('roles') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ old('id') }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRoleModalLabel">Thêm Vai Trò</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="roleName" class="form-label">Tên Vai Trò</label>
                        <input type="text" class="form-control" id="roleName" name="name">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Sửa Vai Trò -->
<div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editRoleForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit-id" name="id">
            <input type="hidden" id="edit-id" name="id" value="{{ old('id') }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRoleModalLabel">Sửa Vai Trò</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editRoleName" class="form-label">Tên Vai Trò</label>
                        <input type="text" class="form-control" id="editRoleName" name="name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Xóa Vai Trò -->
<div class="modal fade" id="deleteRoleModal" tabindex="-1" aria-labelledby="deleteRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="deleteRoleForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteRoleModalLabel">Xóa Vai Trò</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa vai trò này?</p>
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
    $(document).ready(function() {
        @if ($errors->has('name') && old('id') == null)
            $('#addRoleModal').modal('show');
        @endif

        @if ($errors->has('name') && old('id') !== null)
            $('#editRoleModal').modal('show');
        @endif
    });
</script>
<script>
const editModal = document.getElementById('editRoleModal');
const deleteModal = document.getElementById('deleteRoleModal');
editModal.addEventListener('show.bs.modal', function(event) {
    const button = event.relatedTarget;
    const id = button.getAttribute('data-id');
    const name = button.getAttribute('data-name');
    const form = document.getElementById('editRoleForm');
    form.action = `roles/${id}`;
    form.querySelector('#editRoleName').value = name;
});

deleteModal.addEventListener('show.bs.modal', function(event) {
    const button = event.relatedTarget;
    const id = button.getAttribute('data-id');
    const form = document.getElementById('deleteRoleForm');
    form.action = `roles/${id}`;
});
</script>

<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#roleTable').DataTable({
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
