@extends('layouts.admin')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection

@section('content')
<div class="row m-3">
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Danh sách màu sắc</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="d-flex m-3 justify-content-between align-items-center">
                    <button type="button" class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1"
                        data-bs-toggle="modal" data-bs-target="#createColorModal" title="Thêm mới">
                        <i class="mdi mdi-plus text-muted">Thêm mới</i>
                    </button>
                </div>
                @error('value')
                <div class="alert alert-danger text-danger">{{ $message }}</div>
                @enderror
                <!-- Modal thêm mới -->
                <div class="modal fade" id="createColorModal" tabindex="-1" aria-labelledby="createColorModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createColorModalLabel">Thêm mới màu sắc</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('admin.colors.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ old('id') }}">
                                <div class="modal-body">
                                    <div class="form-group mb-3">
                                        <label for="new_value">Tên Màu:</label>
                                        <input type="text" id="new_value" value="{{ old('value') }}" name="value"
                                            class="form-control">
                                        @error('value')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="new_status">Kích Hoạt:</label>
                                        <input type="hidden" name="status" value="0">
                                        <input type="checkbox" id="new_status" name="status" value="1">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Đóng</button>
                                    <button type="submit" class="btn btn-primary">Thêm</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Bảng danh sách -->
                <div class="card-body">
                    <table class="table table-bordered text-center" id="colorTable">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th class="text-center">
                                    Màu sắc
                                </th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center">Tương tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($colors as $key => $color)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $color->value }}</td>
                                <td>{{ $color->status ? 'Kích hoạt' : 'Không kích hoạt' }}</td>
                                <td>
                                    <!-- Nút chỉnh sửa -->
                                    <button type="button"
                                        class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1"
                                        title="Sửa" data-bs-toggle="modal"
                                        data-bs-target="#editColorModal{{ $color->color_id }}">
                                        <i class="fa fa-pencil-alt"></i>
                                    </button>

                                    <!-- Nút xóa -->
                                    <button type="button"
                                        class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1"
                                        title="Xóa" data-bs-toggle="modal"
                                        data-bs-target="#deleteColorModal{{ $color->color_id }}">
                                        <i class="fa fa-fw fa-times text-danger"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal chỉnh sửa -->
                            <div class="modal fade" id="editColorModal{{ $color->color_id }}" tabindex="-1"
                                aria-labelledby="editColorModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editColorModalLabel">Sửa màu sắc</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('admin.colors.update', $color->color_id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="id" value="{{ old('id', $color->color_id) }}">
                                            <div class="modal-body">
                                                <div class="form-group mb-3">
                                                    <label for="value">Tên Màu:</label>
                                                    <input type="text" id="value" name="value" class="form-control"
                                                        value="{{ $color->value }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="status">Kích Hoạt:</label>
                                                    <input type="hidden" name="status" value="0">
                                                    <input type="checkbox" id="status" name="status" value="1"
                                                        {{ $color->status ? 'checked' : '' }}>
                                                    @error('status')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
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
                            <div class="modal fade" id="deleteColorModal{{ $color->color_id }}" tabindex="-1"
                                aria-labelledby="deleteColorModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteColorModalLabel">Xóa màu sắc</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Bạn có chắc chắn muốn xóa màu sắc này không?
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('admin.colors.destroy', $color->color_id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Hủy</button>
                                                <button type="submit" class="btn btn-danger">Xóa</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Phân trang -->
                    <div class="pagination justify-content-center">
                        {{ $colors->appends(['search' => request('search'), 'sort' => request('sort'), 'direction' => request('direction')])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
<script>
    $(document).ready(function() {
    $('#colorTable').DataTable({
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