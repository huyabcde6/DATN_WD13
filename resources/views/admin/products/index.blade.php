@extends('layouts.admin')

@section('title')
Danh sách sản phẩm
@endsection

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css" /> -->
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
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column ">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold ml-0">Danh sách sản phẩm </h4>
        </div>
        <div class="flex-grow-2 mx-2">

        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="d-flex mt-3 mx-2 justify-content-between align-items-center">
                    <form action="{{ route('admin.products.index') }}" method="get" class="ms-2">
                        <div class="d-flex">
                            <select name="categories_id" class="form-control" id="categories_id">
                                <option value="">Chọn danh mục</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('categories_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                            <input type="date" name="from_date" class="form-control ms-2"
                                value="{{ request('from_date') }}" placeholder="Từ ngày">
                            <input type="date" name="to_date" class="form-control ms-2" value="{{ request('to_date') }}"
                                placeholder="Đến ngày">
                            <button type="submit" class="btn btn-dark ms-2">Lọc</button>
                        </div>
                    </form>
                    <a href="{{ route('admin.products.create') }}"
                        class="btn btn-sm btn-alt-primary mx-2 fs-18 rounded-2 border p-1 me-1 "
                        data-bs-toggle="tooltip" title="Thêm mới">
                        <i class="mdi mdi-plus text-muted px-1 mr-1">Thêm mới</i>
                    </a>
                </div>

                <div class="card-body">
                    <table class="table table-bordered text-center" id="productTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-center">
                                    Tên sản phẩm
                                </th>
                                <th class="text-center">Hình ảnh</th>
                                <th class="text-center">
                                    Danh mục
                                </th>
                                <th class="text-center">
                                    Giá
                                </th>
                                <th class="text-center">Giá giảm</th>
                                
                                <th class="text-center">
                                    Ngày tạo
                                </th>
                                <th class="text-center">Hiện/ẩn</th>
                                <th class="text-center">Tương tác</th>
                            </tr>
                        </thead>

                        <tbody class="align-middle">
                            @foreach ($products as $key => $product)
                            <tr data-order-id="{{ $product->id }}">
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $product->name }}</td>
                                <td>
                                    <img src="{{ url('storage/' . $product->avata) }}" alt="{{ $product->name }}"
                                        width="50px" height="auto" class="img-thumbnail">
                                </td>
                                <td>{{ $product->categories->name ?? 'Không có' }}</td>
                                <td>{{ number_format($product->price, 0, '', '.') }} đ</td>
                                <td>{{ $product->discount_price ? number_format($product->discount_price, 0, '', '.') . ' đ' : 'Không có' }}
                                </td>
                                

                                <td>{{ $product->created_at->format('d/m/Y') }}</td>
                                <td class="{{ $product->iS_show ? 'text-success' : 'text-danger' }}">
                                    {{ $product->iS_show ? 'Hiện' : 'Ẩn' }}
                                </td>

                                <td>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <a href="{{ route('admin.products.show', $product) }}"
                                            class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1 "
                                            data-bs-toggle="tooltip" title="Xem">
                                            <i class="mdi mdi-eye text-muted "></i>
                                        </a>
                                        <a href="{{ route('admin.products.edit', $product) }}"
                                            class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1 "
                                            data-bs-toggle="tooltip" title="Sửa">
                                            <i class="fa fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                            class="form-delete">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1"
                                                data-bs-toggle="tooltip" title="Xóa">
                                                <i class="fa fa-fw fa-times text-danger"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
</div>

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>
<script>
document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault(); // Ngăn chặn hành động mặc định
        const deleteBtn = this.querySelector('.delete-btn');
        Swal.fire({
            title: 'Bạn có chắc chắn muốn xóa sản phẩm này?',
            text: "Hành động này không thể hoàn tác!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Có, xóa!',
            cancelButtonText: 'Không, hủy bỏ!'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
});

// Xử lý tìm kiếm với debounce
let timeout = null;
document.getElementById('search').addEventListener('input', function() {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
        document.getElementById('search-form').submit();
    }, 1000);
});
</script>
@endpush
@endsection
@section('js')
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $('#productTable').DataTable({
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