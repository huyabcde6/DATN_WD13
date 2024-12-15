@extends('layouts.admin')

@section('title')
    Quản lý bình luận
@endsection

@section('content')
@if (session()->has('error'))
        <div class="alert alert-danger m-3">
            {{ session()->get('error') }}
        </div>
    @endif

    @if (session()->has('success'))
        <div class="alert alert-success m-3">
            {{ session()->get('success') }}
        </div>
    @endif

    <div class="row m-3">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Danh sách bình luận</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="col-md-12">
                        <table class="table table-striped text-center">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Họ Tên</th>
                                    <th>Nội dung</th>
                                    <th>Hình ảnh</th>
                                    <th>Ngày tạo</th>
                                    <th>Trạng thái</th>
                                    <th>Tương tác</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($comments as $comment)
                                    <tr>
                                        <td>{{ $comment->id }}</td>
                                        <td>{{ $comment->user->name }}</td>
                                        <td>{{ $comment->description }}</td>
                                        <td>
                                            <img src="" alt="">
                                        </td>
                                        <td>{{ $comment->created_at }}</td>
                                        <td>
                                            {{ $comment->is_hidden ? 'Đã ẩn' : 'Hiển thị' }}
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.comments.hide', $comment->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn {{ $comment->is_hidden ? 'btn-success' : 'btn-danger' }}">
                                                    {{ $comment->is_hidden ? 'Hiện' : 'Ẩn' }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="m-2">
                    {{ $comments->links() }}
                </div>
            </div>
        </div>

    </div>
@endsection