@extends('layouts.home')

@section('content')
<div class="header section">
    <!-- Breadcrumb Section Start -->
    <div class="section">

        <!-- Breadcrumb Area Start -->
        <div class="breadcrumb-area bg-light">
            <div class="container-fluid">
                <div class="breadcrumb-content text-center">
                    <h1 class="title">Liên hệ với chúng tôi</h1>
                    <ul>
                        <li>
                            <a href="index.html">Trang chủ </a>
                        </li>
                        <li class="active">Liên hệ</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Breadcrumb Area End -->

    </div>
    <!-- Breadcrumb Section End -->

    <!-- Contact Us Section Start -->
    <div class="section section-margin">
        <div class="container">
            <div class="row mb-n10">
                <div class="col-12 col-lg-8 mb-10">
                    <!-- Section Title Start -->
                    <div class="section-title" data-aos="fade-up" data-aos-delay="300">
                        <h2 class="title pb-3">Liên hệ</h2>
                        <span></span>
                        <div class="title-border-bottom"></div>
                    </div>
                    <!-- Section Title End -->
                    <!-- Contact Form Wrapper Start -->
                    <div class="contact-form-wrapper contact-form">
                        <form action="https://htmldemo.net/destry/destry/assets/php/destry.php" id="contact-form" method="post">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-6" data-aos="fade-up" data-aos-delay="300">
                                            <div class="input-item mb-4">
                                                <input class="input-item" type="text" placeholder="Tên của bạn" name="name">
                                            </div>
                                        </div>
                                        <div class="col-md-6" data-aos="fade-up" data-aos-delay="400">
                                            <div class="input-item mb-4">
                                                <input class="input-item" type="email" placeholder="Email" name="email">
                                            </div>
                                        </div>
                                        <div class="col-12" data-aos="fade-up" data-aos-delay="300">
                                            <div class="input-item mb-4">
                                                <input class="input-item" type="text" placeholder="Subject" name="subject">
                                            </div>
                                        </div>
                                        <div class="col-12" data-aos="fade-up" data-aos-delay="400">
                                            <div class="input-item mb-8">
                                                <textarea class="textarea-item" name="message" placeholder="Tin nhắn"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12" data-aos="fade-up" data-aos-delay="500">
                                            <button type="submit" id="submit" name="submit" class="btn btn-dark btn-hover-primary rounded-0">Gửi tin nhắn</button>
                                        </div>
                                        <p class="col-8 form-message mb-0"></p>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <p class="form-messege"></p>
                    </div>
                    <!-- Contact Form Wrapper End -->
                </div>
                <div class="col-12 col-lg-4 mb-10">
                    <!-- Section Title Start -->
                    <div class="section-title" data-aos="fade-up" data-aos-delay="300">
                        <h2 class="title pb-3">Địa chỉ liên hệ</h2>
                        <span></span>
                        <div class="title-border-bottom"></div>
                    </div>
                    <!-- Section Title End -->

                    <!-- Contact Information Wrapper Start -->
                    <div class="row contact-info-wrapper mb-n6">

                        <!-- Single Contact Information Start -->
                        <div class="col-lg-12 col-md-6 col-sm-12 col-12 single-contact-info mb-6" data-aos="fade-up" data-aos-delay="300">

                            <!-- Single Contact Icon Start -->
                            <div class="single-contact-icon">
                                <i class="fa fa-map-marker"></i>
                            </div>
                            <!-- Single Contact Icon End -->

                            <!-- Single Contact Title Content Start -->
                            <div class="single-contact-title-content">
                                <h4 class="title">Địa chỉ</h4>
                                <p class="desc-content">Bắc Từ Liêm <br>Hà Nội</p>
                            </div>
                            <!-- Single Contact Title Content End -->

                        </div>
                        <!-- Single Contact Information End -->

                        <!-- Single Contact Information Start -->
                        <div class="col-lg-12 col-md-6 col-sm-12 col-12 single-contact-info mb-6" data-aos="fade-up" data-aos-delay="400">

                            <!-- Single Contact Icon Start -->
                            <div class="single-contact-icon">
                                <i class="fa fa-mobile"></i>
                            </div>
                            <!-- Single Contact Icon End -->

                            <!-- Single Contact Title Content Start -->
                            <div class="single-contact-title-content">
                                <h4 class="title">Liên hệ chúng tôi bất cứ khi nào</h4>
                                <p class="desc-content">Số điện thoại: 0973320198 </p>
                            </div>
                            <!-- Single Contact Title Content End -->

                        </div>
                        <!-- Single Contact Information End -->

                        <!-- Single Contact Information Start -->
                        <div class="col-lg-12 col-md-6 col-sm-12 col-12 single-contact-info mb-6" data-aos="fade-up" data-aos-delay="500">

                            <!-- Single Contact Icon Start -->
                            <div class="single-contact-icon">
                                <i class="fa fa-envelope-o"></i>
                            </div>
                            <!-- Single Contact Icon End -->

                            <!-- Single Contact Title Content Start -->
                            <div class="single-contact-title-content">
                                <h4 class="title">Hỗ trợ tổng thể</h4>
                                <p class="desc-content"><a href="#">huyabcde6@gmail.com</a> <br><a href="#"></a> </p>
                            </div>
                            <!-- Single Contact Title Content End -->

                        </div>
                        <!-- Single Contact Information End -->

                    </div>
                    <!-- Contact Information Wrapper End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Contact us Section End -->

    <!-- Contact Map Start -->
    <div class="section" data-aos="fade-up" data-aos-delay="300">
        <!-- Google Map Area Start -->
        <div class="google-map-area w-100">
            <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.8639311820666!2d105.74468687503176!3d21.03812978061353!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313455e940879933%3A0xcf10b34e9f1a03df!2zVHLGsOG7nW5nIENhbyDEkeG6s25nIEZQVCBQb2x5dGVjaG5pYw!5e0!3m2!1svi!2s!4v1733283838785!5m2!1svi!2s" 
            width="100%" 
            height="600" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
            {{-- <iframe class="contact-map" 
            width="100%" 
            height="450" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy" 
            src="https://maps.app.goo.gl/BzNojcQfWU1Bd6E36">
        </iframe> --}}
        </div>
        <!-- Google Map Area Start -->
    </div>
    <!-- Contact Map End -->
    <!-- Scroll Top Start -->
    <a href="#" class="scroll-top" id="scroll-top">
        <i class="arrow-top fa fa-long-arrow-up"></i>
        <i class="arrow-bottom fa fa-long-arrow-up"></i>
    </a>
    <!-- Scroll Top End -->
    @endsection