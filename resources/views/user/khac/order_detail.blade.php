@extends('layouts.home')
@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    .custom-container {
        margin: 0 auto;
        padding: 0 15px;
        max-width: 90%;
    }

    /* Tổng thể thẻ card */
    .card {
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 15px;
        background-color: #fff;
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    }

    /* Nội dung bên trong card */
    .card .col-md-10 {
        font-size: 16px;
        line-height: 1.6;
    }

    .card .col-md-10 p {
        margin-bottom: 10px;
    }

    .card .col-md-10 strong {
        color: #333;
    }

    /* Nút hành động */
    .card .col-md-2 .btn {
        font-size: 14px;
        padding: 8px 15px;
        width: 100%;
        text-align: center;
        transition: background-color 0.3s, border-color 0.3s;
    }

    .card .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .card .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .card .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }

    .card .btn:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .card .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }

    .card .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    /* Canh lề */
    .d-flex.m-3.justify-content-between {
        margin: 20px 0;
    }

    /* Khoảng cách tổng thể */
    .card p {
        margin-bottom: 8px;
    }

    /* Căn chỉnh khoảng cách form */
    form {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    /* Căn giữa nút */
    .text-center a {
        display: inline-block;
        margin-top: 10px;
        margin-bottom: 10px;
        font-weight: bold;
    }

    /* Hiệu ứng hover cho các dòng trong bảng */
    .table tbody tr:hover {
        background-color: #f7f7f7;
        cursor: pointer;
    }

    /* Định dạng cho bảng */
    .table {
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
    }

    .table th,
    .table td {
        padding: 12px 15px;
    }
</style>
@endsection

@section('content')
<div class="section section-margin">
    <div class="container">
        <div class="d-flex justify-content-between my-3">
            <div class="col-md-11">
                <h2 class="title text-center">Thông tin đơn hàng: <span
                        class="text-danger">{{ $order->order_code }}</span></h2>
            </div>
            <div class="col-md-1">
                <div class="d-flex justify-content-end mb-4">
                    <a href="{{ route('orders.index') }}" class="btn btn-primary">Quay lại</a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="col-lg-12 mb-5">
                <div class="row mx-3 my-3">
                    <!-- Thẻ thông tin đơn hàng -->
                    <div class="card">
                        <div class="d-flex m-3 justify-content-between">
                            <div class="col-md-12">
                                <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d-m-Y') }}</p>
                                <p id="order-status-{{ $order->id }}"><strong>Trạng thái đơn hàng:</strong> <mark>{{ $order->status->type ?? 'N/A' }}</mark></p>
                                <p style="font-size: 14px;"><strong>Trạng thái thanh toán:</strong> <mark> {{ $order->payment_status }}</mark></p>
                                <p><strong>Người nhận:</strong> {{ $order->nguoi_nhan }}</p>
                                <p><strong>Email:</strong> {{ $order->email }}</p>
                                <p><strong>Số điện thoại:</strong> {{ $order->number_phone }}</p>
                                <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
                                <p><strong>Ghi chú:</strong> {{ $order->ghi_chu }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bảng thông tin chi tiết đơn hàng -->
                <div class="container mt-4">
                    <table class="table table-bordered text-center">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Tên sản phẩm</th>
                                <th>Hình ảnh</th>
                                <th>Màu</th>
                                <th>Size</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                                <th>Tổng tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderDetails as $key => $detail)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $detail->products->name }}</td>
                                <td>
                                    <img src="{{ url('storage/'. $detail->products->avata) }}"
                                        alt="{{ $detail->products->name }}" style="width: 70px; height: auto;">
                                </td>
                                <td>{{ $detail->color }}</td>
                                <td>{{ $detail->size }}</td>
                                <td>{{ $detail->quantity }}</td>
                                <td>{{ number_format($detail->price, 0, '', ',') }} ₫</td>
                                <td>{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }} đ</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex flex-column justify-content-end mx-3 mb-5">
    <h5 class="d-flex justify-content-between w-100">
 <strong>Tổng phụ :</strong> <span class="text-end">{{ number_format($totalAmount, 0, ',', '.') }} đ</span></span>
    </h5> 
    <h5 class="d-flex justify-content-between w-100">
        <strong>Ship :</strong> <span class="text-end">30.000 đ</span>
    </h5> 
    <h5 class="d-flex justify-content-between w-100">
        <strong>Mã giảm giá :</strong> <span class="text-end">  - {{ $order->discount ? number_format($order->discount, 0, ',', '.') : '0' }} đ</span>
    </h5>
    <h5 class="d-flex justify-content-between w-100">
        <strong>Tổng tiền:</strong> <span class="text-end">{{ number_format($order->total_price, 0, ',', '.') }} đ</span>
    </h5>
</div>
                <div class="d-flex mx-3 justify-content-end">
                    <form action="{{ route('orders.update', $order->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('POST')

                        @if($order->status->type === \App\Models\StatusDonHang::CHO_XAC_NHAN)
                        <!-- Nếu trạng thái là 'Chờ xác nhận' -->
                        <input type="hidden" name="huy_don_hang" value="1">
                        <button type="submit" class="btn btn-primary"
                            onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?');">
                            Hủy đơn hàng
                        </button>
                        @elseif($order->status->type === \App\Models\StatusDonHang::DA_GIAO_HANG)
                        <input type="hidden" name="da_giao_hang" value="4">
                        <button type="submit" class="btn btn-success"
                            onclick="return confirm('Bạn xác nhận đã nhận hàng?');">
                            Đã nhận hàng
                        </button>
                        @elseif($order->status->type === \App\Models\StatusDonHang::DA_GIAO_HANG)
                        <input type="hidden" name="cho_xac_nhan" value="9">
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#returnModal">
                            Trả hàng
                        </button>

                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="returnModal" tabindex="-1" aria-labelledby="returnModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="returnModalLabel">Lý do trả hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('orders.update', $order->id) }}" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="cho_xac_nhan" value="1">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="reason">Lý do trả hàng</label>
                        <textarea name="return_reason" id="reason" class="form-control" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger">Gửi lý do</button>
                </div>
            </form>
        </div>
    </div>
</div>
@vite('resources/js/sttoder.js');
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection