<!-- resources/views/admin/sizes/edit.blade.php -->

@extends('layouts.admin')

@section('content')
    <h2>Chỉnh Sửa Kích Thước</h2>

    <form action="{{ route('sizes.update', $size->size_id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="value">Giá Trị Kích Thước:</label>
            <input type="text" name="value" id="value" class="form-control" value="{{ $size->value }}" required>
        </div>
        
        <div class="form-group">
            <label for="status">Trạng Thái:</label>
            <select name="status" id="status" class="form-control">
                <option value="1" {{ $size->status ? 'selected' : '' }}>Hoạt động</option>
                <option value="0" {{ !$size->status ? 'selected' : '' }}>Không hoạt động</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success mt-3">Cập Nhật</button>
        <a href="{{ route('sizes.index') }}" class="btn btn-secondary mt-3">Quay lại</a>
    </form>
@endsection
