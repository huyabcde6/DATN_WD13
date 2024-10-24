@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Sửa tin tức</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group mb-3">
                    <label>Tiêu đề</label>
                    <input type="text" name="title" class="form-control" value="{{ $news->title }}" required>
                </div>

                <div class="form-group mb-3">
                    <label>Mô tả ngắn</label>
                    <textarea name="short_description" class="form-control" rows="3">{{ $news->short_description }}</textarea>
                </div>

                <div class="form-group mb-3">
                    <label>Nội dung</label>
                    <textarea name="content" class="form-control" id="editor" rows="10">{{ $news->content }}</textarea>
                </div>

                <div class="form-group mb-3">
                    <label>Hình ảnh</label>
                    <input type="file" name="thumbnail" class="form-control">
                    @if($news->thumbnail)
                    <img src="{{ asset($news->thumbnail) }}" width="200" class="mt-2">
                @endif
            </div>

            <div class="form-group mb-3">
                <label>Trạng thái</label>
                <select name="status" class="form-control">
                    <option value="1" {{ $news->status == 1 ? 'selected' : '' }}>Hiện</option>
                    <option value="0" {{ $news->status == 0 ? 'selected' : '' }}>Ẩn</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
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