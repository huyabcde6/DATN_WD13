@extends('layouts.admin')

@section('title')
Danh sách danh mục
@endsection

@section('content')
    <div class="content">
        <!-- Start Content-->
        <div class="container-xxl m-3">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Danh sách danh mục</h4>
                </div>
            </div>

            <!-- General Form -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center" style="justify-content: space-between;">
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('admin.categories.create') }}"
                                    class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1 "
                                    title="Thêm mới">
                                    <i class="mdi mdi-plus text-muted "></i>
                                </a>
                            </div>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Tên danh mục</th>
                                            <th scope="col">Trạng thái</th>
                                            <th scope="col">Tương tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($categories))
                                            @foreach ($categories as $key => $item)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->status == 1 ? 'Hiển thị' : 'Ẩn' }}</td>
                                                    <td>
                                                        <div class="d-flex justify-content-center align-items-center">
                                                            <a href="{{ route('admin.categories.edit', $item->id) }}"
                                                                class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1"
                                                                title="Sửa">
                                                                <i class="fa fa-pencil-alt"></i>
                                                            </a>
                                                            <form onclick="return confirm('Bạn có chắc muốn xóa ?')"
                                                                action="{{ route('admin.categories.delete', $item->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button style="margin-left: 5px" type="submit"
                                                                    class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1"
                                                                    title="Xóa">
                                                                    <i class="fa fa-fw fa-times text-danger"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
@if (session()->has('error'))
<div class="alert alert-danger">
    {{ session()->get('error') }}
</div>
@endif

@if (session()->has('success'))
<div class="alert alert-success">
    {{ session()->get('success') }}
</div>
@endif

<div class="row m-3">
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Danh sách danh mục</h4>
        </div>
        <div class="text-end">
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Danh mục</a></li>
                <li class="breadcrumb-item active">Danh sách danh mục</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="d-flex m-3 justify-content-between align-items-center">
                    <form action="{{ route('admin.categories.index') }}" method="get" id="search-form">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" value="{{ request('search') }}" name="search" id="search"
                                class="form-control" placeholder="Nhập từ khóa cần tìm..">
                            <button type="submit" class="btn btn-dark">Tìm kiếm</button>

                        </div>
                    </form>
                    <a href="{{ route('admin.categories.create') }}"
                        class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1">
                        <i class="mdi mdi-plus text-muted "></i>
                    </a>
                </div>

                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên danh mục</th>
                                    <th>Trạng thái</th>
                                    <th class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->status == 1 ? 'Hiển thị' : 'Ẩn' }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center align-items-center">
                                            <a href="{{ route('admin.categories.edit', $item->id) }}"
                                                class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1 "
                                                data-bs-toggle="tooltip" title="Sửa">
                                                <i class="fa fa-pencil-alt"></i>
                                            </a>
                                            <form action="{{ route('admin.categories.delete', $item->id) }}" method="POST"
                                                class="form-delete">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1"
                                                    data-bs-toggle="tooltip" title="Xóa"
                                                    onclick="return confirm('Bạn có chắc muốn xóa?')">
                                                    <i class="fa fa-fw fa-times text-danger"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4">Không có danh mục nào!</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            <div class="d-flex justify-content-end">
                <div class="mt-3">
                <div class="d-flex justify-content-center mt-3">
                    {{ $categories->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
