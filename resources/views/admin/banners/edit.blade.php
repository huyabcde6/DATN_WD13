@extends('layouts.admin')

@section('title')
    Chỉnh sửa Banner
@endsection

@section('content')
    <div class="container">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Chỉnh sửa Banner</h4>
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
                    <form class="m-4" action="{{ route('admin.banners.update', $banner->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Tiêu Đề</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $banner->title) }}">
                        </div><br>

                        <div class="form-group">
                            <label>Mô Tả</label>
                            <textarea name="description" class="form-control" rows="6">{{ old('description', $banner->description) }}</textarea>
                        </div><br>

                        <div class="form-group">
                            <label>Ảnh Banner</label>
                            <input type="file" name="image_path" class="form-control">
                        </div><br>

                        <div class="form-group">
                            <label>Thứ Tự Hiển Thị</label>
                            <input type="number" name="order" class="form-control" value="{{ old('order', $banner->order) }}">
                        </div><br>

                        <button type="submit" class="btn btn-warning mt-4">Sửa Banner</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
