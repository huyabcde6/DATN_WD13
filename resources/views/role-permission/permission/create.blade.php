@extends('layouts.admin')

@section('title')
Quản lý Vai trò & Quyền
@endsection

@section('content')
    <div class="container mt-5">
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div>
        @endif

        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif

        <div class="row m-3">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Thêm quyền mới</h4>
                </div>
                <div class="flex-grow-2 mx-2">
                    <a href="{{ url('permission') }}" class="btn btn-dark btn-alt-secondary mx-2 fs-18 rounded-2 border p-1 me-2" data-bs-toggle="tooltip" title="Quay lại">
                        <i class="mdi mdi-arrow-left text-muted-white"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ url('permission') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-7">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Tên quyền</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Nhập tên quyền" required>
                                    </div>
                                </div>
                                <div class="col-lg-5 d-flex align-items-center">
                                    <div class="d-flex justify-content-center mt-3">
                                        <button type="submit" class="btn btn-primary">Lưu quyền</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
