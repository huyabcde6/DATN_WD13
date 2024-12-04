@extends('layouts.home')
{{-- cap nhap  --}}
@section('content')
    <div class="section">

        <!-- Breadcrumb Area Start -->
        <div class="breadcrumb-area bg-light">
            <div class="container-fluid">
                <div class="breadcrumb-content text-center">
                    <h1 class="title">Đăng nhập</h1>
                    <ul>
                        <li>
                            <a href="index.html">Trang chủ </a>
                        </li>
                        <li class="active"> Đăng nhập </li>
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
                            <p class="desc-content">Vui lòng đăng nhập bằng chi tiết tài khoản bên dưới.</p>
                            @if ($message = Session::get('error'))
                                <div class="alert alert-danger alert-block">

                                    <button type="button" class="close" data-dismiss="alert">×</button>

                                    <strong>{{ $message }}</strong>

                                </div>
                            @endif
                        </div>
                        <!-- Login Title & Content End -->

                        <!-- Form Action Start -->
                        <form action="#" method="post">
                            @csrf
                            <!-- Input Email Start -->
                            <div class="single-input-item mb-3">
                                <input type="email" name="email" placeholder="Email">
                            </div>
                            <!-- Input Email End -->

                            <!-- Input Password Start -->
                            <div class="single-input-item mb-3">
                                <input type="password" name="password" placeholder="Nhập mật khẩu">
                            </div>
                            <!-- Input Password End -->

                            <!-- Checkbox/Forget Password Start -->
                            <div class="single-input-item mb-3">
                                <div class="login-reg-form-meta d-flex align-items-center justify-content-between">
                                    <div class="remember-meta mb-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="rememberMe">
                                            <label class="custom-control-label" for="rememberMe">Ghi nhớ</label>
                                        </div>
                                    </div>
                                    <a href="#" class="forget-pwd mb-3">Quên mật khẩu?</a>
                                </div>
                            </div>
                            <!-- Checkbox/Forget Password End -->

                            <!-- Login Button Start -->
                            <div class="single-input-item mb-3">
                                <button class="btn btn btn-dark btn-hover-primary">Đăng nhập</button>
                            </div>
                            <!-- Login Button End -->

                            <!-- Lost Password & Creat New Account Start -->
                            <div class="lost-password">
                                <a href="{{ route('register') }}">Đăng ký</a>
                            </div>
                            <!-- Lost Password & Creat New Account End -->

                        </form>
                        <!-- Form Action End -->

                    </div>
                    <!-- Login Wrapper End -->
                </div>

            </div>

        </div>
    </div>
@endsection

@extends('layouts.home')

@section('content')
    <div class="section">

        <!-- Breadcrumb Area Start -->
        <div class="breadcrumb-area bg-light">
            <div class="container-fluid">
                <div class="breadcrumb-content text-center">
                    <h1 class="title">My Account</h1>
                    <ul>
                        <li>
                            <a href="index.html">Home </a>
                        </li>
                        <li class="active"> My Account </li>
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
                            <h2 class="title mb-2">Login</h2>
                            <p class="desc-content">Please login using account detail bellow.</p>
                            @if ($message = Session::get('error'))
                                <div class="alert alert-danger alert-block">

                                    <button type="button" class="close" data-dismiss="alert">×</button>

                                    <strong>{{ $message }}</strong>

                                </div>
                            @endif
                        </div>
                        <!-- Login Title & Content End -->

                        <!-- Form Action Start -->
                        <form action="#" method="post">
                            @csrf
                            <!-- Input Email Start -->
                            <div class="single-input-item mb-3">
                                <input type="email" name="email" placeholder="Email">
                            </div>
                            <!-- Input Email End -->

                            <!-- Input Password Start -->
                            <div class="single-input-item mb-3">
                                <input type="password" name="password" placeholder="Enter your Password">
                            </div>
                            <!-- Input Password End -->

                            <!-- Checkbox/Forget Password Start -->
                            <div class="single-input-item mb-3">
                                <div class="login-reg-form-meta d-flex align-items-center justify-content-between">
                                    <div class="remember-meta mb-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="rememberMe">
                                            <label class="custom-control-label" for="rememberMe">Remember Me</label>
                                        </div>
                                    </div>
                                    <a href="#" class="forget-pwd mb-3">Forget Password?</a>
                                </div>
                            </div>
                            <!-- Checkbox/Forget Password End -->

                            <!-- Login Button Start -->
                            <div class="single-input-item mb-3">
                                <button class="btn btn btn-dark btn-hover-primary">Login</button>
                            </div>
                            <!-- Login Button End -->

                            <!-- Lost Password & Creat New Account Start -->
                            <div class="lost-password">
                                <a href="{{ route('register') }}">Create Account</a>
                            </div>
                            <!-- Lost Password & Creat New Account End -->

                        </form>
                        <!-- Form Action End -->

                    </div>
                    <!-- Login Wrapper End -->
                </div>

            </div>

        </div>
    </div>
@endsection
