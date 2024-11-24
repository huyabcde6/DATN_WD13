@extends('layouts.admin')

@section('title')
    Quản lý người dùng
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
                <h4 class="fs-18 fw-semibold m-0">Danh sách người dùng</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="d-flex m-3">
                        <form action="{{ route('users.index') }}" method="get" class="">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" value="{{ request('search') }}" name="search" id="search"
                                    class="form-control" placeholder="Nhập từ khóa cần tìm..">
                                <button type="submit" class="btn btn-dark">Tìm kiếm</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-striped text-center">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Họ Tên</th>
                                    <th>Email</th>
                                    <th>Mật khẩu</th>
                                    <th>Ngày tạo</th>
                                    <th>Tương tác</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->password }}</td>
                                        <td>{{ $user->created_at }}</td>
                                        <td>
                                            <form action="{{ route('users.destroy', $user) }}" method="post">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" onclick="return confirm('Bạn có chắc muốn xóa?')"
                                                    class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1"
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

                {{ $users->links() }}
            </div>
        </div>

    </div>
@endsection
