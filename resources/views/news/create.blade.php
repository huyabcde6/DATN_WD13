@extends('layouts.app')

@section('content')
    <h1>Thêm Tin tức mới</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('news.store') }}" method="POST">
        @csrf
        <label for="title">Tiêu đề:</label>
        <input type="text" name="title" required>

        <label for="content">Nội dung:</label>
        <textarea name="content" required></textarea>

        <button type="submit" class="btn btn-primary">Thêm</button>
    </form>
@endsection
