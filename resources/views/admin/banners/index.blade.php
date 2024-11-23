@extends('layouts.admin')

@section('title')
    Quản lý Banner
@endsection

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif

    <div class="row m-3">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Quản lý Banner</h4>
            </div>
        </div>
        <div class="col-md-12">
            <button class="btn btn-success m-3" type="submit">
                <a href="{{ route('admin.banners.create') }}" style="color: white; text-decoration: none">Thêm Banner Mới</a>
            </button>
            <div class="card">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tiêu đề</th>
                            <th>Ảnh</th>
                            <th>Mô tả</th>
                            <th>Tương tác</th>
                        </tr>
                    </thead>
    
                    <tbody>
                        @foreach ($banners as $banner)
                            <tr>
                                <td>{{ $banner->id }}</td>
                                <td>{{ $banner->title }}</td>
                                <td>
                                    
                                    <img src="{{ \Storage::url($banner->image_path) }}" width="100px" alt="">
                                </td>
                                <td>{{ $banner->description }}</td>
                                <td>
                                    <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-sm btn-warning">Sửa</a>
                                    <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
    
                                        <button type="submit" onclick="return confirm('Bạn có chắc muốn xóa?')"
                                            class="btn btn-danger ">
                                            Xóa
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
           
            {{-- {{ $users->links() }} --}}
        </div>
    </div>
@endsection
