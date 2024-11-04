@extends('layouts.admin')

@section('content')
<div class="row m-3">
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Danh sách biến thể sản phẩm</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="d-flex m-3 justify-content-between">
                    <form action="{{ route('admin.products.index') }}" method="get" id="search-form">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" value="{{ request('search') }}" name="search" id="search"
                                class="form-control" placeholder="Nhập từ khóa cần tìm..">
                            <button type="submit" class="btn btn-secondary">Tìm kiếm</button>
                        </div>
                    </form>

                    <a href="{{ route('admin.products.index') }}"
                        class="btn btn-sm btn-alt-secondary  mx-1 fs-18 rounded-2 border p-1 me-1"
                        data-bs-toggle="tooltip" title="Quay lại">
                        <i class="mdi mdi-arrow-left text-muted  "></i>
                    </a>
                </div>
                <div class="card-body">
                    <h4 class="mt-4">Thông tin sản phẩm: <strong>{{ $product->name }}</strong></h4>

                    <!-- Hiển thị thông tin sản phẩm -->
                    <div class="mb-4">
                        <ul class="list-group">
                            <li class="list-group-item">Tên: <strong>{{ $product->name }}</strong></li>
                            <li class="list-group-item">Giá: <strong>{{ number_format($product->price, 0, ',', '.') }}
                                    VNĐ</strong></li>
                            <li class="list-group-item">Giá khuyến mãi:
                                <strong>{{ number_format($product->discount_price, 0, ',', '.') }} VNĐ</strong>
                            </li>
                            <!-- Thêm các thông tin khác nếu cần -->
                        </ul>
                    </div>

                    <!-- Hiển thị danh sách biến thể -->
                    <h5>Các biến thể sản phẩm</h5>
                    <div class="col-md-12">
                        <table class="table table-striped text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Mã biến thể</th>
                                    <th>Ảnh</th>
                                    <th>Kích thước</th>
                                    <th>Màu</th>
                                    <th>Giá</th>
                                    <th>Giá khuyến mãi</th>
                                    <th>Số lượng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($variants as $variant)
                                <tr>
                                    <td>{{ $variant->id }}</td>
                                    <td>{{ $variant->product_code }}</td>
                                    <td>
                                        <img src="{{ url('storage/'. $variant->image) }}" alt="Hình ảnh sản phẩm"
                                            style="width: 100px; height: auto;">
                                    </td>
                                    <td>{{ $variant->size->value }}</td>
                                    <td>{{ $variant->color->value }}</td>
                                    <td>{{ $variant->price }}</td>
                                    <td>{{ $variant->discount_price }}</td>
                                    <td>{{ $variant->quantity }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection