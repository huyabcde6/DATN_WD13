@extends('layouts.home')

@section('content')
<div class="section">

    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb-area bg-light ">
        <div class="container-fluid">
            <div class="breadcrumb-content">
                <ul class="breadcrumb-list">
                    <li>
                        <a href="http://datn_wd13.test">Trang chủ</a>
                    </li>
                    <li class="active">
                        <a href="http://datn_wd13.test/register">Đăng kí</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End -->

</div>
<div class="section section-margin">
    <div class="container">

        <div class="row mb-n10 justify-content-center">

            <div class="col-lg-6 col-md-8 m-auto m-lg-0 pb-10">
                <!-- Register Wrapper Start -->
                <div class="register-wrapper ">

                    <!-- Title and Description Start -->
                    <div class="section-content text-center mb-5 ">
                        <h2 class="title mb-2">Đăng kí</h2>
                        <p class="desc-content">Vui lòng đăng kí tài khoản dưới đây.</p>
                    </div>
                    <!-- Title and Description End -->

                    <!-- Form Start -->
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name Input Start -->
                        <div class="single-input-item mb-3">
                            <input type="text" name="name" placeholder="Họ và tên" value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Name Input End -->

                        <!-- Email Input Start -->
                        <div class="single-input-item mb-3">
                            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Email Input End -->

                        <!-- Password Input Start -->
                        <div class="single-input-item mb-3">
                            <input type="password" name="password" placeholder="Mật khẩu" required>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Password Input End -->

                        <!-- Confirm Password Input Start -->
                        <div class="single-input-item mb-3">
                            <input type="password" name="password_confirmation" placeholder="Nhập lại mật khẩu" required>
                            @error('password_confirmation')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Confirm Password Input End -->

                        <!-- Register Button Start -->
                        <div class="single-input-item mb-3">
                            <button type="submit" class="btn btn-dark btn-hover-primary rounded-0">Đăng kí</button>
                        </div>
                        <!-- Register Button End -->

                        <!-- Login Link Start -->
                        <span class="text">
                            <a href="{{ route('login') }}">Đã có tài khoản?</a>
                        </span>
                        <!-- Login Link End -->

                    </form>
                    <!-- Form End -->

                </div>
                <!-- Register Wrapper End -->
            </div>
        </div>

    </div>
</div>
@endsection
