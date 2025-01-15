@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Chỉnh Sửa Ca Làm Việc</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.shifts.update', $shift->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Tên Ca Làm Việc:</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $shift->name) }}" required>
        </div>

        <div class="form-group">
            <label for="start_time">Giờ Bắt Đầu:</label>
            <input type="time" name="start_time" id="start_time" class="form-control" value="{{ old('start_time', $shift->start_time) }}" required>
        </div>

        <div class="form-group">
            <label for="end_time">Giờ Kết Thúc:</label>
            <input type="time" name="end_time" id="end_time" class="form-control" value="{{ old('end_time', $shift->end_time) }}" required>
        </div>
        <button type="submit" class="btn btn-success mt-3">Cập Nhật</button>
        <a href="{{ route('admin.shifts.index') }}" class="btn btn-secondary mt-3">Quay Lại</a>
    </form>
</div>
@endsection
