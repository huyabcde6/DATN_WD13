@extends('layouts.admin')
@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-center">Chỉnh Sửa Mã Giảm Giá</h2>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('admin.Coupons.update', $coupon->id) }}" method="POST">
                @csrf
                @method('POST') <!-- Method PUT dùng cho cập nhật -->

                <div class="row">
                    <!-- Thông tin mã giảm giá -->
                    <div class="col-12">
                        <h4 class="mb-3">Thông Tin Mã Giảm Giá</h4>
                        <div class="row">
                            <!-- Mã giảm giá -->
                            <div class="col-md-6 mb-3">
                                <label for="code" class="form-label">Mã Giảm Giá</label>
                                <input type="text" name="code" id="code"
                                    class="form-control"
                                    placeholder="Nhập mã giảm giá"
                                    value="{{ old('code', $coupon->code) }}"
                                    required>
                            </div>

                            <!-- Loại giảm giá -->
                            <div class="col-md-6 mb-3">
                                <label for="discount_type" class="form-label">Loại Giảm Giá</label>
                                <select name="discount_type" id="discount_type" class="form-select" required>
                                    <option value="percentage" {{ old('discount_type', $coupon->discount_type) == 'percentage' ? 'selected' : '' }}>Phần Trăm</option>
                                    <option value="fixed_amount" {{ old('discount_type', $coupon->discount_type) == 'fixed_amount' ? 'selected' : '' }}>Số Tiền Cố Định</option>
                                </select>
                            </div>

                            <!-- Giá trị giảm -->
                            <div class="col-md-6 mb-3">
                                <label for="discount_value" class="form-label">Giá Trị Giảm</label>
                                <input type="number" name="discount_value" id="discount_value"
                                    class="form-control"
                                    placeholder="Nhập giá trị giảm"
                                    value="{{ old('discount_value', $coupon->discount_value) }}"
                                    required>
                            </div>

                            <!-- Số tiền giảm tối đa -->
                            <div class="col-md-6 mb-3">
                                <label for="max_discount_amount" class="form-label">Giảm Tối Đa (VNĐ)</label>
                                <input type="number" name="max_discount_amount" id="max_discount_amount"
                                    class="form-control"
                                    placeholder="Nhập số tiền tối đa"
                                    value="{{ old('max_discount_amount', $coupon->max_discount_amount) }}">
                            </div>

                            <!-- Số tiền tối thiểu của đơn hàng -->
                            <div class="col-md-6 mb-3">
                                <label for="min_order_amount" class="form-label">Đơn Hàng Tối Thiểu (VNĐ)</label>
                                <input type="number" name="min_order_amount" id="min_order_amount"
                                    class="form-control"
                                    placeholder="Nhập số tiền tối thiểu"
                                    value="{{ old('min_order_amount', $coupon->min_order_amount) }}">
                            </div>

                            <!-- Ngày bắt đầu -->
                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label">Ngày Bắt Đầu</label>
                                <input type="datetime-local" name="start_date" id="start_date"
                                    class="form-control"
                                    value="{{ old('start_date', \Carbon\Carbon::parse($coupon->start_date)->format('Y-m-d\TH:i')) }}"
                                    required>
                            </div>

                            <!-- Ngày kết thúc -->
                            <div class="col-md-6 mb-3">
                                <label for="end_date" class="form-label">Ngày Kết Thúc</label>
                                <input type="datetime-local" name="end_date" id="end_date"
                                    class="form-control"
                                    value="{{ old('end_date', \Carbon\Carbon::parse($coupon->end_date)->format('Y-m-d\TH:i')) }}"
                                    required>
                            </div>

                            <!-- Số lượng mã -->
                            <div class="col-md-6 mb-3">
                                <label for="total_quantity" class="form-label">Số Lượng Mã</label>
                                <input type="number" name="total_quantity" id="total_quantity"
                                    class="form-control"
                                    placeholder="Nhập số lượng mã"
                                    value="{{ old('total_quantity', $coupon->total_quantity) }}"
                                    required>
                            </div>

                            <!-- Trạng thái -->
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Trạng Thái</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="active" {{ old('status', $coupon->status) == 'active' ? 'selected' : '' }}>Hoạt Động</option>
                                    <option value="disabled" {{ old('status', $coupon->status) == 'disabled' ? 'selected' : '' }}>Không Hoạt Động</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Điều kiện áp dụng -->
                    <div class="col-12 mt-4">
                        <h4 class="mb-3">Điều Kiện Áp Dụng</h4>
                        <div class="row">
                            <!-- Áp dụng cho sản phẩm -->
                            <div class="col-md-6 mb-3">
                                <label for="product_id" class="form-label">Áp Dụng Cho Sản Phẩm</label>
                                <select name="product_id[]" id="product_id" class="form-select" multiple>
                                    @foreach($products as $product)
                                    <option value="{{ $product->id }}"
                                        {{ in_array($product->id, old('product_id', $coupon->product_id ?? [])) ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Áp dụng cho danh mục -->
                            <div class="col-md-6 mb-3">
                                <label for="category_id" class="form-label">Áp Dụng Cho Danh Mục</label>
                                <select name="category_id[]" id="category_id" class="form-select" multiple>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ in_array($category->id, old('category_id', $coupon->category_id ?? [])) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Nút hành động -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.Coupons.index') }}" class="btn btn-secondary">Quay Lại</a>
                    <button type="submit" class="btn btn-primary">Cập Nhật Mã Giảm Giá</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection