@extends('layouts.home')

@section('content')
<!-- Breadcrumb Section Start -->
<div class="section">

    <!-- Breadcrumb Area Start -->
    <div class="section">

            <!-- Breadcrumb Area Start -->
            <div class="breadcrumb">
                <a href="http://datn_wd13.test/"><i class="fa fa-home"></i> Trang Chủ</a>
                <span class="breadcrumb-separator"> > </span>
                <span><a href="http://datn_wd13.test/tin_tuc">Tin tức</a></span>
                <span class="breadcrumb-separator"> > </span>
                <span><a href="http://datn_wd13.test/tintuc/{{ $news->id }}">{{ $news->title }}</a></span>
            </div>


            <!-- Breadcrumb Area End -->

        </div>
    <!-- Breadcrumb Area End -->

</div>
<!-- Breadcrumb Section End -->

<!-- Blog Details Section Start -->
<div class="section section-margin">
    <div class="container">

        <div class="row">
            <!-- Blog Main Area Start -->
            <div class="col-lg-9 m-auto overflow-hidden">

                <!-- Single Post Details Start -->
                <div class="blog-details mb-10">

                    <!-- Blog Details Image Start -->
                    <div class="image mb-6" data-aos="fade-up" data-aos-delay="300">
                        <img class="fit-image" src="{{ url('storage/'.$news->avata) }}" alt="{{ $news->title }}">
                    </div>
                    <!-- Blog Details Image End -->

                    <!-- Single Post Details Content Start -->
                    <div class="content" data-aos="fade-up" data-aos-delay="300">

                        <!-- Title Start -->
                        <h2 class="title mb-3">{{ $news->title }}</h2>
                        <!-- Title End -->

                        <!-- Meta List Start -->
                        <div class="meta-list mb-3">
                            <span>By <a href="#" class="meta-item author mr-1">Admin</a>,</span>
                            <span class="meta-item date">{{ date('d/m/Y', strtotime($news->new_date)) }}</span>
                            <span class="meta-item view">{{ $news->view }} Lượt xem</span>
                        </div>
                        <!-- Meta List End -->

                        <!-- Description Start -->
                        <div class="desc">
                            <p>{{ $news->description }}</p>

                            <!-- Nội dung chi tiết -->
                            <p>{!! $news->detail !!}</p>
                        </div>
                        <!-- Description End -->

                    </div>
                    <!-- Single Post Details Content End -->

                    <!-- Single Post Details Footer Start -->
                    <div class="single-post-details-footer mt-10" data-aos="fade-up" data-aos-delay="300">
                        <!-- Share Article Start -->
                        <div class="share-article">
                            <h6 class="share-title text-uppercase">Chia sẻ bài viết</h6>
                        </div>
                        <!-- Share Article Start -->
                        <!-- Social Share Start -->
                        <div class="widget-social border-top pt-2">
                            <a title="Facebook" href="#"><i class="fa fa-facebook-f"></i></a>
                            <a title="Twitter" href="#"><i class="fa fa-twitter"></i></a>
                            <a title="Linkedin" href="#"><i class="fa fa-linkedin"></i></a>
                            <a title="Youtube" href="#"><i class="fa fa-youtube"></i></a>
                        </div>
                        <!-- Social Share End -->
                    </div>
                    <!-- Single Post Details Footer End -->

                </div>
                <!-- Single Post Details End -->
            </div>
            <!-- Blog Main Area End -->
        </div>

    </div>
</div>
<!-- Blog Details Section End -->
@endsection