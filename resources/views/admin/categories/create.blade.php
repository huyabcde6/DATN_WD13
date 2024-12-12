@extends('layouts.admin')

@section('content')
    <div class="content">
        <!-- Start Content-->
        <div class="container-xxl">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Thêm danh mục</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Danh mục</a></li>
                        <li class="breadcrumb-item active">Thêm danh mục</li>
                    </ol>
                </div>
            </div>

            <!-- General Form -->
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header">
                            <h5 class="card-title mb-0">Thêm danh mục</h5>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form action="{{ route('admin.categories.store') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <input type="hidden" name="gioi_tinh" value="12">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="simpleinput" class="form-label">Tên danh mục</label>
                                                    <input type="text" placeholder="Nhập tên danh mục" value="{{ old('name') }}" name="name" class="form-control">
                                                    @error('name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="example-email" class="form-label">Trạng thái</label><br>
                                                    <div class="mt-2">
                                                        <input type="radio" name="status" value="1" class="form-check-input" checked> Hiển thị
                                                        <input type="radio" name="status" value="0" class="form-check-input" {{ old('status') == '0' ? 'checked' : '' }}> Ẩn
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-success">Thêm</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div> 
@endsection
