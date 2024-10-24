@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách tin tức</h3>
            <div class="card-tools">
                <a href="{{ route('news.create') }}" class="btn btn-primary">Thêm mới</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tiêu đề</th>
                        <th>Hình ảnh</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($news as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->title }}</td>
                        <td>
                            @if($item->thumbnail)
                                <img src="{{ asset($item->thumbnail) }}" width="100">
                            @endif
                        </td>
                        <td>{{ $item->status ? 'Hiện' : 'Ẩn' }}</td>
                        <td>
                            <a href="{{ route('news.edit', $item->id) }}" class="btn btn-sm btn-primary">Sửa</a>
                            <form action="{{ route('news.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection