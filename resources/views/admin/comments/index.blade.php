@extends('layouts.admin')

@section('title')
Quản lý bình luận
@endsection
@section('css')
<style>
.description-container {
    max-width: 300px;
    /* Đảm bảo chiều rộng tối đa */
    word-wrap: break-word;
    /* Tự động xuống dòng khi vượt quá chiều rộng */
}
</style>
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
        <div class="ml-auto">
            <form action="{{ route('admin.comments.index') }}" method="GET">
                <div class="d-flex">
                    <select name="search_by" class="form-control">
                        <option value="description"
                            {{ request()->get('search_by') == 'description' ? 'selected' : '' }}>Nội dung</option>
                        <option value="user_name" {{ request()->get('search_by') == 'user_name' ? 'selected' : '' }}>
                            Người bình luận</option>
                        <option value="product_name"
                            {{ request()->get('search_by') == 'product_name' ? 'selected' : '' }}>Sản phẩm</option>
                    </select>
                    <input type="text" name="search" class="form-control" placeholder="Tìm kiếm"
                        value="{{ request()->get('search') }}">
                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12">
                        <table class="table table-striped text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Họ Tên</th>
                                    <th>Sản phẩm</th>
                                    <th>Nội dung</th>
                                    <th>Hình ảnh</th>
                                    <th>Ngày tạo</th>
                                    <th>Trạng thái</th>
                                    <th>Tương tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($comments->isEmpty())
                                <tr>
                                    <td colspan="8" class="text-center">Không có bình luận nào</td>
                                </tr>
                                @else
                                @foreach ($comments as $comment)
                                <tr>
                                    <td>{{ $comment->id }}</td>
                                    <td>{{ $comment->user->name }}</td>
                                    <td>{{ $comment->product->name ?? 'Không có sản phẩm' }}</td>
                                    <td>
                                        <div class="description-container" data-id="{{ $comment->id }}">
                                            <span class="short-description">
                                                {{ \Illuminate\Support\Str::limit($comment->description, 150) }}
                                            </span>
                                            <span class="full-description d-none">
                                                {{ $comment->description }}
                                            </span>
                                            @if(strlen($comment->description) > 150)
                                            <button class="btn btn-link toggle-description" data-id="{{ $comment->id }}"
                                                style="padding: 0;">
                                                Hiển thị thêm
                                            </button>
                                            @endif
                                        </div>
                                    </td>

                                    <td>
                                        @if($comment->images && count($comment->images) > 0)
                                        @foreach($comment->image_urls as $url)
                                        <img src="{{ $url }}" alt="Hình ảnh bình luận"
                                            style="width: 50px; height: 50px; margin: 5px; object-fit: cover;">
                                        @endforeach
                                        @else
                                        Không có hình ảnh
                                        @endif
                                    </td>

                                    <td>{{ $comment->created_at->format('d/m/Y') }}</td>

                                    <td>
                                        <span class="{{ $comment->is_hidden ? 'text-danger' : 'text-success' }}">
                                            {{ $comment->is_hidden ? 'Đã ẩn' : 'Hiển thị' }}
                                        </span>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.comments.hide', $comment->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="btn {{ $comment->is_hidden ? 'btn-success' : 'btn-danger' }}">
                                                {{ $comment->is_hidden ? 'Hiện' : 'Ẩn' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
            <div class="m-2">
                {{ $comments->links() }}
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.toggle-description').forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.getAttribute('data-id');
            const container = document.querySelector(
                `.description-container[data-id="${commentId}"]`);

            if (container) {
                const shortDescription = container.querySelector('.short-description');
                const fullDescription = container.querySelector('.full-description');

                if (shortDescription && fullDescription) {
                    if (shortDescription.classList.contains('d-none')) {
                        shortDescription.classList.remove('d-none');
                        fullDescription.classList.add('d-none');
                        this.textContent = 'Hiển thị thêm';
                    } else {
                        shortDescription.classList.add('d-none');
                        fullDescription.classList.remove('d-none');
                        this.textContent = 'Ẩn bớt';
                    }
                }
            }
        });
    });
});
</script>
@endsection