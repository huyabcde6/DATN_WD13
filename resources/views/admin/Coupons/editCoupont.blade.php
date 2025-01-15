@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-center">Chỉnh Sửa Mã Giảm Giá</h2>

    <!-- Display success message -->
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('admin.Coupons.update', $coupon->id) }}" method="POST">
                @csrf
                @method('POST') <!-- Use PUT for update -->

                <div class="row">
                    <!-- Thông tin mã giảm giá -->
                    <div class="col-12">
                        <h4 class="mb-3">Thông Tin Mã Giảm Giá</h4>
                        <div class="row">
                            <!-- Mã giảm giá -->
                            <div class="col-md-6 mb-3">
                                <label for="code" class="form-label">Mã Giảm Giá</label>
                                <input type="text" name="code" id="code"
                                    class="form-control @error('code') is-invalid @enderror"
                                    placeholder="Nhập mã giảm giá"
                                    value="{{ old('code', $coupon->code) }}">

                                <!-- Display validation error for 'code' -->
                                @error('code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <!-- Loại giảm giá -->
                            <div class="col-md-6 mb-3">
                                <label for="discount_type" class="form-label">Loại Giảm Giá</label>
                                <select name="discount_type" id="discount_type" class="form-select" required disabled>
                                    <option value="percentage">Phần Trăm</option>
                                </select>
                                <input type="hidden" name="discount_type" value="percentage">
                                @error('discount_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Giá trị giảm -->
                            <div class="col-md-6 mb-3">
                                <label for="discount_value" class="form-label">Giá Trị Giảm</label>
                                <input type="text" name="discount_value" id="discount_value"
                                    class="form-control @error('discount_value') is-invalid @enderror"
                                    placeholder="Nhập giá trị giảm"
                                    value="{{ old('discount_value', number_format($coupon->discount_value, 0, '.', '')) }}">

                                <!-- Display validation error for 'discount_value' -->
                                @error('discount_value')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <!-- Số tiền giảm tối đa -->
                            <div class="col-md-6 mb-3">
                                <label for="max_discount_amount" class="form-label">Giảm Tối Đa (VNĐ)</label>
                                <input type="text" name="max_discount_amount" id="max_discount_amount"
                                    class="form-control @error('max_discount_amount') is-invalid @enderror"
                                    placeholder="Nhập số tiền tối đa"
                                    value="{{ old('max_discount_amount', number_format($coupon->max_discount_amount, 0, '.', '')) }}">

                                <!-- Display validation error for 'max_discount_amount' -->
                                @error('max_discount_amount')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <!-- Số tiền tối thiểu của đơn hàng -->
                            <div class="col-md-6 mb-3">
                                <label for="min_order_amount" class="form-label">Đơn Hàng Tối Thiểu (VNĐ)</label>
                                <input type="number" name="min_order_amount" id="min_order_amount"
                                    class="form-control @error('min_order_amount') is-invalid @enderror"
                                    placeholder="Nhập số tiền tối thiểu"
                                    value="{{ old('min_order_amount', number_format($coupon->min_order_amount, 0, '.', '')) }}">

                                <!-- Display validation error for 'min_order_amount' -->
                                @error('min_order_amount')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <!-- Ngày bắt đầu -->
                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label">Ngày Bắt Đầu</label>
                                <input type="datetime-local" name="start_date" id="start_date"
                                    class="form-control @error('start_date') is-invalid @enderror"
                                    value="{{ old('start_date', \Carbon\Carbon::parse($coupon->start_date)->format('Y-m-d\TH:i')) }}"
                                    min="{{ now()->format('Y-m-d\TH:i') }}">

                                <!-- Display validation error for 'start_date' -->
                                @error('start_date')
                                <div class=" invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <!-- Ngày kết thúc -->
                            <div class="col-md-6 mb-3">
                                <label for="end_date" class="form-label">Ngày Kết Thúc</label>
                                <input type="datetime-local" name="end_date" id="end_date"
                                    class="form-control @error('end_date') is-invalid @enderror"
                                    value="{{ old('end_date', \Carbon\Carbon::parse($coupon->end_date)->format('Y-m-d\TH:i')) }}"
                                    min="{{ now()->format('Y-m-d\TH:i') }}">

                                <!-- Display validation error for 'end_date' -->
                                @error('end_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <!-- Số lượng mã -->
                            <div class="col-md-6 mb-3">
                                <label for="total_quantity" class="form-label">Số Lượng Mã</label>
                                <input type="number" name="total_quantity" id="total_quantity"
                                    class="form-control @error('total_quantity') is-invalid @enderror"
                                    placeholder="Nhập số lượng mã"
                                    value="{{ old('total_quantity', $coupon->total_quantity) }}">

                                <!-- Display validation error for 'total_quantity' -->
                                @error('total_quantity')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <!-- Trạng thái -->
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Trạng Thái</label>
                                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="active" {{ old('status', $coupon->status) == 'active' ? 'selected' : '' }}>Hoạt Động</option>
                                    <option value="disabled" {{ old('status', $coupon->status) == 'disabled' ? 'selected' : '' }}>Không Hoạt Động</option>
                                </select>

                                <!-- Display validation error for 'status' -->
                                @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
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