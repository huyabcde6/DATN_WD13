@extends('layouts.admin')

@section('title')
    Danh sách người dùng
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
        <div class="d-flex justify-content-center m-3">
            <h2>Danh sách người dùng</h2>
        </div>
        <div class="d-flex m-3">
            <form action="{{ route('users.index') }}" method="get" class="">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" value="{{ request('search') }}" name="search" id="search"
                        class="form-control" placeholder="Nhập từ khóa cần tìm..">
                    <button type="submit" class="btn btn-secondary">Tìm kiếm</button>
                </div>
            </form>
        </div>
        <div class="col-md-12">
            <table class="table table-striped">
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
                                        class="btn btn-danger ">
                                        Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $users->links() }}
        </div>
    </div>
@endsection
