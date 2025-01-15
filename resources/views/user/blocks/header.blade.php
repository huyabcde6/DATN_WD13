<!DOCTYPE html>
<html lang="en">
<!-- Mirrored from htmldemo.net/destry/destry/index-2.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 08 Oct 2024 15:50:01 GMT -->

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>POLY STORE</title>
    <!-- Favicons -->
    <link rel="shortcut icon" href="http://datn_wd13.test/ngdung/assets/images/logo/logo1.png" />
    <!-- Vendor CSS (Icon Font) -->

    <link rel="stylesheet" href="{{ asset('ngdung/assets/css/vendor/fontawesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('ngdung/assets/css/vendor/pe-icon-7-stroke.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">


    <link rel="stylesheet" href="{{ asset('ngdung/assets/css/plugins/swiper-bundle.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('ngdung/assets/css/plugins/animate.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('ngdung/assets/css/plugins/aos.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('ngdung/assets/css/plugins/nice-select.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('ngdung/assets/css/plugins/jquery-ui.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('ngdung/assets/css/plugins/lightgallery.min.css')}}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">


    <!-- Main Style CSS -->

    <link rel="stylesheet" href="{{ asset('ngdung/assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('ngdung/assets/css/loading.css') }}" />
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
</head>
<style>
    .notification {
        position: absolute;
        right: 10px;
        /* Khoảng cách từ cạnh phải của chuông */
        top: 0;
    }

    .notification-container {
        position: relative;
    }

    .notification-icon {
        cursor: pointer;
        position: relative;
    }

    .notification-badge {
        position: absolute;
        top: 0;
        right: -5px;
        background-color: red;
        color: white;
        border-radius: 50%;
        padding: 5px 8px;
        font-size: 12px;
    }

    .notification-panel {
        position: absolute;
        top: -40px;
        right: 0;
        background-color: #fff;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
        display: none;
        /* Ẩn bảng thông báo mặc định */
        z-index: 100;
    }

    .notification-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 15px;
        background-color: #f0f2f5;
        border-bottom: 1px solid #ddd;
    }

    .notification-content {
        max-height: 300px;
        overflow-y: auto;
    }

    .notification-item {
        padding: 10px 15px;
        border-bottom: 1px solid #ddd;
    }

    .notification-footer {
        padding: 10px 15px;
        background-color: #f0f2f5;
        text-align: center;
    }
</style>
<script>
    async function toggleNotifications() {
        const panel = document.getElementById('notificationPanel');
        const isVisible = panel.style.display === 'block';

        if (!isVisible) {
            // Hiện bảng thông báo
            panel.style.display = 'block';

            // Gọi API để lấy dữ liệu mới nhất
            try {
                const response = await fetch('/api/get-latest-notifications');
                if (response.ok) {
                    const notifications = await response.json();
                    displayNotifications(notifications);
                } else {
                    console.error('Failed to fetch notifications:', response.statusText);
                }
            } catch (error) {
                console.error('Error fetching notifications:', error);
            }
        } else {
            // Ẩn bảng thông báo
            panel.style.display = 'none';
        }
    }

    // Hàm hiển thị thông báo
    function displayNotifications(notifications) {
        const content = document.querySelector('.notification-content');
        content.innerHTML = ''; // Xóa nội dung cũ

        if (notifications.length === 0) {
            content.innerHTML = '<p>Không có thông báo mới.</p>';
        } else {
            notifications.forEach(notification => {
                const item = document.createElement('div');
                item.className = 'notification-item';
                item.innerHTML = `
                <p><strong>${notification.changed_by_name  || 'Admin'}</strong></p>
                
               <p>Đơn hàng <strong>${notification.order_code }</strong> của bạn đã được : 
    ${notification.current_status || 'Không có nội dung'}
</p>
                <span style='text-align: right;  /* Canh phải */
    font-size: 0.8em;    /* Giảm kích thước chữ */
    display: block; '>
    ${timeSince(new Date(notification.created_at))}
</span>
            `;
                content.appendChild(item);
            });
        }
    }

    function timeSince(date) {
        const seconds = Math.floor((new Date() - date) / 1000); // Chênh lệch tính bằng giây

        const intervals = [{
                label: 'năm',
                seconds: 31536000
            },
            {
                label: 'tháng',
                seconds: 2592000
            },
            {
                label: 'ngày',
                seconds: 86400
            },
            {
                label: 'giờ',
                seconds: 3600
            },
            {
                label: 'phút',
                seconds: 60
            },
            {
                label: 'giây',
                seconds: 1
            }
        ];

        for (const interval of intervals) {
            const count = Math.floor(seconds / interval.seconds);
            if (count > 0) {
                return `${count} ${interval.label} trước`;
            }
        }

        return 'vừa xong'; // Nếu khoảng cách thời gian rất nhỏ
    }
