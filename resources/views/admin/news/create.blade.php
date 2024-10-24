@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Thêm tin tức</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                    <label>Tiêu đề</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label>Mô tả ngắn</label>
                    <textarea name="short_description" class="form-control" rows="3"></textarea>
                </div>

                <div class="form-group mb-3">
                    <label>Nội dung</label>
                    <textarea name="content" class="form-control" id="editor" rows="10"></textarea>
                </div>

                <div class="form-group mb-3">
                    <label>Hình ảnh</label>
                    <input type="file" name="thumbnail" class="form-control">
                </div>

                <div class="form-group mb-3">
                    <label>Trạng thái</label>
                    <select name="status" class="form-control">
                        <option value="1">Hiện</option>
                        <option value="0">Ẩn</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Lưu</button>
                <a href="{{ route('news.index') }}" class="btn btn-default">Quay lại</a>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="//cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor');
</script>
@endpush