@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Danh Sách Ca Làm Việc</h1>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.shifts.create') }}" class="btn btn-primary mb-3">Thêm Mới Ca Làm Việc</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Tên Ca</th>
                <th>Giờ Bắt Đầu</th>
                <th>Giờ Kết Thúc</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($shifts as $shift)
            <tr>
                <td>{{ $shift->id }}</td>
                <td>{{ $shift->name }}</td>
                <td>{{ $shift->start_time }}</td>
                <td>{{ $shift->end_time }}</td>
                <td>
                    <a href="{{ route('admin.shifts.edit', $shift->id) }}" class="btn btn-warning">Sửa</a>
                    
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection