@extends('layouts.home')

@section('content')
    <div class="section">

        <div class="breadcrumb-area bg-light ">
            <div class="container-fluid">
                <div class="breadcrumb-content">
                    <ul class="breadcrumb-list">
                        <li>
                            <a href="http://datn_wd13.test">Trang chủ</a>
                        </li>
                        <li class="active">
                            <a href="http://datn_wd13.test/login">Đăng nhập</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Breadcrumb Area End -->

    </div>
    <div class="section section-margin">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 m-auto m-lg-0 pb-10">
                    <!-- Login Wrapper Start -->
                    <div class="login-wrapper">

                        <!-- Login Title & Content Start -->
                        <div class="section-content text-center mb-5">
                            <h2 class="title mb-2">Đăng nhập</h2>
                            <p class="desc-content">Vui lòng đăng nhập tài khoản dưới đây .</p>
                            @if ($message = Session::get('error'))
                                <div class="alert alert-danger alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif
                            <x-auth-session-status class="mb-4" :status="session('status')" />
                        </div>
                        <!-- Login Title & Content End -->

                        <!-- Form Action Start -->
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <!-- Input Email Start -->
                            <div class="single-input-item mb-3">
                                <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="Email" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            <!-- Input Email End -->

                            <!-- Input Password Start -->
                            <div class="single-input-item mb-3">
                                <x-text-input id="password" class="block w-full" type="password" name="password" required placeholder="Nhập mật khẩu của bạn" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            <!-- Input Password End -->

                            <!-- Checkbox/Forget Password Start -->
                            <div class="single-input-item mb-3">
                                <div class="login-reg-form-meta d-flex align-items-center justify-content-between">
                                    <div class="remember-meta mb-3">
                                        <div class="custom-control custom-checkbox">
                                            <input id="remember_me" type="checkbox" class="custom-control-input" name="remember">
                                            <label class="custom-control-label" for="remember_me">Nhớ tôi</label>
                                        </div>
                                    </div>
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="forget-pwd mb-3">Quên mật khẩu ?</a>
                                    @endif
                                </div>
                            </div>
                            <!-- Checkbox/Forget Password End -->

                            <!-- Login Button Start -->
                            <div class="single-input-item mb-3">
                                <button class="btn btn btn-dark btn-hover-primary">Đăng nhập</button>
                            </div>
                            <!-- Login Button End -->

                            <!-- Lost Password & Create New Account Start -->
                            <div class="lost-password">
                                <a href="{{ route('register') }}">Tạo tài khoản</a>
                            </div>
                            <!-- Lost Password & Create New Account End -->

                        </form>
                        <!-- Form Action End -->

                    </div>
                    <!-- Login Wrapper End -->
                </div>
            </div>

        </div>
    </div>
@endsection
