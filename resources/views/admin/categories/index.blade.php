@extends('layouts.admin')

@section('title')
    Danh sách danh mục
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
                                    <td>
                                        <div class="d-flex justify-content-center align-items-center">
                                            <button
                                                class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1"
                                                data-bs-toggle="modal" data-bs-target="#editModal"
                                                data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                                                data-status="{{ $item->status }}">
                                                <i class="fa fa-pencil-alt"></i>
                                            </button>
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
                                    <td colspan="4">Không có danh mục nào!</td>
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

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ old('id') }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Thêm danh mục mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên danh mục</label>
                        <input type="text" name="name" value="{{ old('name') }}" id="name" class="form-control">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Trạng thái</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1">Hiển thị</option>
                            <option value="0">Ẩn</option>
                        </select>
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

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="" method="POST" id="editForm">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit-id" name="id" value="{{ old('id') }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Sửa danh mục</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit-id" name="id">
                    <div class="mb-3">
                        <label for="edit-name" class="form-label">Tên danh mục</label>
                        <input type="text" name="name" value="{{ old('name') }}" id="edit-name" class="form-control">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="edit-status" class="form-label">Trạng thái</label>
                        <select name="status" id="edit-status" class="form-control">
                            <option value="1">Hiển thị</option>
                            <option value="0">Ẩn</option>
                        </select>
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

@section('js')
<script>
    $(document).ready(function() {
        @if ($errors->has('name') && old('id') == null)
            $('#addModal').modal('show');
        @endif

        @if ($errors->has('name') && old('id') !== null)
            $('#editModal').modal('show');
        @endif
    });
</script>
@endsection

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

@endsection

