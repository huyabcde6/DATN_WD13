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
        <div class="d-flex justify-content-center m-3">
            <h2>Quản lý đơn hàng</h2>
        </div>
        <div class="d-flex m-3">
            <form action="{{ route('users.index') }}" method="get" class="">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" value="{{ request('search') }}" name="search" id="search"
                        class="form-control" placeholder="Nhập từ khóa cần tìm..">
                    <button type="submit" class="btn btn-secondary">Tìm kiếm</button>
                </div>
            </form>
        </div>
        <div class="col-md-12">
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã đơn hàng</th>
                        <th>Ngày tạo</th>
                        
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th> 
                        <th>Hành động</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($orders as $key => $order)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $order->order_code }}</td>
                            <td>{{ $order->created_at->format('d-m-Y') }}</td>
                            <td>{{ number_format($order->total_price, 2) }} $</td>
                            <td>
                                <form  action="{{ route('admin.orders.update', $order->id) }}" method="post">
                                    @csrf
                                    @method('POST')
                                    <select class="form-select text-center" name="status" onchange="this.form.submit()">
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
                                <a href="{{ route('admin.orders.show', $order->id) }}"  style="margin-top: 10px;">
                                    <i class="mdi mdi-eye text-muted fs-18 rounded-2 border p-1 me-1"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection
