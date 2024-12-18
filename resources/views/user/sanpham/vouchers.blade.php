@extends('layouts.home')

@section('content')
<div class="section">

    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb">
        <a href="http://datn_wd13.test/"><i class="fa fa-home"></i> Trang Chủ</a>
        <span class="breadcrumb-separator"> > </span>
        <span><a href="http://datn_wd13.test/cart">Giỏ hàng</a></span>
    </div>


    <!-- Breadcrumb Area End -->

</div>
<div class="container">
    <h2>Danh sách Voucher</h2>
    <div class="row">
        @forelse($coupons as $voucher)
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Mã: {{ $voucher->code }}</h5>
                        <p> Loại Giảm giá: {{ $voucher->discount_percentage }}</p>
                        <p> Giá trị giảm giá: {{ $voucher->discount_value }}</p>
                        <p> Số tiền giảm tối đa: {{ $voucher->max_discount_amount }}</p>
                        <p> Giá trị đơn hàng tối thiểu: {{ $voucher->min_order_amount }}</p>
                        <p> Ngày bắt đầu: {{ $voucher->start_date }}</p>
                        <p>Ngày kết thúc: {{ $voucher->end_date }}</p>
                        <p> Số lượng mã phát hành : {{ $voucher->total_quantity }}</p>
                        <p>Số lượng mã đã sử dụng: {{ $voucher->used_quantity }}</p>
                        <p>Trạng thái: {{ $voucher->status }}</p>
                    </div>
                </div>
            </div>
        @empty
            <p>Không có voucher nào khả dụng.</p>
        @endforelse
    </div>
</div>
@endsection
