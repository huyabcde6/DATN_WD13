@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Thêm Kích Thước Mới</h1>

    <form action="{{ route('colors.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="value">Giá Trị Kích Thước</label>
            <input type="text" name="value" id="value" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="status">Trạng Thái</label>
            <select name="status" id="status" class="form-control">
                <option value="1">Kích hoạt</option>
                <option value="0">Không kích hoạt</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Lưu</button>
        <a href="{{ route('colors.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
