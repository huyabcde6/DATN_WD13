@extends('layouts.admin')

@section('title', 'Danh Sách Giá Trị Thuộc Tính')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection

@section('content')
<div class="row m-3">
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Danh Sách Giá Trị Thuộc Tính</h4>
        </div>
    </div>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="d-flex m-3 justify-content-between align-items-center">
                    <a href="{{ route('admin.attribute_values.create') }}" 
                        class="btn btn-sm btn-alt-primary mx-2 fs-18 rounded-2 border p-1 me-1" 
                        data-bs-toggle="tooltip" title="Thêm mới">
                        <i class="mdi mdi-plus text-muted px-1 mr-1">Thêm mới</i>
                    </a>

                    <!-- Dropdown Lọc Theo Thuộc Tính -->
                    <select id="filter-attribute" class="form-select w-auto">
                        <option value="">Lọc theo thuộc tính</option>
                        @foreach($attributes as $attribute)
                        <option value="{{ $attribute->name }}">{{ $attribute->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="card-body">
                    <table class="table table-bordered text-center" id="attributeValuesTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Thuộc Tính</th>
                                <th>Giá Trị</th>
                                <th>Mã Màu</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attributeValues as $attributeValue)
                            <tr>
                                <td>{{ $attributeValue->id }}</td>
                                <td>{{ $attributeValue->attribute->name }}</td>
                                <td>{{ $attributeValue->value }}</td>
                                <td>
                                    @if ($attributeValue->color_code)
                                        <span class="d-inline-block rounded-circle" 
                                            style="width: 20px; height: 20px; border: 1px solid black; background-color: {{ $attributeValue->color_code }};">
                                        </span>
                                        {{ $attributeValue->color_code }}
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.attribute_values.edit', $attributeValue) }}" 
                                        class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1">
                                        <i class="fa fa-pencil-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
        // Khởi tạo DataTable
        const table = $('#attributeValuesTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "lengthChange": false,
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

        // Lọc theo thuộc tính
        $('#filter-attribute').on('change', function() {
            const attribute = $(this).val();
            if (attribute) {
                table.columns(1).search(attribute).draw(); // Lọc theo cột thứ 2 (Thuộc Tính)
            } else {
                table.columns(1).search('').draw(); // Xóa bộ lọc nếu không chọn thuộc tính
            }
        });
    });
</script>
@endsection