</script>

<body>
    {{-- <div class="loader" style="display: none;"></div> --}}
    <div class="header section">
        <!-- Header Bottom Start -->
        <div class="header-bottom">
            <div class="header-sticky">
                <div class="container">
                    <div class="row align-items-center">
                        <!-- Header Logo Start -->
                        <div class="col-xl-2 col-6">
                            <div class="header-logo">
                                <a href="{{route('home.index')}}"><img src="{{ asset('ngdung/assets/images/logo/logo1.png') }}"
                                        alt="Site Logo" width="250xp" height="135px" /></a>
                            </div>
                        </div>
                        <!-- Header Logo End -->

                        <!-- Header Menu Start -->
                        <div class="col-xl-8 d-none d-xl-block">
                            <div class="main-menu position-relative">
                                <ul>
                                    <li class="has-children">
                                        <a href="{{route('home.index')}}"><span>Trang Chủ</span></a>
                                    </li>
                                    <li class="has-children position-static">
                                        <a href="{{route('shop.index')}}"><span>Cửa hàng</span></a>

                                    </li>
                                    <li class="has-children">
                                        <a href="{{ route('introduction') }}"><span>Về chúng tôi</span></a>
                                    </li>
                                    <li class="has-children">
                                        <a href="{{ route('news.index') }}"><span>Tin Tức</span></a>
                                    </li>
                                    <li>
                                        <a href="{{ route('contact') }}"> <span>Liên Hệ</span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Header Menu End -->

                        <!-- Header Action Start -->
                        <div class="col-xl-2 col-6">
                            
                            <div class="header-actions">
                                <!-- Search Header Action Button Start -->
                                <!-- <a href="javascript:void(0)" ><i
                                        class="pe-7s-search"></i></a> -->
                                <!-- Search Header Action Button End -->

                                <!-- User Account Header Action Button Start -->

                                @auth
                                <a href="{{ route('orders.index') }}" class="header-action-btn d-none d-md-block">
                                    <span>Hi, {{ last(explode(' ', Auth::user()->name)) }}</span>
                                </a>
                                @else
                                <a href="{{ route('login') }}" class="header-action-btn d-none d-md-block">
                                    <i class="pe-7s-user"></i>
                                </a>
                                @endauth

                                <!-- User Account Header Action Button End -->

                                <!-- Wishlist Header Action Button Start -->

                                <!-- Wishlist Header Action Button End -->

                                <!-- Shopping Cart Header Action Button Start -->
                                <a href="{{ route('cart.index') }}" class="header-action-btn header-action-btn-cart">
                                    <i class="pe-7s-shopbag"></i>
                                    <span class="header-action-num">{{ session('cart') ? count(session('cart')) : '0' }}
                                    </span>
                                </a>

                                <!-- Shopping Cart Header Action Button End -->

                                <!-- Mobile Menu Hambarger Action Button Start -->
                                <a href="javascript:void(0)"
                                    class="header-action-btn header-action-btn-menu d-xl-none d-lg-block">
                                    <i class="fa fa-bars"></i>
                                </a>
                                <!-- Mobile Menu Hambarger Action Button End -->
                                <a href="#" class="header-action-btn header-action-btn-offcanvas-notification" style="font-size: 20px;" onclick="toggleNotifications()">
                                    <i class="fa-solid fa-bell fa-shake"></i>
                                    <!-- <span class="notification-badge">3</span> -->
                                </a>
                            </div>
                        </div>
                        <!-- Header Action End -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Header Bottom End -->

        <!-- Mobile Menu Start -->
        <div class="mobile-menu-wrapper">
            <div class="offcanvas-overlay"></div>

            <!-- Mobile Menu Inner Start -->
            <div class="mobile-menu-inner">
                <!-- Button Close Start -->
                <div class="offcanvas-btn-close">
                    <i class="pe-7s-close"></i>
                </div>
                <!-- Button Close End -->

                <!-- Mobile Menu Start -->
                <div class="mobile-navigation">
                    <nav>
                        <ul class="mobile-menu">
                            <li class="has-children">
                                <a href="#">Home </a>
                            </li>
                            <li class="has-children">
                                <a href="#">Sản Phẩm <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                                <ul class="dropdown">
                                    <li><a href="shop-grid.html">Shop Grid</a></li>
                                </ul>
                            </li>
                            <li class="has-children">
                                <a href="#">Dịch Vụ </a>
                            </li>
                            <li class="has-children">
                                <a href="#">Tin Tức</a>
                            </li>
                            <li><a href="contact.html">Liên Hệ</a></li>
                        </ul>
                    </nav>
                </div>
                <!-- Mobile Menu End -->
                <!-- Contact Links/Social Links Start -->
                <div class="mt-auto">
                    <!-- Contact Links Start -->
                    <ul class="contact-links">
                        <li>
                            <i class="fa fa-phone"></i><a href="#"> +012 3456 789 123</a>
                        </li>
                        <li>
                            <i class="fa fa-envelope-o"></i><a href="#"> info@example.com</a>
                        </li>
                        <li>
                            <i class="fa fa-clock-o"></i>
                            <span>Monday - Sunday 9.00 - 18.00</span>
                        </li>
                    </ul>
                    <!-- Contact Links End -->

                    <!-- Social Widget Start -->
                    <div class="widget-social">
                        <a title="Facebook" href="#"><i class="fa fa-facebook-f"></i></a>
                        <a title="Twitter" href="#"><i class="fa fa-twitter"></i></a>
                        <a title="Linkedin" href="#"><i class="fa fa-linkedin"></i></a>
                        <a title="Youtube" href="#"><i class="fa fa-youtube"></i></a>
                        <a title="Vimeo" href="#"><i class="fa fa-vimeo"></i></a>
                    </div>
                    <!-- Social Widget Ende -->
                </div>
                <!-- Contact Links/Social Links End -->
            </div>
            <!-- Mobile Menu Inner End -->
        </div>
        <!-- Mobile Menu End -->

        <!-- Offcanvas Search Start -->
        <!-- Offcanvas Notification Start -->
        <div class="notification-container">
            <div class="notification-panel" id="notificationPanel">
                <div class="notification-header">
                    <h8>Thông báo</h8>
                </div>
                <div class="notification-content">
                    <!-- Các thông báo sẽ được thêm vào đây -->
                </div>
                <div class="notification-footer">
                    <a href="#">Xem thông báo trước đó</a>
                </div>
            </div>
        </div>



        <!-- Offcanvas Notification End -->


        <!-- Offcanvas Search End -->

        <!-- Cart Offcanvas Start -->
        <div class="cart-offcanvas-wrapper">
            <div class="offcanvas-overlay"></div>

            <!-- Cart Offcanvas Inner Start -->
            {{-- <div class="cart-offcanvas-inner">
                <!-- Button Close Start -->
                <div class="offcanvas-btn-close">
                    <i class="pe-7s-close"></i>
                </div>
                <!-- Button Close End -->

                <!-- Offcanvas Cart Content Start -->

                <!-- Offcanvas Cart Content End -->
            </div> --}}
            <!-- Cart Offcanvas Inner End -->
        </div>
        <!-- Cart Offcanvas End -->
    </div>