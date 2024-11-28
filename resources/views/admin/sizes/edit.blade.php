<!-- resources/views/admin/sizes/edit.blade.php -->

@extends('layouts.admin')

@section('content')
    <h2>Chỉnh Sửa Kích Thước</h2>

    <form action="{{ route('admin.sizes.update', $size->size_id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="value">Giá Trị Kích Thước:</label>
            <input type="text" name="value" id="value" class="form-control" value="{{ $size->value }}" required>
        </div>
        

        <button type="submit" class="btn btn-warning mt-3">Cập Nhật</button>
        <a href="{{ route('admin.sizes.index') }}" class="btn btn-secondary mt-3">Quay lại</a>
    </form>
@endsection
