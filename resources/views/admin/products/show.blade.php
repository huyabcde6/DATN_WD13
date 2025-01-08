@extends('layouts.admin')
@section('css')
<style>
.no-border .list-group-item {
    border: none;
}
</style>
@endsection
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

                    <a href="{{ route('admin.products.index') }}"
                        class="btn btn-sm btn-alt-secondary  mx-1 fs-18 rounded-2 border p-1 me-1"
                        data-bs-toggle="tooltip" title="Quay lại">
                        <i class="mdi mdi-arrow-left text-muted  "></i>
                    </a>
                </div>
                <div class="card-body">
                    <h4 class="">Thông tin sản phẩm: <strong>{{ $product->name }}</strong></h4>

                    <!-- Hiển thị thông tin sản phẩm -->
                    <div class="row my-3">
                        <div class="col-12 d-flex mt-3">
                            <!-- Main Image -->
                            <div class="col-6 text-center pt-5">
                                <img src="{{ url('storage/' . $product->avata) }}" width="350px" height="auto"
                                    alt="Product Image">
                            </div>
                            <div class="col-6">
                                <!-- Product Information -->
                                <ul class="list-group">
                                    <li class="list-group-item border-0 fs-5">Tên: <strong>{{ $product->name }}</strong>
                                    </li>
                                    <li class="list-group-item border-0 fs-6">Giá:
                                        <strong>{{ number_format($product->price, 0, ',', '.') }} VNĐ</strong>
                                    </li>
                                    <li class="list-group-item border-0 fs-6">Giá khuyến mãi:
                                        <strong>{{ number_format($product->discount_price, 0, ',', '.') }} VNĐ</strong>
                                    </li>

                                    <li class="list-group-item border-0 fs-6">Mô tả ngắn:
                                        <strong>{{ $product->short_description }}</strong>
                                    </li>
                                    <li class="list-group-item border-0">Mổ tả chi tiết:
                                        <strong>{!! $product->description !!}</strong>
                                    </li>

                                </ul>

                            </div>
                        </div>

                        <!-- Additional Images and Description -->
                        <div class="col-6">
                            <div class="row">
                                @foreach($product->productImages as $image)
                                <div class="col-md-2 " width="100px" height="auto">
                                    <div class="mb-3" width="100px" height="auto">
                                        <img src="{{ url('storage/' . $image->image_path) }}" class="card-img-top"
                                            alt="Additional Image">

                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>


                    <!-- Hiển thị danh sách biến thể -->
                    <h5>Các biến thể sản phẩm</h5>
                    <div class="col-md-12">
                        <table class="table table-striped text-center">
                            <thead>
                                <tr>
                                    <th>Mã sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Số lượng tồn</th>
                                    <th>Ảnh</th>
                                    <th>Thuộc tính</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($product->variants as $variant)
                                <tr>
                                    <td>{{ $variant->product_code }}</td>
                                    <td>{{ number_format($variant->price) }} đ</td>
                                    <td>{{ $variant->stock_quantity }}</td>
                                    <td>
                                        @if ($variant->image)
                                        <img src="{{ asset('storage/' . $variant->image) }}" alt="Variant Image"
                                            width="100" />
                                        @endif
                                    </td>
                                    <td>
                                        @foreach ($variant->attributes as $attribute)
                                        <!-- Truy xuất giá trị thuộc tính từ attribute_value -->
                                        @php
                                        $attribute_value = $attribute->attributeValue;
                                        @endphp
                                        <span>({{ $attribute_value->value }})</span>
                                        @endforeach
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
</div>
@endsection