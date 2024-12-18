@extends('layouts.home')

@section('content')
<style>

h2 {
    text-align: center;
    font-size: 2rem;
    font-weight: bold;
    color: #343a40;
    margin-bottom: 30px;
}

.card {
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    background-color: #fff;
}

.card:hover {
    transform: translateY(-10px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
}

.card-body {
    padding: 20px;
}

.card-body p {
    margin-bottom: 10px;
    font-size: 1rem;
    color: #495057;
}

.card-title {
    font-size: 1.25rem;
    font-weight: bold;
    color: #007bff;
    margin-bottom: 15px;
}

.discount-type-percentage {
    color: #007bff;
    font-weight: bold;
}

.discount-type-fixed_amount {
    color: #28a745;
    font-weight: bold;
}

.status-active {
    color: #28a745;
    font-weight: bold;
}

.status-inactive {
    color: #dc3545;
    font-weight: bold;
}

.col-md-4 {
    width: 100%;
    max-width: 33.3333%;
}

@media (max-width: 768px) {
    .col-md-4 {
        max-width: 100%;
    }
}

.breadcrumb {
    font-size: 1rem;
    margin-bottom: 20px;
}

.breadcrumb a {
    color: #007bff;
    text-decoration: none;
}

.breadcrumb a:hover {
    text-decoration: underline;
}

.breadcrumb-separator {
    color: #343a40;
}

</style>
<div class="container">
    <h2>Danh sách Voucher</h2>
    <div class="row">
        @forelse($coupons as $voucher)
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Mã: {{ $voucher->code }}</h5>
                        <p> Loại Giảm giá:
                            @if($voucher->discount_type == 'percentage')
                                <span class="discount-type-percentage">Giảm theo phần trăm</span>
                            @elseif($voucher->discount_type == 'fixed_amount')
                                <span class="discount-type-fixed_amount">Giảm theo số tiền</span>
                            @else
                                {{ $voucher->discount_type }}
                            @endif
                        </p>
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
