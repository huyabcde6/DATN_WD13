@extends('layouts.admin')

@section('title')
    Vai trò & quyền
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection

@section('content')
    @if (session()->has('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="row m-3">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Danh sách vai trò & quyền</h4>
            </div>
            <a href="{{ url('roles/create') }}" class="btn btn-sm btn-alt-secondary fs-18 rounded-2 border p-1 me-1"
                data-bs-toggle="tooltip" title="Thêm vai trò">
                <i class="mdi mdi-plus text-muted"></i>
            </a>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên vai trò</th>
                                    <th class="text-center">Tương tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $role->id }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center align-items-center">
                                                <a href="{{ url('roles/' . $role->id . '/give-permission') }}"
                                                    class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1"
                                                    data-bs-toggle="tooltip" title="Cấp / sửa quyền">
                                                    <i class="fa fa-key text-warning"></i>
                                                </a>
                                                <a href="{{ url('roles/' . $role->id . '/edit') }}"
                                                    class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1"
                                                    data-bs-toggle="tooltip" title="Sửa">
                                                    <i class="fa fa-pencil-alt"></i>
                                                </a>
                                                <form action="{{ url('roles/' . $role->id . '/delete') }}" method="POST"
                                                    class="form-delete">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1"
                                                        data-bs-toggle="tooltip" title="Xóa"
                                                        onclick="return confirm('Bạn có chắc chắn muốn xóa vai trò này?');">
                                                        <i class="fa fa-fw fa-times text-danger"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{ $roles->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.table').DataTable();
        });
    </script>
@endsection
