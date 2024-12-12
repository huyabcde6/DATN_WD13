@extends('layouts.admin')

@section('title')
Thêm mới tin tức
@endsection

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">

            <div class="card-header">
                <h5 class="card-title mb-0">Thêm Tin Tức</h5>
            </div><!-- end card header -->

            <div class="card-body">
                <form id="newsForm" action="{{ route('admin.new.postnew') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="title" class="form-label">Tiêu đề</label>
                                <input type="text" id="title" name="title"
                                    class="form-control @error('title') is-invalid @enderror"
                                    value="{{ old('title') }}">
                                @error('title')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Mô tả ngắn</label>
                                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                    rows="3">{{ old('description') }}</textarea>
                                @error('description')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="avata" class="form-label">Hình ảnh</label>
                                <input type="file" id="avata" name="avata" class="form-control"
                                    onchange="showImage(event)">
                                <img src="" id="img_danhmuc" alt="Hình ảnh sản phẩm"
                                    style="width: 150px; display: none;">
                                @error('avata')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-sm-10 mb-3 d-flex gap-2">
                                <label for="status" class="form-label">Trạng thái: </label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="gridRadios1"
                                        value="1" checked>
                                    <label class="form-check-label text-success" for="gridRadios1">
                                        Hiển thị
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="gridRadios2"
                                        value="0">
                                    <label class="form-check-label text-danger" for="gridRadios2">
                                        Ẩn
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8">
                            <div class="mb-3">
                                <label for="detail" class="form-label">Mô tả chi tiết</label>
                                <div id="quill-editor" style="height: 400px;"></div>
                                <!-- This textarea will hold the content of the Quill editor -->
                                <textarea name="detail" id="detail_content" class="d-none"></textarea>
                            </div>
                        </div>
                        @error('detail')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">Thêm mới</button>
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

        // Truy cập file được chọn an toàn hơn
        const file = event.target.files[0];

        if (file) { // Kiểm tra nếu có file được chọn
            const reader = new FileReader();

            reader.onload = function(e) {
                img_dm.src = e.target.result;
                img_dm.style.display = 'block';
            };

            reader.readAsDataURL(file);
        } else {
            // Xử lý trường hợp không chọn file (tùy chọn)
            console.error('Vui lòng chọn một hình ảnh.');
        }
    }
</script>

<!-- Quill Editor Js -->
<script src="{{ asset('assets/admin/libs/quill/quill.core.js') }}"></script>
<script src="{{ asset('assets/admin/libs/quill/quill.min.js') }}"></script>

<!-- chi tiết -->
<script>
    // Initialize the Quill editor
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

        // Kiểm tra và hiển thị dữ liệu (tuỳ chọn)
        if (!content.trim()) {
            event.preventDefault(); // Nếu không có nội dung, ngừng gửi form
            alert("Mô tả chi tiết không thể để trống!");
        }
    });
</script>
@endsection