 <!-- Topbar Start -->
 <div class="topbar-custom">
     <div class="container-xxl">
         <div class="d-flex justify-content-between">
             <ul class="list-unstyled topnav-menu mb-0 d-flex align-items-center">
                 <li>
                     <button class="button-toggle-menu nav-link ps-0">
                         <i data-feather="menu" class="noti-icon"></i>
                     </button>
                 </li>
                 <li class="d-none d-lg-block">
                     <div class="position-relative topbar-search">
                         <input type="text" class="form-control bg-light bg-opacity-75 border-light ps-4"
                             placeholder="Search...">
                         <i
                             class="mdi mdi-magnify fs-16 position-absolute text-muted top-50 translate-middle-y ms-2"></i>
                     </div>
                 </li>
             </ul>

             <ul class="list-unstyled topnav-menu mb-0 d-flex align-items-center">

                 <li class="d-none d-sm-flex">
                     <button type="button" class="btn nav-link" data-toggle="fullscreen">
                         <i data-feather="maximize" class="align-middle fullscreen noti-icon"></i>
                     </button>
                 </li>
                 <li class="dropdown notification-list topbar-dropdown">
                     <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                         <i data-feather="bell" class="noti-icon"></i>
                         <span class="badge bg-danger rounded-circle noti-icon-badge">{{$unreadCount}}</span>
                     </a>
                     <div class="dropdown-menu dropdown-menu-end dropdown-lg">

                         <!-- item-->
                         <div class="dropdown-item noti-title">
                             <h5 class="m-0">
                                 Thông báo
                             </h5>
                         </div>
                         <!-- resources/views/notifications/index.blade.php -->
                         <!-- resources/views/notifications/index.blade.php -->
                         <div class="noti-scroll" data-simplebar>
                             @foreach ($notifications as $notification)
                             <a href="{{ $notification->action === 'comment' ? route('admin.comments.index') : route('admin.orders.show', $notification->order_id) }}"
                                 class="dropdown-item notify-item text-muted link-primary @if($loop->first) active @endif">

                                 <div class="d-flex align-items-center justify-content-between">
                                     <p class="notify-details">{{ $notification->user->name }}</p>
                                     <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                 </div>
                                 <p class="mb-0 user-msg">
                                     <small class="fs-14">
                                         @switch($notification->action)
                                         @case('cancel')
                                         <strong><mark>{{ $notification->order->order_code }}</mark></strong>:<span class="text-reset">Đơn hàng đã bị hủy</span>
                                         @break
                                         @case('return')
                                         <strong><mark>{{ $notification->order->order_code }}</mark></strong>:<span class="text-reset">Yêu cầu hoàn hàng</span>
                                         @break
                                         @case('complete')
                                         <strong><mark>{{ $notification->order->order_code }}</mark></strong>:<span class="text-reset">Đơn hàng đã hoàn thành</span>
                                         @break
                                         @case('comment')
                                         Đã bình luận <span class="text-reset"><strong><em>{{ $notification->comment }}</em></strong></span> cho sản phẩm <strong><mark>{{ $notification->product->name }}</mark></strong>
                                         @break
                                         @default
                                         Chưa có thông báo nào
                                         @endswitch
                                     </small>
                                 </p>
                             </a>
                             @endforeach
                         </div>




                         <!-- All-->
                         <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
                             View all
                             <i class="fe-arrow-right"></i>
                         </a>

                     </div>
                 </li>
                 <li class="dropdown notification-list topbar-dropdown">

                     <div class="dropdown-menu dropdown-menu-end dropdown-lg">

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

                     </div>
                 </li>
                 <li class="dropdown notification-list topbar-dropdown">
                     <a class="nav-link dropdown-toggle nav-user me-0" data-bs-toggle="dropdown" href="#" role="button"
                         aria-haspopup="false" aria-expanded="false">

                         <span class="pro-user-name ms-1">
                             {{ Auth::user()->name ?? '' }} <i class="mdi mdi-chevron-down"></i>
                         </span>
                     </a>
                     <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
                         <!-- item-->
                         <div class="dropdown-header noti-title">
                             <h6 class="text-overflow m-0">Welcome !</h6>
                         </div>

                         <!-- item-->
                         <a class='dropdown-item notify-item' href="{{ route('profile.edit') }}">
                             <i class="mdi mdi-account-circle-outline fs-16 align-middle"></i>
                             <span>My Account</span>
                         </a>

                         <!-- item-->
                         <a class='dropdown-item notify-item' href="{{route('home.index')}}">
                             <i class="mdi mdi-lock-outline fs-16 align-middle"></i>
                             <span>Trang người dùng</span>
                         </a>

                         <div class="dropdown-divider"></div>

                         <!-- item-->
                         <a class='dropdown-item notify-item' href="{{ route('logout') }}"
                             onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                             <i class="mdi mdi-location-exit fs-16 align-middle"></i>
                             <span>Đăng xuất</span>
                         </a>
                         <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                             @csrf
                         </form>

                     </div>
                 </li>

             </ul>
         </div>

     </div>

 </div>
 <!-- end Topbar -->