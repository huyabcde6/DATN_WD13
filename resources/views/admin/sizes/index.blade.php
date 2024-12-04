@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row m-3">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Danh sách kích thước</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="d-flex m-3 justify-content-between align-items-center">
                        <form method="GET" action="{{ route('admin.sizes.index') }}" class="d-flex">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" name="search" class="form-control"
                                    placeholder="Nhập từ khóa cần tìm..." value="{{ request('search') }}">
                            </div>
                            <button type="submit" class="btn btn-sm btn-dark mx-2">
                                <i class="bi bi-search"></i> Tìm kiếm
                            </button>
                        </form>
                        <button class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1"
                            data-bs-toggle="modal" data-bs-target="#addSizeModal" title="Thêm mới">
                            <i class="mdi mdi-plus text-muted"></i>
                        </button>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-striped text-center">
                            <thead>
                                <tr>
                                    <th>
                                        <a href="{{ route('admin.sizes.index', [
                                            'sort' => 'size_id',
                                            'direction' => request('direction') == 'asc' ? 'desc' : 'asc',
                                            'search' => request('search')
                                        ]) }}">ID</a>
                                    </th>
                                    <th>
                                        <a href="{{ route('admin.sizes.index', [
                                            'sort' => 'value',
                                            'direction' => request('direction') == 'asc' ? 'desc' : 'asc',
                                            'search' => request('search')
                                        ]) }}">Giá trị</a>
                                    </th>
                                    <th>
                                        Trạng thái
                                    </th>
                                    <th>Tương tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sizes as $size)
                                <tr>
                                    <td>{{ $size->size_id }}</td>
                                    <td>{{ $size->value }}</td>
                                    <td>{{ $size->status ? 'Hoạt động' : 'Không hoạt động' }}</td>
                                    <td>
                                        <!-- Nút sửa -->
                                        <button
                                            class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1"
                                            data-bs-toggle="modal" data-bs-target="#editSizeModal{{ $size->size_id }}"
                                            title="Sửa">
                                            <i class="fa fa-pencil-alt"></i>
                                        </button>

                                        <!-- Nút xóa -->
                                        <button
                                            class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1"
                                            data-bs-toggle="modal" data-bs-target="#deleteSizeModal{{ $size->size_id }}"
                                            title="Xóa">
                                            <i class="fa fa-fw fa-times text-danger"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal sửa -->
                                <div class="modal fade" id="editSizeModal{{ $size->size_id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('admin.sizes.update', $size->size_id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" id="edit-id" name="id">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Sửa kích thước</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="value">Tên kích thước:</label>
                                                        <input type="text" id="value" name="value" class="form-control"
                                                            value="{{ $size->value }}">
                                                        @error('value')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <label for="status">Trạng thái:</label>
                                                        <input type="hidden" name="status" value="0">
                                                        <!-- Giá trị mặc định -->
                                                        <input type="checkbox" id="status" name="status" value="1"
                                                            {{ $size->status ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Đóng</button>
                                                    <button type="submit" class="btn btn-primary">Lưu</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal xóa -->
                                <div class="modal fade" id="deleteSizeModal{{ $size->size_id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('admin.sizes.destroy', $size->size_id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Xóa kích thước</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Bạn có chắc chắn muốn xóa kích thước này không?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Hủy</button>
                                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Phân trang -->
                    <div class="d-flex justify-content-center">
                        {{ $sizes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal thêm mới -->
<div class="modal fade" id="addSizeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.sizes.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ old('id') }}">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm kích thước mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="value">Tên kích thước:</label>
                        <input type="text" id="value" name="value" class="form-control" >
                        @error('value')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mt-3">
                        <label for="status">Trạng thái:</label>
                        <input type="hidden" name="status" value="0"> <!-- Giá trị mặc định -->
                        <input type="checkbox" id="status" name="status" value="1" checked>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Thêm</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        @if ($errors->has('value') && old('id') == null)
            $('#addSizeModal').modal('show');
        @endif
        @foreach ($sizes as $size)
            @if ($errors->has('value') && old('id') !== null)
                $('#editSizeModal{{ $size->size_id }}').modal('show');
            @endif
        @endforeach
    });
</script>
@endsection
