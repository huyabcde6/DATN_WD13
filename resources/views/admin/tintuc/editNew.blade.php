@extends('layouts.admin')

@section('title')
Chỉnh Sửa tin tức
@endsection

@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card">

            <div class="card-header">
                <h5 class="card-title mb-0">Sửa Tin Tức</h5>
            </div><!-- end card header -->

            <div class="card-body">
                <form id="newsForm" action="{{ route('admin.new.update', $db->id) }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-lg-4">

                            <div class="mb-3">
                                <label for="title" class="form-label">Tiêu đề</label>
                                <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ $db->title }}">
                                @error('title')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Mô tả ngắn</label>
                                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ $db->description }}</textarea>
                                @error('description')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="avata" class="form-label">Hình ảnh</label>
                                <input type="file" id="avata" name="avata" class="form-control" onchange="showImage(event)">
                                <img src="{{ asset($db->avata) }}" id="img_danhmuc" alt="Hình ảnh sản phẩm" style="width: 150px; display: {{ $db->avata ? 'block' : 'none' }};">
                                @error('avata')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-sm-10 mb-3 d-flex gap-2">
                                <label for="status" class="form-label">Trạng thái: </label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="gridRadios1" value="1" {{ $db->status ? 'checked' : '' }}>
                                    <label class="form-check-label text-success" for="gridRadios1">
                                        Hiển thị
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="gridRadios2" value="0" {{ !$db->status ? 'checked' : '' }}>
                                    <label class="form-check-label text-danger" for="gridRadios2">
                                        Ẩn
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8">
                            <div class="mb-3">
                                <label for="detail" class="form-label">Mô tả chi tiết sản phẩm</label>
                                <div id="quill-editor" style="height: 400px;">{!! $db->detail !!}</div>
                                <textarea name="detail" id="detail_content" class="d-none"></textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    function showImage(event) {
        const img_dm = document.getElementById('img_danhmuc');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                img_dm.src = e.target.result;
                img_dm.style.display = 'block';
            };

            reader.readAsDataURL(file);
        }
    }
</script>

<!-- Quill Editor Js -->
<script src="{{ asset('assets/admin/libs/quill/quill.core.js') }}"></script>
<script src="{{ asset('assets/admin/libs/quill/quill.min.js') }}"></script>

<script>
    // Initialize Quill editor
    const quill = new Quill('#quill-editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                ['code-block'],
                [{
                    'list': 'ordered'
                }, {
                    'list': 'bullet'
                }],
                [{
                    'header': [1, 2, 3, false]
                }],
                ['clean']
            ]
        }
    });

    // Lắng nghe sự kiện submit của form
    document.getElementById('newsForm').addEventListener('submit', function(event) {
        // Lấy nội dung từ Quill editor
        const content = quill.root.innerHTML;

        // Đẩy nội dung vào textarea ẩn
        document.getElementById('detail_content').value = content;

        // Nếu không có nội dung, ngừng submit form và thông báo lỗi
        if (!content.trim()) {
            event.preventDefault();
            alert("Mô tả chi tiết không thể để trống!");
        }
    });
</script>
@endsection