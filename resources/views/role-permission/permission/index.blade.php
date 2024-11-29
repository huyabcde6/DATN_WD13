@extends('layouts.admin')

@section('title')
Quản lý Vai trò & Quyền
@endsection

@section('content')
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
                <h4 class="fs-18 fw-semibold m-0">Danh sách Quyền </h4>
            </div>
            <a href="{{ url('permission/create') }}" class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1">
                <i class="mdi mdi-plus text-muted"></i> Thêm Quyền
            </a>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="d-flex m-3">
                        <form action="{{ url('permission') }}" method="get" id="search-form">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" value="{{ request('search') }}" name="search" id="search"
                                    class="form-control" placeholder="Nhập từ khóa cần tìm...">
                                <button type="submit" class="btn btn-secondary">Tìm kiếm</button>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-12">
                        <table class="table table-striped text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên quyền</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permission as $perm)
                                    <tr>
                                        <td>{{ $perm->id }}</td>
                                        <td>{{ $perm->name }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center align-items-center">
                                                <a href="{{ url('permission/' . $perm->id . '/edit') }}"
                                                    class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1"
                                                    data-bs-toggle="tooltip" title="Chỉnh sửa">
                                                    <i class="fa fa-pencil-alt"></i>
                                                </a>
                                                <form action="{{ url('permission/' . $perm->id . '/delete') }}"
                                                    method="POST" class="form-delete d-inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1"
                                                        data-bs-toggle="tooltip" title="Xóa"
                                                        onclick="return confirm('Bạn có chắc chắn muốn xóa quyền này?');">
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
            </div>
            {{ $permission->links('pagination::bootstrap-5') }}
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const deleteBtn = this.querySelector('.delete-btn');
                    Swal.fire({
                        title: 'Bạn có chắc chắn muốn xóa quyền này?',
                        text: "Hành động này không thể hoàn tác!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Có, xóa!',
                        cancelButtonText: 'Không, hủy bỏ!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                });
            });

            // Xử lý tìm kiếm với debounce
            let timeout = null;
            document.getElementById('search').addEventListener('input', function() {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    document.getElementById('search-form').submit();
                }, 1000);
            });
        </script>
    @endpush
@endsection
