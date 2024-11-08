@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Chỉnh Sửa Màu Sắc</h1>

    <form action="{{ route('admin.colors.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="value">Giá Trị Kích Thước</label>
            <input type="text" name="value" id="value" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Lưu</button>
        <a href="{{ route('admin.colors.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
