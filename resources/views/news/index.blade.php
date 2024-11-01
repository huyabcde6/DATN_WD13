@extends('layouts.app')

@section('content')
    <h1>Danh sách Tin tức</h1>

    <a href="{{ route('news.create') }}" class="btn btn-primary mb-3">Thêm Tin tức mới</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div>
        @foreach($news as $item)
            <div class="card mb-3"> <!-- Mỗi tin tức trong một thẻ card riêng -->
                <div class="card-body">
                    <h5 class="card-title">Tiêu đề: {{ $item->title }}</h5>
                    <p class="card-text">Nội dung: {{ $item->content }}</p>
                    <a href="{{ route('news.edit', $item->id) }}" class="btn btn-warning">Sửa</a>
                    <form action="{{ route('news.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection
