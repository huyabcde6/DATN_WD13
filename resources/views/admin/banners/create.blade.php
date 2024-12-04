@extends('layouts.admin')

@section('title')
    Thêm mới Banner
@endsection

@section('content')
    <div class="container">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Thêm mới Banner</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    @if ($errors->any())
                        <div class="alert alert-danger mt-3 mb-3">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form class="m-4" action="{{ route('admin.banners.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <label>Tiêu Đề</label>
                            <input type="text" name="title" class="form-control">
                        </div><br>

                        <div class="form-group">
                            <label>Mô Tả</label>
                            <textarea name="description" class="form-control" rows="6"></textarea>
                        </div><br>

                        <div class="form-group">
                            <label>Ảnh Banner</label>
                            <input type="file" name="image_path" class="form-control">
                        </div><br>

                        <div class="form-group">
                            <label>Thứ Tự Hiển Thị</label>
                            <input type="number" name="order" class="form-control" value="0">
                        </div><br>

                        <button type="submit" class="btn btn-success mt-4">Lưu Banner</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
