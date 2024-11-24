@extends('layouts.admin')

@section('title')
Quản lý đơn hàng
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
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Danh sách đơn hàng</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="d-flex m-3">
                    <form action="{{ route('users.index') }}" method="get" class="">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" value="{{ request('search') }}" name="search" id="search"
                                class="form-control" placeholder="Nhập từ khóa cần tìm..">
                            <button type="submit" class="btn btn-dark">Tìm kiếm</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-12">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Mã đơn hàng</th>
                                <th>Ngày tạo</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Tương tác</th>
                            </tr>
                        </thead>

                        <tbody id="order-list">
                            @foreach($orders as $key => $order)
                            <tr data-order-id="{{ $order->id }}">
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $order->order_code }}</td>
                                <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                <td>{{ number_format($order->total_price, 2) }} $</td>
                                <td>
                                    <form action="{{ route('admin.orders.update', $order->id) }}" method="post" class="order-status-form">
                                        @csrf
                                        @method('PUT')
                                        <select class="form-select text-center" name="status"
                                            onchange="this.form.submit()">
                                            <option value="1" {{ $order->status_donhang_id === 1 ? 'selected' : '' }}>
                                                Chờ xác nhận
                                            </option>
                                            <option value="2" {{ $order->status_donhang_id === 2 ? 'selected' : '' }}>
                                                Đã xác nhận
                                            </option>
                                            <option value="3" {{ $order->status_donhang_id === 3 ? 'selected' : '' }}>
                                                Đang vận chuyển
                                            </option>
                                            <option value="4" {{ $order->status_donhang_id === 4 ? 'selected' : '' }}>
                                                Hoàn thành
                                            </option>
                                            <option value="5" {{ $order->status_donhang_id === 5 ? 'selected' : '' }}>
                                                Đã hủy
                                            </option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order->id) }}" style="margin-top: 10px;">
                                        <i class="mdi mdi-eye text-muted fs-18 rounded-2 border p-1 me-1"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{ $orders->links('pagination::bootstrap-5') }}
    </div>
</div>


@endsection

@section('js')
<script>
    window.Echo.channel('order-updated')
        .listen('.order.updated', (e) => {
            const orderRow = document.querySelector(`[data-order-id="${e.order.id}"]`);
            if (orderRow) {
                orderRow.querySelector('select[name="status"]').value = e.order.status_donhang_id;
            }
        });
</script>
@endsection