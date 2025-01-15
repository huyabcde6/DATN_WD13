@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Thêm Mới Ca Làm Việc</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.shifts.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Tên Ca Làm Việc:</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Nhập tên ca làm việc" required>
        </div>

        <div class="form-group">
            <label for="start_time">Giờ Bắt Đầu:</label>
            <input type="text" name="start_time" id="start_time" class="form-control" placeholder="HH:mm" required>
        </div>

        <div class="form-group">
            <label for="end_time">Giờ Kết Thúc:</label>
            <input type="text" name="end_time" id="end_time" class="form-control" placeholder="HH:mm" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Thêm Mới</button>
    </form>
</div>
@endsection
