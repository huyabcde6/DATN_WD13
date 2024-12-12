@extends('layouts.admin')



@section('css')
    <style>
        #preview-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        #preview-container .position-relative {
            position: relative;
        }

        #preview-container .btn-close {
            background-color: red;
            color: white;
            font-size: 12px;
            width: 20px;
            height: 20px;
            border: none;
            border-radius: 50%;
            cursor: pointer;
        }

        .button-group {
            margin-bottom: 20px;
        }

        .button-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        .options {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            /* Khoảng cách giữa các nút */
        }

        .option-button {
            padding: 10px 15px;
            /* Khoảng cách bên trong */
            border: 1px solid #007bff;
            /* Đường viền */
            border-radius: 4px;
            /* Bo góc */
            background-color: #ffffff;
            /* Màu nền */
            color: #007bff;
            /* Màu chữ */
            font-size: 16px;
            /* Kích thước chữ */
            cursor: pointer;
            /* Con trỏ khi hover */
            transition: background-color 0.3s, color 0.3s;
            /* Hiệu ứng chuyển tiếp */
        }

        .option-button:hover {
            background-color: #007bff;
            /* Màu nền khi hover */
            color: #ffffff;
            /* Màu chữ khi hover */
        }

        .option-button.selected {
            background-color: #007bff;
            /* Màu nền khi được chọn */
            color: #ffffff;
            /* Màu chữ khi được chọn */
            border-color: #0056b3;
            /* Đổi màu viền khi chọn */
        }

        .img-thumbnail {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
            width: 100%;
            height: auto;
        }

        .position-relative .btn-close {
            background-color: red;
            color: white;
            font-size: 12px;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            cursor: pointer;
            z-index: 10;
        }

        .btn:hover i {
            color: gray !important;
            /* Màu xám */
        }

        /* Thay đổi màu nền và đường viền nút khi hover */
        .btn:hover {
            background-color: #f1f1f1;
            /* Màu nền xám nhạt */
            border-color: gray;
            /* Đổi màu đường viền */
        }
    </style>
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
                <h4 class="fs-18 fw-semibold m-0">Thêm mới sản phẩm</h4>
            </div>
            <div class="flex-grow-2 mx-2">
                <a href="{{ route('admin.products.index') }}"
                    class="btn btn-dark btn-alt-secondary  mx-2 fs-18 rounded-2 border p-1 me-2" data-bs-toggle="tooltip"
                    title="Quay lại">
                    <i class="mdi mdi-arrow-left text-muted-white  "></i>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-7">
                                    <div class="mb-3">
                                        <label for="name">Tên sản phẩm</label>
                                        <input type="text" name="name" class="form-control" placeholder="Tên sản phẩm"
                                            id="name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="slug">Slug</label>
                                        <input type="text" name="slug" class="form-control" placeholder="Slug"
                                            id="slug" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="price">Giá sản phẩm</label>
                                        <input type="number" name="price" id="price" class="form-control"
                                            placeholder="Giá sản phẩm" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="discount_price">Giá khuyến mãi</label>
                                        <input type="number" name="discount_price" id="discount_price" class="form-control"
                                            placeholder="Giá khuyến mãi" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="stock_quantity">Số lượng hàng</label>
                                        <input type="number" name="stock_quantity" id="stock_quantity" class="form-control"
                                            placeholder="Số lượng tồn kho" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="short_description">Mô tả ngắn</label>
                                        <textarea name="short_description" id="short_description" class="form-control" placeholder="Mô tả ngắn của sản phẩm"
                                            required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Mô tả chi tiết sản phẩm</label>
                                        <div id="quill-editor" style="height: 400px;"></div>
                                        <textarea name="description" id="description_content" class="d-none">Nhập mô tả chi tiết sản phẩm</textarea>
                                    </div>


                                </div>
                                <div class="col-lg-5">
                                    <div class="mb-3">
                                        <label for="category_id">Danh mục</label>
                                        <select name="categories_id" id="categories_id" class="form-select" required>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-10 d-flex gap-2">
                                        <label class="form-label" for="is_show">Trạng thái</label>
                                        <div class="form-check">
                                            <input class="form-check-input mx-1" type="radio" name="is_show"
                                                id="gridRadios1" value="1" checked>
                                            <label class="form-check-label" for="gridRadios1">Hiển thị</label>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input mx-1" type="radio" name="is_show"
                                                id="gridRadios2" value="0">
                                            <label class="form-check-label" for="gridRadios2">Ẩn</label>
                                        </div>
                                    </div>

                                    <div class="form-switch  mb-2 d-flex gap-2">
                                        <label class="form-label start" for="is_type">Tùy chỉnh</label>
                                        <div class="form-check">
                                            <input class="form-check-input mx-1" type="checkbox" name="is_new"
                                                id="is_new" checked>
                                            <label class="form-check-label" for="is_new">New</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input mx-1" type="checkbox" name="is_hot"
                                                id="is_hot" checked>
                                            <label class="form-check-label" for="is_hot">Hot</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="avata">Hình ảnh sản phẩm</label>
                                        <input class="form-control" type="file" name="avata" id="avata"
                                            required>
                                        <div id="avata-preview-container" class="mt-2"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="images">Hình ảnh phụ</label>
                                        <input class="form-control" type="file" name="images[]" id="images"
                                            multiple>
                                        <div id="preview-container" class="d-flex flex-wrap mt-2"></div>
                                    </div>

                                    <div class="button-group">
                                        <label for="sizes">Chọn kích thước</label>
                                        <div class="options" id="sizes">
                                            @foreach ($sizes as $size)
                                                <button type="button" class="option-button"
                                                    data-value="{{ $size->size_id }}">{{ $size->value }}</button>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="button-group">
                                        <label for="colors">Chọn màu sắc</label>
                                        <div class="options" id="colors">
                                            @foreach ($colors as $color)
                                                <button type="button" class="option-button"
                                                    data-value="{{ $color->color_id }}">{{ $color->value }}</button>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button type="button" id="generate-variants" class="btn btn-primary">Tạo biến
                                            thể</button>
                                    </div>
                                </div>

                                <div id="variants-container"></div>
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary">Lưu sản phẩm</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/admin/libs/quill/quill.core.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/quill/quill.min.js') }}"></script>

    <script>
        document.querySelectorAll('#sizes .option-button').forEach(button => {
            button.addEventListener('click', function() {
                this.classList.toggle('selected');
            });
        });

        document.querySelectorAll('#colors .option-button').forEach(button => {
            button.addEventListener('click', function() {
                this.classList.toggle('selected');
            });
        });

        document.getElementById('generate-variants').addEventListener('click', function() {
            const selectedSizeButtons = document.querySelectorAll('#sizes .option-button.selected');
            const selectedColorButtons = document.querySelectorAll('#colors .option-button.selected');

            if (selectedSizeButtons.length === 0 || selectedColorButtons.length === 0) {
                alert('Vui lòng chọn ít nhất một kích thước và một màu sắc.');
                return;
            }

            const container = document.getElementById('variants-container');
            container.innerHTML = ''; // Xóa các biến thể cũ

            selectedSizeButtons.forEach(sizeButton => {
                const size = {
                    id: sizeButton.getAttribute('data-value'),
                    value: sizeButton.textContent
                };

                selectedColorButtons.forEach(colorButton => {
                    const color = {
                        id: colorButton.getAttribute('data-value'),
                        value: colorButton.textContent
                    };

                    const variantForm = document.createElement('div');
                    variantForm.innerHTML = `
            <div class="card border">
                <h4 class="mt-3 mx-3">Biến thể (Kích thước: ${size.value}, Màu: ${color.value})</h4>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-lg-1 mx-3">
                            <div id="variant-preview-container_${size.id}_${color.id}" class="mt-2"></div>
                        </div>
                        <div class="col-lg-5 mx-2">
                            <div class="mb-2">
                                <label for="variant_image_${size.id}_${color.id}">Hình ảnh</label>
                                <input type="file" name="variant_image[${size.id}][${color.id}]" id="variant_image_${size.id}_${color.id}" class="form-control" accept="image/*" required>
                            </div>
                            <div class="mb-2">
                                <label for="variant_price_${size.id}_${color.id}">Giá</label>
                                <input type="number" name="variant_price[${size.id}][${color.id}]" id="variant_price_${size.id}_${color.id}" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-5 ">
                            <div class="mb-2">
                                <label for="variant_quantity_${size.id}_${color.id}">Số lượng</label>
                                <input type="number" name="variant_quantity[${size.id}][${color.id}]" id="variant_quantity_${size.id}_${color.id}" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label for="variant_discount_price_${size.id}_${color.id}">Giá khuyến mãi</label>
                                <input type="number" name="variant_discount_price[${size.id}][${color.id}]" id="variant_discount_price_${size.id}_${color.id}" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                    <hr>
            `;
                    container.appendChild(variantForm);
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            var quill = new Quill("#quill-editor", {
                theme: "snow",
            })
            var old_content = `{!! old('description') !!}`;
            quill.root.innerHTML = old_content;
            quill.on('text-change', function() {
                var html = quill.root.innerHTML;
                document.getElementById('description_content').value = html;
            })
        })
    </script>
    <script>
        document.getElementById('name').addEventListener('keyup', function() {
            const name = this.value;
            const slug = removeVietnameseTones(name)
                .toLowerCase()
                .trim()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');

            document.getElementById('slug').value = slug;
        });

        function removeVietnameseTones(str) {
            return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "")
                .replace(/đ/g, "d").replace(/Đ/g, "D");
        }
    </script>
    <script>
        document.getElementById('images').addEventListener('change', function(event) {
            const previewContainer = document.getElementById('preview-container');
            previewContainer.innerHTML = ''; // Xóa nội dung trước đó

            const files = event.target.files;
            Array.from(files).forEach((file, index) => {
                const fileReader = new FileReader();
                fileReader.onload = function(e) {
                    const imageWrapper = document.createElement('div');
                    imageWrapper.classList.add('position-relative', 'me-2', 'mb-2');
                    imageWrapper.style.width = '120px';
                    imageWrapper.style.height = '120px';

                    imageWrapper.innerHTML = `
                <img src="${e.target.result}" alt="Preview" class="img-thumbnail" style="width: 100%; height: 100%; object-fit: cover;">
                <button type="button" class="btn-close position-absolute top-0 start-100 translate-middle" aria-label="Close" data-index="${index}"></button>
            `;

                    previewContainer.appendChild(imageWrapper);
                };

                fileReader.readAsDataURL(file);
            });

            // Xử lý nút xóa
            previewContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-close')) {
                    const index = e.target.getAttribute('data-index');
                    removeImage(index, event.target);
                }
            });
        });

        function removeImage(index, inputElement) {
            const dt = new DataTransfer();
            const files = inputElement.files;

            Array.from(files).forEach((file, i) => {
                if (i !== parseInt(index)) {
                    dt.items.add(file); // Giữ lại các file không bị xóa
                }
            });

            inputElement.files = dt.files; // Cập nhật danh sách file
            document.getElementById('preview-container').children[index].remove(); // Xóa phần tử hình ảnh khỏi preview
        }
    </script>
    <script>
        function handleImagePreview(inputId, previewContainerId) {
            const inputElement = document.getElementById(inputId);
            const previewContainer = document.getElementById(previewContainerId);

            inputElement.addEventListener('change', function() {
                previewContainer.innerHTML = ''; // Xóa hình ảnh hiện tại nếu có

                const files = inputElement.files;
                if (files && files.length > 0) {
                    const fileReader = new FileReader();

                    fileReader.onload = function(e) {
                        const imageWrapper = document.createElement('div');
                        imageWrapper.classList.add('position-relative');
                        imageWrapper.style.width = '120px';
                        imageWrapper.style.height = '120px';

                        imageWrapper.innerHTML = `
                    <img src="${e.target.result}" alt="Preview" class="img-thumbnail" style="width: 100%; height: 100%; object-fit: cover;">
                    <button type="button" class="btn-close position-absolute top-0 start-100 translate-middle" aria-label="Close"></button>
                `;

                        previewContainer.appendChild(imageWrapper);

                        // Xử lý nút xóa
                        imageWrapper.querySelector('.btn-close').addEventListener('click', function() {
                            inputElement.value = ''; // Xóa file khỏi input
                            previewContainer.innerHTML = ''; // Xóa preview
                        });
                    };

                    fileReader.readAsDataURL(files[0]); // Chỉ hiển thị file đầu tiên
                }
            });
        }

        // Khởi tạo preview cho các input
        handleImagePreview('avata', 'avata-preview-container');
        handleImagePreview(`variant_image_${size.id}_${color.id}`, `variant-preview-container_${size.id}_${color.id}`);
    </script>
    <script>
        document.getElementById('variants-container').addEventListener('change', function(event) {
            if (event.target.type === 'file' && event.target.name.startsWith('variant_image')) {
                const inputElement = event.target;
                const previewContainerId = inputElement.id.replace('variant_image', 'variant-preview-container');
                const previewContainer = document.getElementById(previewContainerId);

                previewContainer.innerHTML = ''; // Xóa preview cũ nếu có

                const files = inputElement.files;
                if (files && files.length > 0) {
                    const fileReader = new FileReader();

                    fileReader.onload = function(e) {
                        const imageWrapper = document.createElement('div');
                        imageWrapper.classList.add('position-relative');
                        imageWrapper.style.width = '120px';
                        imageWrapper.style.height = '120px';

                        imageWrapper.innerHTML = `
                    <img src="${e.target.result}" alt="Preview" class="img-thumbnail" style="width: 100%; height: 100%; object-fit: cover;">
                    <button type="button" class="btn-close position-absolute top-0 start-100 translate-middle" aria-label="Close"></button>
                `;

                        previewContainer.appendChild(imageWrapper);

                        // Xử lý nút xóa
                        imageWrapper.querySelector('.btn-close').addEventListener('click', function() {
                            inputElement.value = ''; // Xóa file khỏi input
                            previewContainer.innerHTML = ''; // Xóa preview
                        });
                    };

                    fileReader.readAsDataURL(files[0]); // Chỉ hiển thị file đầu tiên
                }
            }
        });
    </script>
@endsection
