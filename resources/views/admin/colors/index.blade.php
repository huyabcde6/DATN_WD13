@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Danh Sách Màu Sắc</h1>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Giá Trị</th>
                <th>Trạng Thái</th>
                <th>Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($colors as $color)
                <tr>
                    <td>{{ $color->color_id }}</td>
                    <td>{{ $color->value }}</td>
                    <td>{{ $color->status ? 'Kích hoạt' : 'Không kích hoạt' }}</td>
                    <td>
                        <!-- Thêm các liên kết để chỉnh sửa và xóa -->
                        <a href="{{ route('colors.edit', $color->color_id) }}" class="btn btn-warning">Chỉnh sửa</a>
                        <form action="{{ route('colors.destroy', $color->color_id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('colors.create') }}" class="btn btn-primary">Thêm Kích Màu Sắc mới</a>
</div>
@endsection
