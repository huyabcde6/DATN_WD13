 <!-- Left Sidebar Start -->
 <div class="app-sidebar-menu">
     <div class="h-100" data-simplebar>

         <!--- Sidemenu -->
         <div id="sidebar-menu">

             <div class="logo-box">
                 {{-- <a class='logo logo-light' href='index.html'>
                     <span class="logo-sm">
                         <img src="{{ asset('assets/admin/images/logo-sm.png')}}" alt="" height="22">
                 </span>
                 <span class="logo-lg">
                     <img src="{{ asset('assets/admin/images/logo-light.png')}}" alt="" height="24">
                 </span>
                 </a> --}}
                 {{-- <a class='logo logo-dark' href='index.html'>
                     <span class="logo-sm">
                         <img src="{{ asset('assets/admin/images/logo-sm.png')}}" alt="" height="22">
                 </span>
                 <span class="logo-lg">
                     <img src="{{ asset('assets/admin/images/logo-dark.png')}}" alt="" height="24">
                 </span>
                 </a> --}}
                 <div class="header-logo">
                     <a href="index.html"><img src="{{ asset('ngdung/assets/images/logo/logo1.png') }}"
                             alt="Site Logo" width="140xp" height="70px" /></a>
                 </div>
             </div>

             <ul id="side-menu">

                 <li class="menu-title">Quản trị</li>
                 <li>
                     <a class='tp-link' href="{{ route('admin.statistics.index') }}">
                         <i data-feather="home"></i>
                         <span> Dashboards </span>
                     </a>
                 </li>
                 <li>
                     <a class='tp-link' href="{{ route('admin.users.index') }}">
                         <i data-feather="users"></i>
                         <span> Quản lý người dùng </span>
                     </a>
                 </li>
                 {{-- <li class="menu-title">Kinh doanh</li> --}}
                 <li>
                     <a class='tp-link' href="{{ route('admin.categories.index') }}">
                         <i data-feather="align-center"></i>
                         <span> Danh mục sản phẩm </span>
                     </a>
                 </li>
                 <li>
                     <a class='tp-link' href="{{route('admin.products.index')}}">
                         <i data-feather="package"></i>
                         <span> Quản lý sản phẩm </span>
                     </a>
                 </li>
                 <li>
                     <a href="#sideOrder" data-bs-toggle="collapse">
                         <i data-feather="clipboard"></i>
                         <span>Quản lý đơn hàng</span>
                         <span class="menu-arrow"></span>
                     </a>
                     <div class="collapse" id="sideOrder">
                         <ul class="nav-second-level">
                             <li>
                                 <a class='tp-link' href="{{route('admin.orders.index')}}">Trạng thái đơn hàng</a>
                             </li>
                             <li>
                                 <a class='tp-link' href="{{route('admin.invoices.index')}}">Hóa đơn</a>
                             </li>
                         </ul>
                     </div>
                 </li>
                 <li>
                     <a href="#sidebar" data-bs-toggle="collapse">
                         <i data-feather="sliders"></i>
                         <span>Quản lý biến thể</span>
                         <span class="menu-arrow"></span>
                     </a>
                     <div class="collapse" id="sidebar">
                         <ul class="nav-second-level">
                             <li>
                                 <a class='tp-link' href="{{ route('admin.colors.index') }}">Màu sắc</a>
                             </li>
                             <li>
                                 <a class='tp-link' href="{{ route('admin.sizes.index') }}">Kích thước</a>
                             </li>
                         </ul>
                     </div>
                 </li>
                 <li>
                     <a class='tp-link' href="{{ route('admin.new.index') }}">
                         <i data-feather="package"></i>
                         <span>Quản Lý Tin Tức </span>
                     </a>
                 </li>
                 <li>
                    <a class='tp-link' href="{{ route('admin.banners.index') }}">
                        <i data-feather="file-text"></i>
                        <span> Quản lý Banner </span>
                    </a>
                </li>
                <li>
                     <a href="#sideRole" data-bs-toggle="collapse">
                         <i data-feather="clipboard"></i>
                         <span>Vai trò & quyền</span>
                         <span class="menu-arrow"></span>
                     </a>
                     <div class="collapse" id="sideRole">
                         <ul class="nav-second-level">
                             <li>
                                 <a class='tp-link' href="{{ url('roles') }}">Vai trò</a>
                             </li>
                             <li>
                                 <a class='tp-link' href="{{ url('permission') }}">Quyền</a>
                             </li>
                             <li>
                                 <a class='tp-link' href="{{ url('userAdmin') }}">Admin</a>
                             </li>
                         </ul>
                     </div>
                 </li>
                 <li>
                     <a class='tp-link' href="{{ route('admin.Coupons.index') }}">
                         <i data-feather="file-text"></i>
                         <span> Quản lý Mã Giảm Giá </span>
                     </a>
                 </li>
             </ul>

         </div>
         <!-- End Sidebar -->

         <div class="clearfix"></div>

     </div>
 </div>
 <!-- Left Sidebar End -->