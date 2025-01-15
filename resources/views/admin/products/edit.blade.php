@extends('layouts.admin')
@section('title')
Cập nhật sản phẩm
@endsection
@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.css" rel="stylesheet">
<!-- Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="{{ asset('admin/js/plugins/simplemde/simplemde.min.css') }}">
<!-- image css -->
{{-- <link rel="stylesheet" href="{{ asset('admin/css/products/image-form.css') }}"> --}}
<link rel="stylesheet" href="{{ asset('admin/css/products/form-edit.css') }}">

<style>
.custom-file2 {
    position: absolute;
    /* Hoặc relative, tùy thuộc vào bố cục */
    width: 100px;
    height: 70px;
    /* Tự động chiếm toàn bộ kích thước cha */
    opacity: 0;
    /* Ẩn hoàn toàn input file */
    cursor: pointer;
    /* Thay đổi con trỏ khi di chuột */
    margin: 0;
    /* Xóa khoảng cách không cần thiết */
}

.custom-file2 input[type="file"] {
    width: 100px !important;
    height: 70px !important;
}

.char-counter {
    font-size: 0.9em;
    color: #6c757d;
    /* Màu ghi nhạt */
    margin-top: 0.2rem;
    text-align: right;
}

.char-counter.error {
    color: red;
    /* Đổi sang màu đỏ khi vượt giới hạn */
}

/* CSS cho mũi tên và hover cho nút chỉnh sửa hàng loạt */
.input-hover {
    position: relative;
    border: 1px solid #ced4da;
    transition: border-color 0.3s ease;
}

/* Hover vào nút thì viền chuyển sang màu primary */
.input-hover:hover {
    border-color: #007bff;
    /* Màu primary */
    cursor: pointer;
}

/* Thêm mũi tên (icon) bên cạnh nút */


/* Khi dropdown được mở (khi nhấn vào nút) thì mũi tên sẽ xoay lên */

/* Style cho phần dropdown nội dung */
.dropdown-content {
    display: none;
    /* Ẩn mặc định */
    width: 100%;
    padding: 15px;
    background-color: #f8f9fa;
    border: 1px solid #ced4da;
    border-radius: 5px;
    margin-top: 10px;
}

/* Hiển thị khi nút được kích hoạt */
.dropdown-content.show {
    display: block;
}

/* CSS để loại bỏ viền chỉ cho nút delete-variant */
button.delete-variant {
    border: none;
    /* Xóa viền */
    background: none;
    /* Loại bỏ nền nếu cần */
    padding: 0;
    /* Loại bỏ padding nếu cần */
    cursor: pointer;
    /* Thêm biểu tượng con trỏ nếu muốn */
}

button.delete-variant:focus {
    outline: none;
    /* Xóa viền khi focus vào nút */
}

button.button-css {
    color: #007bff
}

button.button-css:hover {
    background-color: #eef0f7;
    color: #007bff
}

/* Làm đẹp input chọn ảnh */
.custom-file {
    position: relative;
    width: 100%;
    height: 45px;
    margin-bottom: 20px;
}

.custom-file input[type="file"] {
    position: absolute;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}

.custom-file2 {
    position: absolute;
    /* Hoặc relative, tùy thuộc vào bố cục */
    width: 50px;
    height: 70px;
    /* Tự động chiếm toàn bộ kích thước cha */
    opacity: 0;
    /* Ẩn hoàn toàn input file */
    cursor: pointer;
    /* Thay đổi con trỏ khi di chuột */
    margin: 0;
    /* Xóa khoảng cách không cần thiết */
}

.custom-file2 input[type="file"] {
    width: 50px !important;
    height: 70px !important;
}

.custom-file-label {
    display: block;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #f8f9fa;
    border: 1px solid #ced4da;
    border-radius: 5px;
    padding: 10px;
    cursor: pointer;
    text-align: center;
}

.custom-file-label::after {
    content: "Chọn ảnh";
    display: block;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 16px;
    color: #6c757d;
}

.image-preview img {
    max-width: 100px;
    max-height: 100px;
    margin-right: 10px;
    margin-bottom: 10px;
}

.image-preview .img-wrapper {
    display: inline-block;
    position: relative;
    margin-right: 10px;
    margin-bottom: 10px;
}

.image-preview .delete-btn {
    position: absolute;
    top: 0;
    right: 0;
    background-color: red;
    color: white;
    border: none;
    padding: 5px;
    cursor: pointer;
    font-size: 12px;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    text-align: center;
    line-height: 10px;
}

.invalid-feedback {
    display: block !important;
    color: red;
    font-size: 14px;
    margin-top: 5px;
}

.custom-file-btn {
    display: inline-block;
    padding: 6px 12px;
    font-size: 14px;
    font-weight: 400;
    color: #fff;
    background-color: #007bff;
    border: 1px solid #007bff;
    border-radius: 4px;
    text-align: center;
}

.custom-file-btn:hover {
    background-color: #0056b3;
    border-color: #0056b3;
    color: #fff;
}

.char-counter {
    font-size: 0.9em;
    color: #6c757d;
    /* Màu ghi nhạt */
    margin-top: 0.2rem;
    text-align: right;
}

