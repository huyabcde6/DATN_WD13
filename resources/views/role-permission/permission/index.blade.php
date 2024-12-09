@extends('layouts.admin')

@section('title')
Quản lý Vai trò & Quyền
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
            <h4 class="fs-18 fw-semibold m-0">Danh sách Quyền</h4>
        </div>

    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="d-flex m-3 justify-content-between align-items-center">
                    <form method="GET" action="{{ url('permission') }}" class="d-flex">
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
                    <button class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1"
                        data-bs-toggle="modal" data-bs-target="#addPermissionModal">
                        <i class="mdi mdi-plus text-muted"></i> Thêm Quyền
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-striped text-center" id="permissionTable">
                        <thead>
                            <tr>
                                <th>
                                    <a href="{{ url('permission', [
                                            'sort_by' => 'id', 
                                            'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc',
                                            'search' => request('search')
                                        ]) }}">
                                        #
                                    </a>
                                </th>
                                <th class="text-center">
                                    <a href="{{ url('permission', [
                                            'sort_by' => 'name', 
                                            'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc',
                                            'search' => request('search')
                                        ]) }}">
                                        Tên quyền
                                    </a>
                                </th>
                                <th class="text-center">Thao tác</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($permission as $perm)
                            <tr>
                                <td>{{ $perm->id }}</td>
                                <td>{{ $perm->name }}</td>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <button
                                            class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1"
                                            data-bs-toggle="modal" data-bs-target="#editPermissionModal"
                                            data-id="{{ $perm->id }}" data-name="{{ $perm->name }}" title="Chỉnh sửa">
                                            <i class="fa fa-pencil-alt"></i>
                                        </button>

                                        <button
                                            class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1 text-danger"
                                            data-bs-toggle="modal" data-bs-target="#deletePermissionModal"
                                            data-id="{{ $perm->id }}" title="Xóa">
                                            <i class="fa fa-fw fa-times"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{ $permission->appends(request()->query())->links() }}
    </div>
</div>

<!-- Modal Thêm Quyền -->
<div class="modal fade" id="addPermissionModal" tabindex="-1" aria-labelledby="addPermissionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPermissionModalLabel">Thêm Quyền</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('permission') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên quyền</label>
                        <input type="text" class="form-control" id="name" name="name">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Chỉnh sửa Quyền -->
<div class="modal fade" id="editPermissionModal" tabindex="-1" aria-labelledby="editPermissionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editPermissionForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ old('id') }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPermissionLabel">Sửa Quyền</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editPermissionName" class="form-label">Tên Quyền </label>
                        <input type="text" class="form-control" id="editPermissionName" name="name">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
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

<!-- Modal Xóa Quyền -->
<div class="modal fade" id="deletePermissionModal" tabindex="-1" aria-labelledby="deletePermissionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <form id="deletePermissionForm" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden" id="edit-id" name="id">
            <input type="hidden" id="edit-id" name="id" value="{{ old('id') }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletePermissionModalLabel">Xóa Quyền</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa quyền này?</p>
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
            $('#addPermissionModal').modal('show');
        @endif

        @if ($errors->has('name') && old('id') !== null)
            $('#editPermissionModal').modal('show');
        @endif
    });
</script>
<script>
const editModal = document.getElementById('editPermissionModal');
const deleteModal = document.getElementById('deletePermissionModal');
editModal.addEventListener('show.bs.modal', function(event) {
    const button = event.relatedTarget;
    const id = button.getAttribute('data-id');
    const name = button.getAttribute('data-name');
    const form = document.getElementById('editPermissionForm');
    form.action = `permission/${id}`;
    form.querySelector('#editPermissionName').value = name;
});
deleteModal.addEventListener('show.bs.modal', function(event) {
    const button = event.relatedTarget;
    const id = button.getAttribute('data-id');
    const form = document.getElementById('deletePermissionForm');
    form.action = `permission/${id}`;
});
</script>

@endsection

