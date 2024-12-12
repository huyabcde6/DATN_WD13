@extends('layouts.admin')

@section('title')
Danh sách Tin Tức
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
            <h4 class="fs-18 fw-semibold m-0">Danh sách tin tức</h4>
        </div>
        <div class="ms-auto">
            <a href="{{ route('admin.new.store') }}" class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1" title="Thêm mới">
                <i class="mdi mdi-plus text-muted"></i> Thêm mới
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>Tiêu đề</th>
                                <th>Ảnh bìa</th>
                                <th>Mô tả ngắn</th>
                                <th>View</th>
                                <th>Ngày Đăng</th>
                                <th>Trạng thái</th>
                                <th>Tương tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($db as $tiem)
                            <tr>
                                <td>{{ $tiem->title }}</td>
                                <td><img src="{{ Storage::url($tiem->avata) }}" alt="Ảnh bìa" width="200px"></td>
                                <td>{{ $tiem->description }}</td>
                                <td>{{ $tiem->view }}</td>
                                <td>{{ $tiem->new_date }}</td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" {{ $tiem->status ? 'checked' : '' }} disabled>
                                        <span class="slider"></span>
                                    </label>
                                </td>
                                <td class="d-flex justify-content-center align-items-center">
                                    <a href="{{ route('admin.new.show', $tiem->id) }}" class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1" title="Sửa">
                                        <i class="fa fa-pencil-alt"></i>
                                    </a>
                                    <form action="{{ route('admin.new.destroy', $tiem->id) }}" method="POST" class="form-delete" onsubmit="return confirm('Bạn có chắc muốn xóa không?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1" title="Xóa">
                                            <i class="fa fa-fw fa-times text-danger"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection