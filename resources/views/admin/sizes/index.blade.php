@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Danh Sách Kích Thước</h1>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Giá Trị</th>

                <th>Tương tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sizes as $size)
                <tr>
                    <td>{{ $size->size_id }}</td>
                    <td>{{ $size->value }}</td>
                    <td>
                        <!-- Thêm các liên kết để chỉnh sửa và xóa -->
                        <a href="{{ route('admin.sizes.edit', $size->size_id) }}" class="btn btn-warning">Chỉnh sửa</a>
                        <form action="{{ route('admin.sizes.destroy', $size->size_id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('admin.sizes.create') }}" class="btn btn-primary">Thêm Kích Thước Mới</a>
</div>
@endsection
