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
                <form class="m-4" action="{{ route('admin.banners.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-group">
                        <label>Tiêu Đề</label>
                        <input type="text" name="title" class="form-control">
                        @error('title')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div><br>

                    <div class="form-group">
                        <label>Mô Tả</label>
                        <textarea name="description" class="form-control" rows="6"></textarea>
                    </div><br>
                    @error('description')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="form-group">
                        <label>Ảnh Banner</label>
                        <input type="file" name="image_path" class="form-control">
                        @error('image_path')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div><br>
                    <div class="col-sm-10 mb-3 d-flex gap-2">
                        <label for="status" class="form-label">Trạng thái: </label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="gridRadios1"
                                value="1" checked>
                            <label class="form-check-label text-success" for="gridRadios1">
                                Hiển thị
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="gridRadios2"
                                value="0">
                            <label class="form-check-label text-danger" for="gridRadios2">
                                Ẩn
                            </label>
                        </div>
                    </div>
                    <input type="hidden" name="order" class="form-control" value="0">
                    <div class="form-group">
                        <div class="col-md-5">
                            <label for="category" class="form-label">Danh mục sản phẩm</label>
                            <select id="category" name="category" class="form-select">
                                <option value="">Chọn danh mục</option>
                                @foreach($danhmuc as $it)
                                <option value="{{$it->id}}">{{$it->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @error('order')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror


                    <button type="submit" class="btn btn-success mt-4">Lưu Banner</button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection