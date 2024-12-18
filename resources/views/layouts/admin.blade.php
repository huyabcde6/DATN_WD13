<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from zoyothemes.com/tapeli/html/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 16 Jul 2024 08:33:02 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>

    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc." />
    <meta name="author" content="Zoyothemes" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="http://datn_wd13.test/ngdung/assets/images/logo/logo1.png">

    <!-- App css -->
    <link href="{{ asset('assets/admin/css/app.min.css')}}" rel="stylesheet" type="text/css" id="app-style" />
    <!-- Quill css -->
    <link href="{{asset('assets/admin/libs/quill/quill.core.js')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/admin/libs/quill/quill.snow.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/admin/libs/quill/quill.bubble.css')}}" rel="stylesheet" type="text/css" />
    <!-- Icons -->
    <link href="{{ asset('assets/admin/css/icons.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Latest compiled and minified CSS -->

    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->

    <!-- Latest compiled JavaScript -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    @yield('css')
</head>

<!-- body start -->

<body data-menu-color="light" data-sidebar="default">

    <!-- Begin page -->
    <div id="app-layout">


        @include('admin.blocks.header')

        @include('admin.blocks.sidebar')



        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            @yield('content')

            @include('admin.blocks.footer')


        </div>
        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

    <!-- Vendor -->
    <script src="{{ asset('assets/admin/libs/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('assets/admin/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('assets/admin/libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{ asset('assets/admin/libs/node-waves/waves.min.js')}}"></script>
    <script src="{{ asset('assets/admin/libs/waypoints/lib/jquery.waypoints.min.js')}}"></script>
    <script src="{{ asset('assets/admin/libs/jquery.counterup/jquery.counterup.min.js')}}"></script>
    <script src="{{ asset('assets/admin/libs/feather-icons/feather.min.js')}}"></script>

    <!-- Apexcharts JS -->
    <script src="{{ asset('assets/admin/libs/apexcharts/apexcharts.min.js')}}"></script>

    <!-- for basic area chart -->
    <script src="{{ asset('assets/admin/apexcharts.com/samples/assets/stock-prices.js')}}"></script>

    <!-- Widgets Init Js -->
    @yield('js')
    <script src="{{ asset('assets/admin/js/pages/analytics-dashboard.init.js')}}"></script>

    <script type="module">
        @if (session()->has('status_succeed'))
            toastr.success('{{ session()->pull('status_succeed') }}', {
                timeOut: 1000
            });
        @endif

        @if (session()->has('status_failed'))
            toastr.error('{{ session()->pull('status_failed') }}', {
                timeOut: 1000
            });
        @endif
    </script>

    <!-- App js-->
    <script src="{{ asset('assets/admin/js/app.js')}}"></script>

</body>

<!-- Mirrored from zoyothemes.com/tapeli/html/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 16 Jul 2024 08:34:03 GMT -->

</html>
