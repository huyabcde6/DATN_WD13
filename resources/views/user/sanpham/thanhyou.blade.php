@extends('layouts.home')

@section('content')
<div class="section section-margin">
    <div class="container text-center">
        <h1>Cảm ơn bạn đã đặt hàng!</h1>
        <p>Chúng tôi sẽ gửi thông tin chi tiết đơn hàng qua email của bạn sớm nhất có thể.</p>
        <a href="{{ url('/') }}" class="btn btn-dark mt-3">Tiếp tục mua sắm</a>
    </div>
</div>
@endsection