.char-counter.error {
    color: red;
    /* Đổi sang màu đỏ khi vượt giới hạn */
}

.status-group {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
}

.status-group .form-check {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
}

.status-group .form-check-label {
    margin-left: 0.5rem;
}
</style>
@endsection
@section('content')
<!-- Hero -->
<div class="row m-3">
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Cập nhật sản phẩm</h1>
                <nav class="flex-shrink-0 my-2 my-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.products.index') }}" style="color: inherit;">Sản phẩm</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Cập nhật sản phẩm</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->
    <div class="content fs-sm">
        {{-- Form bắt đầu --}}
        <form id="myForm" action="{{ route('admin.products.update', $product->id) }}" method="post"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="block block-rounded">
                <div class="block-content">
                    {{-- @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
                @endif --}}
                <div class="card">
                    <div class="block block-rounded">
                        <div class="block-content">
                            <div class="row m-3">
                                <!-- Cột bên trái -->
                                <div class="col-7">
                                    <!-- Tên sản phẩm -->
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Tên sản phẩm<span
                                                class="text-danger">*</span>:</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name" id="name" value="{{ old('name', $product->name) }}"
                                            placeholder="Nhập tên sản phẩm">
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- SKU -->
                                    <div class="mb-3">
                                        <label for="slug">Slug</label>
                                        <input type="text" name="slug" class="form-control" placeholder="Slug" id="slug"
                                            value="{{ $product->slug }}" readonly>
                                    </div>

                                    <!-- Giá sản phẩm -->
                                    <div class="row">
                                        <!-- Giá gốc -->
                                        <div class="col-6 mb-3">
                                            <label for="price" class="form-label">Giá gốc<span
                                                    class="text-danger">*</span>:</label>
                                            <input type="number"
                                                class="form-control @error('price') is-invalid @enderror" name="price"
                                                id="price" value="{{ old('price', $product->price) }}"
                                                placeholder="Nhập giá sản phẩm">
                                            @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Giá khuyến mãi -->
                                        <div class="col-6 mb-3">
                                            <label for="discount_price" class="form-label">Giá khuyến mãi:</label>
                                            <input type="number"
                                                class="form-control @error('discount_price') is-invalid @enderror"
                                                name="discount_price" id="discount_price"
                                                value="{{ old('discount_price', $product->discount_price) }}"
                                                placeholder="Nhập giá khuyến mãi">
                                            @error('discount_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Mô tả ngắn -->
                                    <div class="mb-4">
                                        <label for="short_description" class="form-label">Mô tả ngắn:</label>
                                        <textarea class="form-control @error('short_description') is-invalid @enderror"
                                            id="short_description" name="short_description" rows="5" maxlength="200"
                                            placeholder="Nhập tối đa 200 ký tự...">{{ old('short_description', $product->short_description) }}</textarea>
                                        <small id="char-count" class="form-text text-muted">Còn lại 200 ký tự</small>
                                        @error('short_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Nội dung chi tiết -->
                                    <div class="mb-3">
                                        <label for="editor" class="form-label">Nội dung:</label>
                                        <textarea name="description" id="editor"
                                            class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
                                        @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Cột bên phải: Thuộc tính sản phẩm và ảnh -->
                                <div class="col-5">
                                    <!-- Danh mục -->
                                    <div class="row form-group mb-3">
                                        <label class="form-label" for="catalogue-select">Danh mục<span
                                                class="text-danger">*</span>:</label>
                                        <select name="categories_id" id="categories_id" class="form-select" required>
                                            @foreach($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $product->categories_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('catalogue-select')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Các thuộc tính sản phẩm -->
                                    <div class="mb-4">
                                        <label class="form-label">Trạng thái sản phẩm</label>
                                        <div class="row">
                                            <!-- Dòng 1 -->

                                            <div class="d-flex justify-content-between">
                                                <!-- Is active -->
                                                <div class="form-check">
                                                    <input class="form-check-input mx-1" type="radio" name="is_show"
                                                        id="gridRadios1" value="1"
                                                        {{ old('is_show', $product->iS_show) == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="gridRadios1">Hiển thị</label>
                                                </div>
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input mx-1" type="radio" name="is_show"
                                                        id="gridRadios2" value="0"
                                                        {{ old('is_show', $product->iS_show) == 0 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="gridRadios2">Ẩn</label>
                                                </div>

                                                <!-- Is new -->

                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <!-- Dòng 2 -->
                                            <div class="d-flex justify-content-between">
                                                <!-- Is hot deal -->
                                                <div class="form-check form-switch form-check-inline col-md">
                                                <input class="form-check-input mx-1" type="checkbox" name="is_hot" id="is_hot"
                                                value="1" {{ old('iS_hot', $product->iS_hot) == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_hot">Hot</label>
                                                </div>

                                                <!-- Show home -->
                                                <div class="form-check form-switch form-check-inline col-md">
                                                <input class="form-check-input mx-1" type="checkbox" name="is_new" id="is_new"
                                                 value="1" {{ old('iS_new', $product->iS_new) == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_new">New</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Nút tải ảnh chính -->
                                    <div class="form-group image-preview" id="main-image-preview">
                                        <label class="form-label">Tải lên ảnh chính:</label>
                                        <div class="custom-file">
                                            <input type="file" name="avata" class="form-control-file"
                                                id="main-image-input">
                                            <label class="custom-file-label" for="main-image-input"></label>
                                        </div>
                                        <div id="main-image-container"></div> <!-- Hiển thị ảnh chính -->
                                    </div>

                                    <!-- Tải lên ảnh phụ -->
                                    <div class="form-group image-preview" id="sub-images-preview">
                                        <label class="form-label">Tải lên ảnh phụ:</label>
                                        <div class="custom-file">
                                            <input type="file" name="images[]" class="form-control-file" multiple
                                                id="sub-images-input">
                                            <label class="custom-file-label" for="sub-images-input"></label>
                                            <input type="hidden" id="deleted-images" name="deleted_images" value="[]">
                                        </div>
                                        <div id="sub-images-container">

                                        </div> <!-- Hiển thị các ảnh phụ -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block block-rounded">
                        <div class="block-content">
                            <div class="row m-3">
                                <div class="col-12">
                                    <h5>Thuộc tính sản phẩm<span class="text-danger">*</span></h5>
                                    <div id="attributes-section" class="mb-3"></div>

                                    <button type="button" id="add-attribute-btn"
                                        class="btn btn-sm btn-alt button-css mb-3"><i class="fa fa-plus"></i>Thêm thuộc
                                        tính</button>

                                    <!-- Biến thể -->


                                    <div class="d-flex justify-content-between align-items-center mb-3 mt-5">
                                        <h5 class="d-inline">Danh sách biến thể</h5>
                                        <div></div> <!-- Tạo khoảng trống để căn chỉnh -->

                                        <div class=" fake-dropdown">
                                            <button class="btn btn-sm btn-alt-secondary toggle-dropdown p-2"
                                                type="button">
                                                Chỉnh sửa hàng loạt <i class="fas fa-chevron-down"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- Nội dung sổ xuống, sẽ được hiển thị khi nhấn vào nút -->
                                    <div class=" dropdown-content" style="display: none;">
                                        <div class="row">
                                            <div class="col-md-3">
                                                {{-- <label for="apply_to">Áp dụng cho</label> --}}
                                                <select id="apply_to" class="form-select">
                                                    <option value="all">Tất cả</option>
                                                    <option value="new">Biến thể mới</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="number" id="bulk_price" class="form-control input-hover"
                                                    placeholder="Giá bán">
                                                <span class="error-message text-danger" id="error-bulk-price"></span>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="number" id="bulk_stock" class="form-control input-hover"
                                                    placeholder="Số lượng">
                                                <span class="error-message text-danger" id="error-bulk-stock"></span>
                                            </div>
                                            <div class="col-md-3 d-flex align-items-end">
                                                <button type="button" id="apply-bulk-edit"
                                                    class="btn btn-sm btn-alt-secondary w-100 p-2">Áp
                                                    dụng</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-3 mb-3">
                                        <button type="button" id="generate-variants-btn"
                                            class="btn btn-sm btn-alt button-css mb-3"><i class="fa fa-plus"></i>Tạo
                                            biến
                                            thể</button>
                                    </div>
                                    @php
                                        // Tìm số thuộc tính lớn nhất trong tất cả các biến thể
                                        $maxAttributesCount = $product->variants->max(function ($variant) {
                                            return $variant->attributes->count();
                                        });
                                    @endphp
                                    <!-- Danh sách biến thể dưới dạng bảng -->
                                    <table class="table table-hover variant-table">
                                        <thead>
                                            <tr id="variant-header">
                                            @for ($i = 1; $i <= $maxAttributesCount; $i++)
                                                <th>Thuộc tính {{ $i }}</th>
                                            @endfor
                                                <th>Giá bán<span class="text-danger">*</span></th>
                                                <th>Số lượng<span class="text-danger">*</span></th>
                                                <th>SKU</th>
                                                <th>Ảnh<span class="text-danger">*</span></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="variant-container">
                                            <!-- Hiển thị các biến thể đã có trong DB -->
                                            <div id="deleted-variants-container"></div>
                                            @foreach ($product->variants as $variant)
                                            <tr class="variant variant-existing" data-variant-id="{{ $variant->id }}">
                                                <input type="hidden" name="variant_ids[]" value="{{ $variant->id }}">

                                                @foreach ($variant->attributes as $attribute)
                                                <!-- Truy xuất giá trị thuộc tính từ attribute_value -->
                                                @php
                                                $attribute_value = $attribute->attributeValue;
                                               
                                                @endphp
                                                

                                                <td >
                                                    <span data-attribute-id="{{ $attribute_value->attribute_id }}" data-value-id="{{ $attribute_value->id }}">{{ $attribute_value->value }}</span>
                                                </td>
                                                @endforeach
                                                @for ($i = $variant->attributes->count(); $i < $maxAttributesCount; $i++)
                                                    <td></td>
                                                @endfor
                                                <td>
                                                    <input type="number" name="variant_prices[]" class="form-control"
                                                        value="{{ $variant->price }}" required>
                                                    <span class="error-message text-danger"
                                                        id="error-variant-price-{{ $variant->id }}"></span>
                                                </td>
                                                <td>
                                                    <input type="number" name="variant_stocks[]" class="form-control"
                                                        value="{{ $variant->stock_quantity }}" required>
                                                    <span class="error-message text-danger"
                                                        id="error-variant-stock-{{ $variant->id }}"></span>
                                                </td>
                                                <td><input type="text" name="variant_skus[]" class="form-control"
                                                        value="{{ $variant->product_code }}" readonly></td>
                                                <td>
                                                    <input type="file" name="variant_images[]" class="form-control-file"
                                                        style="width: 100px;">
                                                    {{-- <label class="custom-file-label" for="variant-image-input"></label> --}}
                                                    <img src="{{ Storage::url($variant->image) }}" class="img-preview"
                                                        alt="Preview"
                                                        style="width: 50px; height: 50px; object-fit: cover;">
                                                </td>
                                                <td class="variant-actions">
                                                    <button type="button" class="delete-variant"
                                                        data-variant-id="{{ $variant->id }}">
                                                        <i class="fa fa-fw fa-times text-danger"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    {{-- <button type="submit" class="btn btn-success">Lưu sản phẩm</button> --}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="btn">
                        <button type="submit" class="btn btn-outline-primary mb-3">Cập nhật sản phẩm</button>
                    </div>
                </div>
        </form>
    </div>
</div>
@endsection
@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Nhúng Summernote JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>
<script>
$(document).ready(function() {
    // Kiểm tra và hiển thị thông báo lỗi khi người dùng nhập vào các trường
    function validateFields() {
        const bulkPrice = $("#bulk_price").val();
        const bulkStock = $("#bulk_stock").val();
        let isValid = true; // Biến kiểm tra tính hợp lệ

        // Reset lại thông báo lỗi và trạng thái input
        $("#bulk_price, #bulk_stock").removeClass("is-invalid");
        $("#error-bulk-price, #error-bulk-stock").text("");

        // Kiểm tra "Giá bán lẻ" nếu có nhập
        if (bulkPrice !== "") {
            if (isNaN(bulkPrice) || parseFloat(bulkPrice) <= 0) {
                $("#bulk_price").addClass("is-invalid");
                $("#error-bulk-price").text("Giá bán lẻ phải lớn hơn 0");
                isValid = false;
            }
        }

        // Kiểm tra "Số lượng" nếu có nhập
        if (bulkStock !== "") {
            if (isNaN(bulkStock) || parseFloat(bulkStock) <= 0) {
                $("#bulk_stock").addClass("is-invalid");
                $("#error-bulk-stock").text("Số lượng phải lớn hơn 0");
                isValid = false;
            }
        }

        // Nếu không có lỗi, bật nút "Áp dụng"
        if (isValid) {
            $("#apply-bulk-edit").prop("disabled", false);
        } else {
            $("#apply-bulk-edit").prop("disabled", true);
        }

        return isValid; // Trả về trạng thái hợp lệ
    }

    // Lắng nghe sự kiện input trên các trường để kiểm tra ngay khi nhập
    $("#bulk_price, #bulk_stock").on("input", function() {
        validateFields(); // Kiểm tra lại tất cả các trường khi người dùng nhập
    });

    $("#apply-bulk-edit").on("click", function() {
        if (validateFields()) {
            const bulkPrice = $('#bulk_price').val();
            const bulkStock = $('#bulk_stock').val();
            // const bulkSku = $('#bulk_sku').val();
            const applyTo = $('#apply_to').val(); // Lấy giá trị của tùy chọn áp dụng

            if (applyTo === 'all') {
                // Áp dụng cho tất cả các biến thể
                $('.variant').each(function() {
                    if (bulkPrice) {
                        $(this).find('input[name="variant_prices[]"]').val(
                            bulkPrice);
                    }

                    if (bulkStock) {
                        $(this).find('input[name="variant_stocks[]"]').val(
                            bulkStock);
                    }

                });
            }
        }
    });

});
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
{{-- SELECT2 --}}
<script>
$(document).ready(function() {
    $('.attributes-select').select2({
        placeholder: "Select attributes",
        allowClear: true,
        tags: true
    });
});

$(document).ready(function() {
    // Khởi tạo Select2 cho danh mục
    $('#catalogue-select').select2({
        placeholder: "Chọn danh mục",
        allowClear: true
    });
});
</script>

{{-- DESCRIPTIONS EDITOR --}}
<script>
$(document).ready(function() {
    const maxLength = 200;

    // Lắng nghe sự kiện khi người dùng nhập vào textarea
    $('#short_description').on('input', function() {
        const length = $(this).val().length;
        const remaining = maxLength - length;

        // Cập nhật số ký tự còn lại
        $('#char-count').text('Còn lại ' + remaining + ' ký tự');
    });
});
</script>

{{-- SELECT2 ATTRIBUTE --}}
<script>
$(document).ready(function() {
    // Biến chứa danh sách các thuộc tính đã được sử dụng và các giá trị của chúng
    const usedAttributes = @json($usedAttributes);
    const attributes = @json($attributes); // Danh sách thuộc tính từ server
    const maxAttributesCount = {{ $product->variants->max(fn($variant) => $variant->attributes->count()) }};
    // Khởi tạo Select2 cho các thuộc tính
    function initSelect2() {
        $('.select2-tags').select2({
            tags: true,
            placeholder: 'Chọn hoặc nhập giá trị',
            allowClear: true,
            tokenSeparators: [',', ' ']
        });
    }


    let selectedAttributes = new Set();

    // Hàm hiển thị các thuộc tính đã được sử dụng
    function loadUsedAttributes() {
        const attributeSection = $('#attributes-section');
        let attributeCount = 0;

        // Lặp qua từng thuộc tính đã được sử dụng
        for (const [attributeId, valueIds] of Object.entries(usedAttributes)) {
            const attribute = attributes.find(attr => attr.id == attributeId);

            if (!attribute) {
                continue; // Nếu thuộc tính không tồn tại trong danh sách attributes, bỏ qua
            }

            // Tạo các option giá trị cho thuộc tính
            const valueOptions = attribute.values.map(val => {
                const isSelected = valueIds.includes(val.id) ? 'selected' : '';
                return `<option value="${val.id}" ${isSelected}>${val.value}</option>`;
            }).join('');

            // Thêm thuộc tính vào giao diện
            let attributeSelect = `
                <div class="row form-group attribute-group position-relative mt-3 p-3" style="background-color: #f5f5f5">
                    <!-- Label và Select cho Thuộc tính -->
                    <div class="col-12">
                        <label for="attributes_${attributeCount}">Thuộc tính</label>
                        <select class="form-control attribute-select" name="attribute_ids[]" data-index="${attributeCount}" required>
                            <option value="${attribute.id}" selected>${attribute.name}</option>
                        </select>
                    </div>

                    <!-- Label và Select cho Giá trị -->
                    <div class="col-12 form-group mt-2 value-section">
                        <label for="values_${attributeCount}">Giá trị</label>
                        <select name="values[${attributeCount}][]" class="form-control select2-tags" multiple="multiple">
                            ${valueOptions}
                        </select>
                    </div>

                    <!-- Nút xóa được đặt lên góc phải -->
                    <span class="remove-attribute-btn position-absolute" style="top: 0; right: 0 !important; cursor: pointer; font-size: 20px; color: red;">&times;</span>
                </div>
            `;

            attributeSection.append(attributeSelect);
            selectedAttributes.add(parseInt(attribute.id)); // Đánh dấu thuộc tính đã được chọn
            attributeCount++;
        }

        initSelect2(); // Khởi tạo lại Select2 cho các thuộc tính đã thêm
    }

    // Gọi hàm để load các thuộc tính đã được sử dụng khi trang tải
    $(document).ready(function() {
        loadUsedAttributes();
    });

    // Thêm thuộc tính động khi nhấn nút "Thêm thuộc tính"
    $('#add-attribute-btn').on('click', function() {
        const attributeSection = $('#attributes-section');
        const attributeCount = $('.attribute-select').length;

        if (attributeCount >= 50) {
            alert('Bạn không thể tạo quá 50 biến thể.');
            return;
        }

        const attributeOptions = attributes.map(attr => {
            return selectedAttributes.has(attr.id) ? '' :
                `<option value="${attr.id}">${attr.name}</option>`;
        }).join('');

        let attributeSelect = `
            <div class="row form-group attribute-group position-relative mt-3 p-3" style="background-color: #f5f5f5">
                <!-- Label và Select cho Thuộc tính -->
                <div class="col-12">
                    <label for="attributes_${attributeCount}">Thuộc tính</label>
                    <select class="form-control attribute-select" name="attribute_ids[]" data-index="${attributeCount}" required>
                        <option value="">Chọn thuộc tính</option>
                        ${attributeOptions}
                    </select>
                </div>

                <!-- Label và Select cho Giá trị -->
                <div class="col-12 form-group mt-2 value-section">
                    <label for="values_${attributeCount}">Giá trị</label>
                    <select name="values[${attributeCount}][]" class="form-control select2-tags" multiple="multiple"></select>
                </div>

                <!-- Nút xóa được đặt lên góc phải -->
                <span class="remove-attribute-btn position-absolute" style="top: 0; right: 0 !important; cursor: pointer; font-size: 20px; color: red;">&times;</span>
            </div>
        `;

        attributeSection.append(attributeSelect);
        initSelect2(); // Khởi tạo lại Select2 cho các thuộc tính mới
    });

    // Khi chọn thuộc tính, hiển thị các giá trị thuộc tính
    $(document).on('change', '.attribute-select', function() {
        const attributeId = $(this).val();
        const index = $(this).data('index');
        const valueSection = $(this).closest('.attribute-group').find('.value-section select');

        if (!attributeId) {
            return;
        }

        const attribute = attributes.find(attr => attr.id == attributeId);
        const valueOptions = attribute.values.map(val =>
            `<option value="${val.id}">${val.value}</option>`).join('');
        valueSection.html(valueOptions);

        selectedAttributes.add(parseInt(attributeId)); // Đánh dấu thuộc tính đã chọn

        // Disable attribute select after selection
        $(this).prop('disabled', true);
    });

    // Xóa thuộc tính
    $(document).on('click', '.remove-attribute-btn', function() {
        const attributeGroup = $(this).closest('.attribute-group');
        const attributeId = attributeGroup.find('.attribute-select').val();

        // Loại bỏ thuộc tính khỏi danh sách các thuộc tính đã chọn
        selectedAttributes.delete(parseInt(attributeId));

        // Xóa nhóm thuộc tính
        attributeGroup.remove();
    });

    // Tạo tổ hợp biến thể khi nhấn nút "Tạo biến thể"
    $(document).ready(function() {
        const existingVariants = new Set(); // Sử dụng Set để lưu trữ tổ hợp không trùng lặp

        // Khi trang được tải, lưu các biến thể đã có từ DB vào Set
        $('.variant-existing').each(function () {
            let variantAttributes = [];
            // Lấy tất cả các giá trị (value_id) từ hàng biến thể hiện tại
            $(this).find('span[data-value-id]').each(function () {
                const valueId = $(this).data('value-id');
                variantAttributes.push(valueId); // Chỉ lấy value_id
            });

            // Sắp xếp tổ hợp giá trị theo thứ tự chữ cái để đảm bảo tính nhất quán
            const sortedCombination = variantAttributes.sort().join(','); // Kết hợp thành chuỗi
            existingVariants.add(sortedCombination); // Thêm tổ hợp vào Set
            console.log(`Tổ hợp từ DB: ${sortedCombination}`);
        });


        // Tạo tổ hợp biến thể khi nhấn nút "Tạo biến thể"
        $('#generate-variants-btn').on('click', function() {
            const variantsContainer = $('#variant-container');
            let attributesData = [];

            // Lấy thuộc tính đã chọn
            $('.attribute-group').each(function() {
                const attributeId = $(this).find('.attribute-select').val();
                const values = $(this).find('.select2-tags').val();
                if (values.length > 0) {
                    attributesData.push({
                        attributeId,
                        values
                    });
                }
            });

            if (attributesData.length === 0) {
                alert('Vui lòng chọn ít nhất một thuộc tính và giá trị.');
                return;
            }

            // Tính toán tổng số tổ hợp
            let totalCombinations = attributesData.reduce((total, attr) => total * attr
                .values.length, 1);

            // Kiểm tra giới hạn 50 biến thể
            if (totalCombinations > 50) {
                const confirmContinue = confirm(
                    'Số lượng biến thể vượt quá giới hạn cho phép (tối đa 50 biến thể mỗi lần). Bạn có muốn chỉ tạo 50 biến thể không?'
                );
                if (!confirmContinue) {
                    return; // Hủy tạo biến thể nếu người dùng không đồng ý
                }
            }

            let combinations = generateCombinations(attributesData.map(attr => attr
                .values));

            const updateVariantHeader = () => {
                const variantHeader = $('#variant-header');
                variantHeader.empty(); // Xóa các cột hiện tại

                // Thêm các cột thuộc tính động vào header
                attributesData.forEach((attribute, index) => {
                    variantHeader.append(`<th>Thuộc tính ${index + 1}</th>`);
                });

                // Thêm các cột cố định
                variantHeader.append(`
                <th>Giá bán<span class="text-danger">*</span></th>
                <th>Số lượng<span class="text-danger">*</span></th>
                <th>Mã sản phẩm</th>
                <th>Ảnh<span class="text-danger">*</span></th>
                <th></th>
            `);
            };

            // Gọi hàm cập nhật header
            updateVariantHeader();

            // Tạo biến thể từ tổ hợp giá trị
            // Tạo biến thể từ tổ hợp giá trị
            let variantIndex2 = $('.variant').length; // Lấy số lượng biến thể hiện có
            let newVariantIndex = 0;

            combinations.forEach((combination) => {
                // Tạo cột HTML động cho từng thuộc tính
                let attributesHtml = '';
                combination.forEach((valueId, attrIndex) => {
                    const attributeId = attributesData[attrIndex].attributeId;
                    const attributeValueName = getAttributeValueName(
                        attributeId, valueId);

                    // Lưu giá trị thuộc tính trong data-* để tiện sử dụng sau này
                    attributesHtml +=
                        `<td data-attribute-id="${attributeId}" data-value-id="${valueId}">${attributeValueName}</td>`;
                });

                // Kiểm tra tổ hợp đã tồn tại chưa
                const currentCombination = combination.sort().join(',');
                if (existingVariants.has(currentCombination)) {
                    console.log(`Tổ hợp ${currentCombination} đã tồn tại, bỏ qua.`);
                    return; // Bỏ qua tổ hợp nếu đã tồn tại
                }

                // Nếu tổ hợp chưa tồn tại, thêm vào Set
                console.log(`Tổ hợp ${currentCombination} chưa tồn tại, thêm mới.`);
                existingVariants.add(currentCombination);

                const sku =
                    `PRD-${Math.random().toString(36).substring(2, 10).toUpperCase()}`; // Tạo SKU ngẫu nhiên

                // Tạo HTML cho hàng biến thể mới
                let variantHtml = `
                                    <tr class="variant variant-new">
                                        ${attributesHtml} <!-- Các cột thuộc tính động -->
                                        <td><input type="number" name="new_variant_prices[]" class="form-control variant-input" required> <span class="error-message text-danger"></span></td>
                                        <td><input type="number" name="new_variant_stocks[]" class="form-control variant-input" required> <span class="error-message text-danger"></span></td>
                                        <td><input type="text" name="new_variant_skus[]" class="form-control variant-input" value="${sku}" readonly></td>
                                        <td>
                                            <div class="custom-file2">
                                                <input type="file" name="new_variant_images[]" class="variant-image-input">
                                            </div>
                                            <div id="variant-image-container">
                                                <img src="" class="img-preview" alt="" style="width: 50px; height: 50px; object-fit: cover;">
                                            </div>
                                        </td>
                                        <td class="variant-actions">
                                            <button type="button" class="delete-variant"> <i class="fa fa-fw fa-times text-danger"></i></button>
                                        </td>
                                    </tr>
                                    `;

                // Thêm biến thể mới vào danh sách
                variantsContainer.append(variantHtml);

                // Lưu giá trị thuộc tính vào input ẩn
                combination.forEach((valueId, attrIndex) => {
                    const attributeId = attributesData[attrIndex].attributeId;
                    $(`<input type="hidden" name="new_values[${newVariantIndex}][${attrIndex}][attribute_id]" value="${attributeId}">`)
                        .appendTo(variantsContainer);
                    $(`<input type="hidden" name="new_values[${newVariantIndex}][${attrIndex}][attribute_value_id]" value="${valueId}">`)
                        .appendTo(variantsContainer);
                });

                newVariantIndex++; // Tăng chỉ số cho biến thể tiếp theo
            });

        });
    });

    // Hàm tạo tổ hợp các giá trị thuộc tính
    function generateCombinations(valuesArray, prefix = []) {
        if (!valuesArray.length) {
            return [prefix];
        }

        let combinations = [];
        let firstArray = valuesArray[0];
        let restArrays = valuesArray.slice(1);

        firstArray.forEach(value => {
            combinations = combinations.concat(generateCombinations(restArrays, [...prefix,
                value
            ]));
        });

        return combinations;
    }

    // Lấy tên giá trị thuộc tính
    function getAttributeValueName(attributeId, valueId) {
        const attribute = attributes.find(attr => attr.id == attributeId);
        if (attribute) {
            const value = attribute.values.find(val => val.id == valueId);
            return value ? value.value : '';
        }
        return '';
    }

    $(document).on('change', '.variant-image-input', function(e) {
        const reader = new FileReader();
        const imgPreview = $(this).closest('td').find('.img-preview'); // Tìm ảnh trong cùng td

        reader.onload = function(e) {
            imgPreview.attr('src', e.target.result); // Gán ảnh mới
        }

        if (this.files && this.files[0]) {
            reader.readAsDataURL(this.files[0]);
        }
    });
    // Chỉnh sửa hàng loạt giá và số lượng
    // Sự kiện khi nhấn vào nút để mở dropdown
    $('.toggle-dropdown').on('click', function() {
        // Hiển thị hoặc ẩn nội dung bên dưới
        $('.dropdown-content').slideToggle();
    });


    // Xóa biến thể
    $(document).ready(function() {
        // Khi nhấn nút "Xóa" của một biến thể
        $(document).on('click', '.delete-variant', function() {
            const variantId = $(this).closest('tr').data(
                'variant-id'); // Lấy ID của biến thể

            if (variantId) {
                // Tạo input ẩn cho biến thể bị xóa nếu chưa tồn tại
                if (!$(`input[name="deleted_variant_ids[]"][value="${variantId}"]`)
                    .length) {
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'deleted_variant_ids[]', // Tạo input name dạng mảng
                        value: variantId
                    }).appendTo('form'); // Append input vào form
                }
            }

            // Xóa hàng tương ứng khỏi bảng
            $(this).closest('tr').remove();
        });
    });
});
</script>

{{-- TEXT EDITOR --}}
<script>
$(document).ready(function() {
    $('#editor').summernote({
        height: 300
    });
});
</script>

{{-- PREVIEW IMAGE --}}
@php
// Kiểm tra nếu images không phải là null hoặc empty
$subImages = $product->productImages ? $product->productImages->map(function ($item) {
return [
'id' => $item->id,
'url' => Storage::url($item->image_path),
];
})->toArray() : []; // Nếu không có images, trả về mảng trống
@endphp

<script>
document.addEventListener('DOMContentLoaded', function() {
    // URL của ảnh chính
    const mainImageURL = "{{ Storage::url($product->avata) }}";
    // Mảng chứa các URL và ID của ảnh phụ
    const subImagesURLs = @json($subImages);

    // Các container để hiển thị ảnh
    const mainImageContainer = document.getElementById('main-image-container');
    const subImagesContainer = document.getElementById('sub-images-container');

    const deletedImages = []; // Mảng lưu các ID của ảnh phụ bị xóa
    const deletedImagesInput = document.getElementById('deleted-images');

    // Hàm hiển thị ảnh chính từ DB
    function loadMainImageFromDB(url, container) {
        if (url) {
            container.innerHTML = ''; // Xóa nội dung cũ nếu có
            const imgElement = document.createElement('img');
            imgElement.src = url;
            imgElement.style.maxWidth = '200px'; // Kích thước ảnh chính
            container.appendChild(imgElement);
        }
    }

    // Hàm hiển thị nhiều ảnh phụ từ DB
    function loadSubImagesFromDB(images, container) {
        container.innerHTML = ''; // Xóa ảnh cũ trong container nếu có
        images.forEach(image => {
            const imgWrapper = document.createElement('div');
            imgWrapper.classList.add('img-wrapper');

            const imgElement = document.createElement('img');
            imgElement.src = image.url; // URL của ảnh
            imgElement.style.maxWidth = '100px'; // Kích thước ảnh phụ

            // Nút xóa
            const deleteBtn = document.createElement('button');
            deleteBtn.classList.add('delete-btn');
            deleteBtn.textContent = 'x';
            deleteBtn.addEventListener('click', function() {
                imgWrapper.remove(); // Xóa ảnh khỏi giao diện
                deletedImages.push(image.id); // Thêm ID của ảnh vào mảng deletedImages
                deletedImagesInput.value = JSON.stringify(deletedImages);
            });

            imgWrapper.appendChild(imgElement);
            imgWrapper.appendChild(deleteBtn);
            container.appendChild(imgWrapper);
        });
    }

    // Hiển thị ảnh từ DB khi trang load
    loadMainImageFromDB(mainImageURL, mainImageContainer);
    loadSubImagesFromDB(subImagesURLs, subImagesContainer);

    // Xử lý khi tải ảnh chính từ input
    const mainImageInput = document.getElementById('main-image-input');
    mainImageInput.addEventListener('change', function() {
        displayImage(this, mainImageContainer);

    });

    // Hàm hiển thị ảnh chính khi chọn từ input
    function displayImage(input, container) {
        container.innerHTML = ''; // Xóa nội dung cũ nếu có
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgElement = document.createElement('img');
                imgElement.src = e.target.result;
                imgElement.style.maxWidth = '200px'; // Kích thước ảnh chính
                container.appendChild(imgElement);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Hiển thị nhiều ảnh phụ mà không làm mất ảnh trước đó
    const subImagesInput = document.getElementById('sub-images-input');
    const subImageList = []; // Danh sách lưu các ảnh phụ đã chọn
    subImagesInput.addEventListener('change', function() {
        displayMultipleImages(this, subImagesContainer, subImageList);
    });

});

// Hàm hiển thị nhiều ảnh phụ khi chọn từ input
function displayMultipleImages(input, container, imageList) {
    Array.from(input.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const imgWrapper = document.createElement('div');
            imgWrapper.classList.add('img-wrapper');

            const imgElement = document.createElement('img');
            imgElement.src = e.target.result;
            imgElement.style.maxWidth = '100px'; // Kích thước ảnh phụ

            // Nút xóa
            const deleteBtn = document.createElement('button');
            deleteBtn.classList.add('delete-btn');
            deleteBtn.textContent = 'x';
            deleteBtn.addEventListener('click', function() {
                imgWrapper.remove(); // Xóa ảnh khi nhấn nút xóa
            });

            imgWrapper.appendChild(imgElement);
            imgWrapper.appendChild(deleteBtn);
            container.appendChild(imgWrapper);
        };
        reader.readAsDataURL(file);
    });
}
</script>

{{-- validate variant --}}
<script src="{{ asset('admin/js/ui/validations/product-edit.js') }}"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const MAX_TITLE_LENGTH = 60;
    const MAX_KEYWORDS_LENGTH = 255;
    const MAX_DESCRIPTION_LENGTH = 160;


    function updateCounter(input, counter, maxLength) {
        const remaining = maxLength - input.value.length;
        counter.textContent = `${remaining} ký tự còn lại`;

        // Đổi màu cảnh báo nếu hết ký tự
        counter.classList.toggle("error", remaining === 0);
    }

    function handleInputEvent(input, counter, maxLength) {
        updateCounter(input, counter, maxLength);
    }

    function handleKeydownEvent(event, input, maxLength) {
        const allowedKeys = [
            "Backspace", "Delete", "ArrowLeft", "ArrowRight", "Tab"
        ];
        // Kiểm tra nếu đã đạt giới hạn và phím không thuộc danh sách cho phép
        if (input.value.length >= maxLength && !allowedKeys.includes(event.key)) {
            event.preventDefault(); // Chặn ngay lập tức
        }
    }
});
</script>
@endsection