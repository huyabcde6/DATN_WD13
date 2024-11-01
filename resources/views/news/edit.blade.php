@extends('layouts.app')

@section('content')
    <h1>Sửa Tin tức</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('news.update', $news->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="title">Tiêu đề:</label>
        <input type="text" name="title" value="{{ $news->title }}" required>

        <label for="content">Nội dung:</label>
        <textarea name="content" required>{{ $news->content }}</textarea>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
@endsection
