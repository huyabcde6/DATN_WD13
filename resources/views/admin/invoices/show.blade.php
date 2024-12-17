@extends('layouts.admin')

@section('content')
<div class="row m-3">
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Chi tiết hóa đơn</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="panel-body">
                        <div class="clearfix">
                            <div class="float-start d-flex justify-content-center">
                                <h4 class="mb-0 caption fw-semibold fs-18"><strong>Khách hàng:
                                    </strong>{{$invoice->nguoi_nhan}}</h4>
                            </div>
                            <div class="float-end">
                                <h4 class="fs-18">Hóa đơn # {{$invoice->id}}<br>
                                    <strong class="fs-15 fw-normal">Số hóa đơn</strong>
                                </h4>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="float-start mt-3">
                                    <address>
                                        <strong title="Phone">Số điện thoại:</strong> {{$invoice->number_phone}}<br>
                                        <strong title="Email">Email:</strong> {{$invoice->email}}<br>
                                        <strong>Địa chỉ:</strong>
                                        {{$invoice->address}}

                                    </address>
                                </div>
                                <div class="float-end mt-3">
                                    <p class="mb-0"><strong>Ngày đặt hàng: </strong>
                                        {{ \Carbon\Carbon::parse($invoice->date_invoice)->format('d-m-Y') }}</p>

                                    <p class="mt-2 mb-0"><strong>Trạng thái đơn hàng: </strong> <span
                                            class="label label-pink">{{$invoice->status->type}}</span></p>
                                    <p class="mt-2 mb-0"><strong>Mã đơn hàng: </strong>{{$invoice->order_code}}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive rounded-2">
                                    <table class="table mt-4 mb-4 table-centered border ">
                                        <thead class="rounded-2">
                                            <tr>
                                                <th>#</th>
                                                <th>Tên sản phẩm</th>
                                                <th>Hình ảnh</th>
                                                <th>Màu</th>
                                                <th>Size</th>
                                                <th>Số lượng</th>
                                                <th>Giá</th>
                                                <th>Tổng</th>
                                            </tr>
                                        </thead>
                                        <tbody class="align-middle">

                                            @foreach($invoice->invoiceDetails as $key => $detail)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $detail->product_name }}</td>
                                                <td>
                                                    <img src="{{ url('storage/' . $detail->product->avata ?? '' )}}"
                                                        alt="" class="img-thumbnail" style="width: 70px; height: auto;">
                                                </td>
                                                <td>{{ $detail->color }}</td>
                                                <td>{{ $detail->size }}</td>
                                                <td>{{ $detail->quantity }}</td>
                                                <td>{{ number_format($detail->price, 0, ',', '.') }} đ</td>
                                                <td>{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}
                                                    đ</td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="6"></td>
                                                <td colspan="2">
                                                    <table class="table table-sm text-nowrap mb-0 table-borderless ">
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <p class="mb-0">Tạm tính :</p>
                                                                </td>
                                                                <td>
                                                                    <p class="mb-0 fw-medium fs-15">
                                                                        {{ number_format($invoice->subtotal, 0, ',', '.') }}
                                                                        đ
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td scope="row">
                                                                    <p class="mb-0">Phí ship :</p>
                                                                </td>
                                                                <td>
                                                                    <p class="mb-0 fw-medium fs-15">
                                                                        {{ number_format($invoice->shipping_fee, 0, ',', '.') }}
                                                                        đ</p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td scope="row">
                                                                    <p class="mb-0">Giảm giá :</p>
                                                                </td>
                                                                <td>
                                                                    <p class="mb-0 fw-medium fs-15">
                                                                        {{ number_format($invoice->discount, 0, ',', '.') }}
                                                                        đ</p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td scope="row">
                                                                    <p class="mb-0">Ngày thanh toán :</p>
                                                                </td>
                                                                <td>
                                                                    <p class="mb-0 fw-medium fs-15">
                                                                        {{ \Carbon\Carbon::parse($invoice->update_at)->format('d-m-Y') }}
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td scope="row">
                                                                    <p class="mb-0 fs-5"><strong>Tổng tiền phải
                                                                            trả</strong> :</p>
                                                                </td>
                                                                <td>
                                                                    <p class="mb-0 fw-medium fs-16 text-danger">
                                                                        {{ number_format($invoice->total_price, 0, ',', '.') }}
                                                                        đ</p>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="d-print-none">
                            <div class="float-end">
                                <a href="javascript:window.print()" class="btn btn-dark border-0"><i
                                        class="mdi mdi-printer me-1"></i>Print</a>
                                <a href="#" class="btn btn-primary">Submit</a>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection