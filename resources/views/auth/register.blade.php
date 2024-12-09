@extends('layouts.home')

@section('content')
<div class="section">

    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb-area bg-light">
        <div class="container-fluid">
            <div class="breadcrumb-content text-center">
                <h1 class="title">Đăng ký</h1>
                <ul>
                    <li>
                        <a href="#">Trang chủ </a>
                    </li>
                    <li class="active"> Đăng ký </li>
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
                        <h2 class="title mb-2">Tạo tài khoản</h2>
                        <p class="desc-content">Vui lòng đăng ký bằng cách sử dụng chi tiết tài khoản bên dưới.</p>
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
                            <input type="password" name="password_confirmation" placeholder="Xác nhận mật khẩu" required>
                            @error('password_confirmation')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Confirm Password Input End -->

                        <!-- Newsletter Checkbox Start -->
                        {{-- <div class="single-input-item mb-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="subscribe_newsletter" name="subscribe_newsletter">
                                <label class="custom-control-label" for="subscribe_newsletter">Subscribe to Our Newsletter</label>
                            </div>
                        </div> --}}
                        <!-- Newsletter Checkbox End -->

                        <!-- Register Button Start -->
                        <div class="single-input-item mb-3">
                            <button type="submit" class="btn btn-dark btn-hover-primary rounded-0">Đăng ký</button>
                        </div>
                        <!-- Register Button End -->
                        <!-- Login Link Start -->                       
                        <div class="lost-password">
                            <a href="{{ route('login') }}">Bạn đã có tài khoản ?</a>
                        </div>
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
