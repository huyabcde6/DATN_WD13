@extends('layouts.admin')

@section('title')
Quản lý hóa đơn
@endsection

@section('content')

<div class="row m-3">
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Quản lý hóa đơn</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="d-flex m-3">
                    <form action="" method="get" class="">
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
                <div class="card-body">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Mã đơn hàng</th>
                                <th>Người nhận</th>
                                <th>SĐT</th>
                                <th>Ngày tạo</th>
                                <th>Tổng tiền</th>
                                <th>Hình thức thanh toán</th>
                                <th>Trạng thái thanh toán</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($invoices as $key => $invoice)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $invoice->order_code }}</td>
                                <td>{{ $invoice->user->name }}</td>
                                <td>{{ $invoice->number_phone }}</td>
                                <td>{{ \Carbon\Carbon::parse($invoice->date_invoice)->format('d-m-Y') }}</td>
                                <td>{{ number_format($invoice->total_price, 0, ',', '.') }} đ</td>
                                <td>{{ $invoice->method }}</td>
                                <td>{{ $invoice->payment_status }}</td>
                                <td>
                                    <span class="badge bg-success 
                                    
                                        style="height: 30px; line-height: 17px; font-size: 15px;">{{ optional($invoice->status)->type ?? 'Không xác định' }}</span>

                                </td>
                                <td>
                                    <a href="{{ route('admin.invoices.show', $invoice->id) }}"
                                        class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1 "
                                        data-bs-toggle="tooltip" title="Xem">
                                        <i class="mdi mdi-eye "></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{ $invoices->links('pagination::bootstrap-5') }}
    </div>
</div>

@endsection