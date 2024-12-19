@extends('layouts.admin')

@section('content')
<div class="row m-3">
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Chi tiết người dùng</h4>
        </div>
    </div>
<div class="container">
    <h2></h2>

    <div class="card">
        <div class="card-body">
            <h5>Thông tin người dùng</h5>
            <ul>
                <li><strong>Tên:</strong> {{ $user->name }}</li>
                <li><strong>Email:</strong> {{ $user->email }}</li>
                <li><strong>Số điện thoại:</strong> {{ $user->number_phone ?? 'Chưa cập nhật' }}</li>
                <li><strong>Địa chỉ:</strong> {{ $user->address ?? 'Chưa cập nhật' }}</li>
                <li><strong>Ngày tạo tài khoản:</strong> {{ $user->created_at->format('d-m-Y') }}</li>
            </ul>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <h5>Thống kê đơn hàng</h5>
            <ul>
                <li><strong>Tổng số đơn hàng:</strong> {{ $totalOrders }}</li>
                <li><strong>Đơn hàng đã hoàn thành:</strong> {{ $completedOrders }}</li>
            </ul>
        </div>
    </div>
</div>

@endsection
