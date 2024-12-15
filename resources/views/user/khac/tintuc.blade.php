@extends('layouts.home')

@section('content')
    <!-- Breadcrumb Section Start -->
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
                            <a href="http://datn_wd13.test/tin_tuc">Tin tức</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Breadcrumb Area End -->

    </div>
    <!-- Breadcrumb Section End -->

    <!-- Blog Section Start -->
    <div class="section section-margin">
        <div class="container">

            <div class="row mb-n8">
                @foreach($news as $new)
                <div class="col-md-6 col-lg-4 mb-8" data-aos="fade-up" data-aos-delay="200">
                    <!-- Single Blog Start -->
                    <div class="blog-single-post-wrapper">
                        <div class="blog-thumb">
                            <a class="blog-overlay" href="blog-details.html">
                                <img src="assets/images/blog/blog-post/1.jpg" alt="Blog Post">
                            </a>
                        </div>
                        <div class="blog-content">
                            <div class="post-meta">
                                <span>By : <a href="#">Admin</a></span>
                                <span>{{ $new->created_at }}</span>
                            </div>
                            <h3 class="title"><a href="blog-details.html">{{ $new->title }}</a></h3>
                            <p>{{ $new->description }}</p>
                            <a href="blog-details.html" class="link">Đọc thêm</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endsection
