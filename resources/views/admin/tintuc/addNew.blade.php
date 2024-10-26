@extends('layouts.admin')

@section('title')
Thêm mới tin tức
@endsection

@section('content')

<body data-menu-color="light" data-sidebar="default">
    <div class="d-flex justify-content-center m-3">
        <h2>Thêm Mới Tin Tức</h2>
    </div>
    <form action="" method="post">
        <div class="mb-3">
            <label for="simpleinput" class="form-label">Tiêu đề</label>
            <input type="text" id="simpleinput" class="form-control">
        </div>
        <div class="mb-3">
            <label for="example-email" class="form-label">Mô tả ngắn</label>
            <input type="text" name="example-email" class="form-control">
        </div>
        <div class="mb-3">
            <label for="formFile" class="form-label">Ảnh bìa</label>
            <input class="form-control" type="file" id="formFile">
        </div>
        <!-- <div class="content"> -->
        <!-- Start Content-->
        <!-- <div class="container-xxl"> -->

        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Chi tiết tin tức</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div id="quill-editor" style="height: 400px;">
                            <H1>Hell world</H1>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- </div> -->
        <!-- container-fluid -->

        <div class=" container d-flex justify-content-end">
            <button type="submit" class="btn btn-outline-success rounded-pill">Thêm mới</button>
        </div>

    </form>
</body>
@endsection
@section('js')
<!-- Quill Editor Js -->
<script src="{{ asset('assets/admin/libs/quill/quill.core.js')}}"></script>
<script src="{{ asset('assets/admin/libs/quill/quill.min.js')}}"></script>

<!-- Quill Demo Js -->
<script src="{{ asset('assets/admin/js/pages/quilljs.init.js')}}"></script>
@endsection