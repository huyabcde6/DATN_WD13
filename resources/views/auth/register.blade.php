@extends('layouts.home')

@section('content')

    <div class="section section-margin">
        <div class="container">
        <div class="row mb-n10 justify-content-center">

            <div class="col-lg-6 col-md-8 m-auto m-lg-0 pb-10">
                <!-- Register Wrapper Start -->
                <div class="register-wrapper ">
            <div class="row mb-n10 justify-content-center">
                <div class="">
                        <!-- Title and Description Start -->
                        <div class="section-content text-center mb-5 ">
                            <h2 class="title mb-2">Tạo tài khoản</h2>
                            <p class="desc-content">Vui lòng đăng ký bằng cách sử dụng chi tiết tài khoản bên dưới.</p>
                        </div>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="single-input-item mb-3">
                                <input type="text" name="name" placeholder="Họ và tên" value="{{ old('name') }}"
                                     autofocus>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Name Input End -->

                            <!-- Email Input Start -->
                            <div class="single-input-item mb-3">
                                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}"
                                    >
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Email Input End -->

                            <!-- Password Input Start -->
                            <div class="single-input-item mb-3">
                                <input type="password" name="password" placeholder="Mật khẩu" >
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Password Input End -->

                            <!-- Confirm Password Input Start -->
                            <div class="single-input-item mb-3">
                                <input type="password" name="password_confirmation" placeholder="Xác nhận mật khẩu"
                                    >
                                @error('password_confirmation')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Confirm Password Input End -->

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
@endsection
