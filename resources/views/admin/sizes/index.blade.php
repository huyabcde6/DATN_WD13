@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row m-3">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Danh sách kích thước </h4>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="d-flex m-3">
                            <a href="{{ route('admin.sizes.create') }}"
                                class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1 " title="Thêm mới">
                                <i class="mdi mdi-plus text-muted "></i>
                            </a>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-striped text-center">
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
                                                <a href="{{ route('admin.sizes.edit', $size->size_id) }}"
                                                    class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1 "
                                                    title="Sửa">
                                                    <i class="fa fa-pencil-alt"></i>
                                                </a>
                                                <form action="{{ route('admin.sizes.destroy', $size->size_id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1 "
                                                        title="Xóa">
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
    </div>
@endsection
