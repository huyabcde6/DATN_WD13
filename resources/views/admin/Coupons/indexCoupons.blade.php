@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Danh Sách Mã Giảm Giá</h2>
        <!-- Nút thêm mã giảm giá -->
        <a href="{{ route('admin.Coupons.create') }}" class="btn btn-success">+ Thêm Mã Giảm Giá</a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Mã giảm giá</th>
                <th>Giá trị</th>
                <th>Thời gian áp dụng</th>
                <th>Số lượng</th>
                <th>Số lượng đã sử dụng</th>
                <th>Trạng thái</th>
                <th>Điều kiện áp dụng</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($coupons as $coupon)
            <tr>
                <td>{{ $coupon->id }}</td>
                <td>{{ $coupon->code }}</td>
                <td>
                    {{ $coupon->discount_value }}%
                </td>
                <td>
                    {{ $coupon->start_date->format('d/m/Y H:i') }} -
                    {{ $coupon->end_date->format('d/m/Y H:i') }}
                </td>
                <td>{{ $coupon->total_quantity }}</td>
                <td>{{ $coupon->used_quantity }}</td>
                <td>{{ $coupon->status == 'active' ? 'Hoạt động' : 'Tạm dừng' }}</td>
                <td>
                    @if($coupon->conditions->isNotEmpty())
                    <ul>
                        @foreach($coupon->conditions as $condition)
                        @if($condition->product_id)
                        <li>Áp dụng cho sản phẩm ID: {{ $condition->product_id }}</li>
                        @endif
                        @if($condition->category_id)
                        <li>Áp dụng cho danh mục ID: {{ $condition->category_id }}</li>
                        @endif
                        @endforeach
                    </ul>
                    @else
                    Không có
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.Coupons.edit', $coupon->id) }}" class="btn btn-sm btn-primary">Sửa</a>
                    <form action="{{ route('admin.Coupons.destroy', $coupon->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                            onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center">Không có mã giảm giá nào!</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Phân trang -->
    <div class="mt-3">
        {{ $coupons->links() }}
    </div>
</div>
@endsection