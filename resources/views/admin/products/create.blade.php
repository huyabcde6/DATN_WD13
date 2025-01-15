@extends('layouts.admin')

@section('title')
Thêm mới sản phẩm
@endsection

@section('css')
<!-- Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<!-- Nhúng Summernote CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.css" rel="stylesheet">
<!-- Nhúng jQuery (nếu chưa có) -->
<link rel="stylesheet" href="{{ asset('admin/js/plugins/simplemde/simplemde.min.css') }}">
<style>
input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Bỏ nút tăng giảm cho Firefox */
input[type="number"] {
    -moz-appearance: textfield;
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
<div class="row m-3">
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Thêm mới sản phẩm</h1>
            </div>
        </div>
    </div>
    <!-- END Hero -->
    <div class="content fs-sm">
        {{-- Form bắt đầu --}}
        <form id="myForm" action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="card">
                <div class="block block-rounded">
                    <div class="block-content">
                        <div class="row m-3">
                            <!-- Cột bên trái: Nhập thông tin sản phẩm -->
                            <div class="col-7">
                                <!-- Tên sản phẩm -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Tên sản phẩm<span
                                            class="text-danger">*</span>:</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" id="name" value="{{ old('name') }}" placeholder="Nhập tên sản phẩm">
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="slug" class="form-label">Slug :</label>
                                    <input type="text" class="form-control" name="slug" id="slug"
                                        value="{{ old('slug') }}" placeholder="Slug" readonly>
                                </div>
                                <!-- Giá sản phẩm -->
                                <div class="row">
                                    <!-- Giá gốc -->
                                    <div class="col-6 mb-3">
                                        <label for="price" class="form-label">Giá gốc<span
                                                class="text-danger">*</span>:</label>
                                        <input type="number" class="form-control @error('price') is-invalid @enderror"
                                            name="price" id="price" value="{{ old('price') }}"
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
                                            value="{{ old('discount_price') }}" placeholder="Nhập giá khuyến mãi">
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
                                        placeholder="Nhập tối đa 200 ký tự...">{{ old('short_description') }}</textarea>
                                    <small id="char-count" class="form-text text-muted">Còn lại 200 ký tự</small>
                                    @error('short_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Nội dung chi tiết -->
                                <div class="mb-3">
                                    <label for="editor" class="form-label">Nội dung:</label>
                                    <textarea name="description" id="editor"
                                        class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                    @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Cột bên phải: Thuộc tính sản phẩm và ảnh -->
                            <div class="col-5">
                                <!-- Danh mục -->
                                <div class="row form-group mb-3">
                                    <label class="form-label" for="catalogue-select">Danh mục:</label>
                                    <select name="categories_id" id="categories_id" class="form-select">
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('categories_id') == $category->id ? 'selected' : '' }}>
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
                                    <div class="row status-group">
                                        <!-- Is active -->
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="is_show" id="gridRadios1"
                                                value="1" checked>
                                            <label class="form-check-label" for="gridRadios1">Hiển thị</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="is_show" id="gridRadios2"
                                                value="0">
                                            <label class="form-check-label" for="gridRadios2">Ẩn</label>
                                        </div>
                                    </div>

                                    <div class="row mt-3 status-group">
                                        <!-- Is new -->
                                        <div class="form-check form-switch">
                                            <input type="hidden" name="is_new" value="0">
                                            <input class="form-check-input" type="checkbox" id="is_new" name="is_new"
                                                value="1" checked>
                                            <label class="form-check-label" for="is_new">New</label>
                                        </div>
                                        <!-- Is hot -->
                                        <div class="form-check form-switch">
                                            <input type="hidden" name="is_hot" value="0">
                                            <input class="form-check-input" type="checkbox" id="is_hot" name="is_hot"
                                                value="1">
                                            <label class="form-check-label" for="is_hot">Hot</label>
                                        </div>
                                    </div>
                                </div>


                                <!-- Nút tải ảnh chính -->
                                <div class="form-group image-preview" id="main-image-preview">
                                    <label class="form-label">Tải lên ảnh chính<span
                                            class="text-danger">*</span>:</label>
                                    @error('avata')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="custom-file">
                                        <input type="file" name="avata" class="form-control-file" id="main-image-input">
                                        <label class="custom-file-label" for="main-image-input"></label>
                                    </div>
                                    <div id="main-image-container"></div> <!-- Hiển thị ảnh chính -->
                                </div>

                                <!-- Tải lên ảnh phụ -->
                                <div class="form-group image-preview" id="sub-images-preview">
                                    <label class="form-label">Tải lên ảnh phụ<span
                                    class="text-danger">*</span>:</label>
                                    @error('images')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="custom-file">
                                        <input type="file" name="images[]" class="form-control-file"
                                            id="sub-images-input" multiple>
                                        <label class="custom-file-label" for="sub-images-input"></label>
                                    </div>
                                    <div id="sub-images-container"></div> <!-- Hiển thị các ảnh phụ -->
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


                                {{-- <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h3 class="d-inline">Danh sách biến thể</h3>
                                    <div></div> <!-- Tạo khoảng trống để căn chỉnh -->

                                </div> --}}
                                <div class="d-flex justify-content-between align-items-center mb-3 mt-5">
                                    <h5 class="d-inline">Danh sách biến thể</h5>
                                    <div></div> <!-- Tạo khoảng trống để căn chỉnh -->

                                    <div class=" fake-dropdown">
                                        <button class="btn btn-sm btn-alt-secondary toggle-dropdown p-2" type="button">
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
                                                class="btn btn-sm btn-alt-secondary w-100 p-2">Áp dụng</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3 mb-3">
                                    <button type="button" id="generate-variants-btn"
                                        class="btn btn-sm btn-alt button-css">
                                        <i class="fa fa-plus"></i>Tạo biến thể</button>
                                </div>

                                <!-- Danh sách biến thể dưới dạng bảng -->
                                <table class="table table-hover variant-table">
                                    <thead>
                                        <tr id="variant-header">
                                            <th>Thuộc tính</th>
                                            <th>Giá bán<span class="text-danger">*</span></th>
                                            <th>Số lượng<span class="text-danger">*</span></th>
                                            <th>Mã sản phẩm</th>
                                            <th>Ảnh<span class="text-danger">*</span></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="variant-container">
                                        <!-- Biến thể sẽ được thêm vào đây -->
                                    </tbody>
                                </table>



                                {{-- <button type="submit" class="btn btn-success">Lưu sản phẩm</button> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btn">
                    <button type="submit" class="btn btn-outline-primary">Tạo sản phẩm</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('js')
{{-- <script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script> --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Nhúng Summernote JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script> <!-- Thêm dòng này -->
{{-- <script src="{{asset('admin/js/ui/product-ui/preview-image.js')}}"></script> --}}

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

{{-- <script>
        const csrfToken = "{{ csrf_token() }}";
</script> --}}

<script>
$(document).ready(function() {
    const attributes = @json($attributes); // Danh sách thuộc tính từ server

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

    // Thêm thuộc tính động
    let clickCount = 0;
    $('#add-attribute-btn').on('click', function() {
        const attributeSection = $('#attributes-section');
        const attributeCount = $('.attribute-select').length;
        const totalAttributes = attributes.length;

        if (attributeCount >= 50) {
            alert('Bạn không thể tạo quá 50 biến thể.');
            return;
        }

        const attributeOptions = attributes; // Danh sách thuộc tính từ server

        let attributeSelect = `
                                <div class="row form-group attribute-group position-relative mt-3 p-3" style="background-color: #f5f5f5">
                                    <!-- Label và Select cho Thuộc tính -->
                                    <div class="col-12">
                                        <label for="attributes_${attributeCount}">Thuộc tính</label>
                                        <select class="form-control attribute-select" name="attribute_ids[]" data-index="${attributeCount}" required>
                                            <option value="">Chọn thuộc tính</option>
                                            ${attributeOptions.map(attr => {
                                                return selectedAttributes.has(attr.id) ? '' : `<option value="${attr.id}">${attr.name}</option>`;
                                            }).join('')}
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
        initSelect2(); // Khởi tạo lại Select2 cho các ô mới

        // Nếu click lần thứ 2 thì ẩn nút
        if (attributeCount + 1 >= totalAttributes) {
            $(this).hide();
        }
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

        // Thêm thuộc tính đã chọn vào tập hợp để không thể chọn lại
        selectedAttributes.add(parseInt(attributeId));

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
        clickCount--;

        // Hiển thị lại nút thêm nếu số lần click nhỏ hơn 2
        if (clickCount < 2) {
            $('#add-attribute-btn').show();
        }
    });

    // Tạo tổ hợp biến thể
    $('#generate-variants-btn').on('click', function() {
        const variantsContainer = $('#variant-container');
        variantsContainer.html(''); // Xóa các biến thể cũ

        let attributesData = [];

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
        let totalCombinations = attributesData.reduce((total, attr) => total * attr.values.length,
            1);

        // Kiểm tra giới hạn 50 biến thể
        if (totalCombinations > 50) {
            const confirmContinue = confirm(
                'Số lượng biến thể vượt quá giới hạn cho phép (tối đa 50 biến thể mỗi lần). Bạn có muốn chỉ tạo 50 biến thể không?'
            );
            if (!confirmContinue) {
                return; // Hủy tạo biến thể nếu người dùng không đồng ý
            }
        }

        let combinations = generateCombinations(attributesData.map(attr => attr.values));

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
        combinations.forEach((combination, index) => {
            if (index >= 50) {
                return; // Giới hạn 50 biến thể
            }

            // const sku = 'SKU-prdas' + combination.join('-');
            const sku = `PRD-${Math.random().toString(36).substring(2, 10).toUpperCase()}`;

            // Lấy tên của giá trị thuộc tính thay vì ID
            let attributeNames = combination.map((valueId, i) => {
                const attributeId = attributesData[i].attributeId;
                return {
                    attribute_id: attributeId,
                    attribute_value_id: valueId
                }; // Tạo object attribute_id và attribute_value_id
            });

            // Hiển thị các giá trị thuộc tính đã được chọn (kích cỡ và màu sắc)
            // <td>${index + 1}</td>
            let variantHtml = `<tr class="variant">`;

            // Tự động thêm các thuộc tính vào bảng
            attributeNames.forEach(attribute => {
                variantHtml +=
                    `<td>${getAttributeValueName(attribute.attribute_id, attribute.attribute_value_id)}</td>`;
            });

            // Thêm các cột cố định (giá, tồn kho, SKU, hình ảnh, hành động)
            variantHtml += `
                                <td>
                                    <input type="number" id="variant-prices-input" name="variant_prices[]" class="form-control variant-input" required>
                                    <span class="error-message text-danger"></span>
                                </td>
                                <td>
                                    <input type="number" id="variant-stocks-input" name="variant_stocks[]" class="form-control variant-input" required>
                                    <span class="error-message text-danger"></span>
                                </td>
                                <td><input type="text" name="variant_skus[]" class="form-control variant-input" value="${sku}" readonly></td>
                                <td>
                                    <div class="custom-file2">
                                        <input type="file" name="variant_images[]" class="variant-image-input">
                                    </div>
                                    <div id="variant-image-container">
                                        <img src="https://uxwing.com/wp-content/themes/uxwing/download/video-photography-multimedia/photos-icon.svg" class="img-preview" alt="" style="width: 50px; height: auto; object-fit: cover;">
                                    </div>
                                </td>
                                <td class="variant-actions">
                                    <button type="button" class="delete-variant"><i class="fa fa-fw fa-times text-danger"></i></button>
                                </td>
                            </tr>`;

            // Chèn vào container
            variantsContainer.append(variantHtml);


            // Lưu thông tin thuộc tính của từng biến thể
            attributeNames.forEach((attrName, attrIndex) => {
                $(`<input type="hidden" name="values[${index}][${attrIndex}][attribute_id]" value="${attrName.attribute_id}">`)
                    .appendTo(variantsContainer);
                $(`<input type="hidden" name="values[${index}][${attrIndex}][attribute_value_id]" value="${attrName.attribute_value_id}">`)
                    .appendTo(variantsContainer);
            });
        });
    });

    // $(document).on('click', '.custom-file-btn', function() {
    //     $(this).siblings('input[type="file"]').click(); // Kích hoạt click cho input file
    // });
    // Hiển thị preview ảnh khi người dùng chọn ảnh
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

    // Xóa biến thể
    $(document).on('click', '.delete-variant', function() {
        $(this).closest('tr').remove();
    });

    // Sự kiện khi nhấn vào nút để mở dropdown
    $('.toggle-dropdown').on('click', function() {
        // Hiển thị hoặc ẩn nội dung bên dưới
        $('.dropdown-content').slideToggle();
    });

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

    // Tạo tổ hợp các giá trị thuộc tính
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
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Lắng nghe sự kiện submit trên form
    const form = document.getElementById('myForm'); // Thay 'myForm' bằng id của form của bạn
    form.addEventListener('submit', function(event) {
        if (!validateForm()) {
            event.preventDefault(); // Ngăn chặn submit nếu có lỗi
        }
    });

    // Lắng nghe sự kiện nhập (input) trên từng trường
    document.getElementById('name').addEventListener('input', function() {
        validateName();
    });

    document.getElementById('price').addEventListener('input', function() {
        validatePriceRegular();
        validatePriceSale(); // Kiểm tra lại giá sale nếu có thay đổi giá gốc
    });

    document.getElementById('discount_price').addEventListener('input', function() {
        validatePriceSale();
    });

    document.getElementById('short_description').addEventListener('input', function() {
        validateDescription();
    });

    document.getElementById('catalogue-select').addEventListener('change', function() {
        validateCatalogue();
    });

    document.getElementById('main-image-input').addEventListener('change', function() {
        validateMainImage();
    });

    document.getElementById('sub-images-input').addEventListener('change', function() {
        validateSubImages();
    });


    // Hàm kiểm tra toàn bộ form
    function validateForm() {
        let isValid = true;

        if (!validateName()) isValid = false;
        if (!validatePriceRegular()) isValid = false;
        if (!validatePriceSale()) isValid = false;
        if (!validateDescription()) isValid = false;
        if (!validateCatalogue()) isValid = false;
        if (!validateMainImage()) isValid = false;
        if (!validateSubImages()) isValid = false;

        return isValid;
    }

    // Các hàm kiểm tra từng trường
    function validateName() {
        const name = document.getElementById('name');
        clearError(name);
        if (!name.value.trim()) {
            showError(name, 'Tên sản phẩm không được để trống');
            return false;
        }
        return true;
    }

    function validatePriceRegular() {
        const priceRegular = document.getElementById('price');
        clearError(priceRegular); // Xóa thông báo lỗi cũ (nếu có)

        // Kiểm tra xem trường có trống hay không
        if (!priceRegular.value.trim()) {
            showError(priceRegular, 'Giá gốc không được để trống');
            return false;
        }

        // Kiểm tra xem giá trị có phải là số không
        if (isNaN(priceRegular.value)) {
            showError(priceRegular, 'Giá gốc phải là số');
            return false;
        }

        // Kiểm tra xem giá trị có lớn hơn 0 không
        if (Number(priceRegular.value) <= 0) {
            showError(priceRegular, 'Giá gốc phải lớn hơn 0');
            return false;
        }

        return true;
    }


    function validatePriceSale() {
        const priceRegular = document.getElementById('price');
        const priceSale = document.getElementById('discount_price');
        clearError(priceSale);
        if (priceSale.value.trim()) {
            if (isNaN(priceSale.value) || Number(priceSale.value) >= Number(priceRegular.value)) {
                showError(priceSale, 'Giá khuyến mãi phải nhỏ hơn giá gốc');
                return false;
            }
        }
        return true;
    }


    function validateCatalogue() {
        const catalogueSelect = document.getElementById('catalogue-select');
        clearError(catalogueSelect);
        if (catalogueSelect.value === '') {
            showError(catalogueSelect, 'Vui lòng chọn danh mục');
            return false;
        }
        return true;
    }


    // Hàm hiển thị lỗi
    function showError(input, message) {
        const error = document.createElement('div');
        error.className = 'invalid-feedback';
        error.style.color = 'red';
        error.textContent = message;
        input.classList.add('is-invalid');
        input.parentElement.appendChild(error);
    }

    // Hàm xóa lỗi cũ
    function clearError(input) {
        const error = input.parentElement.querySelector('.invalid-feedback');
        if (error) {
            error.remove();
        }
        input.classList.remove('is-invalid');
    }
});
</script>

<script>
$(document).ready(function() {
    $('#editor').summernote({
        height: 300
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Xử lý khi tải ảnh chính
    const mainImageInput = document.getElementById('main-image-input');
    const mainImageContainer = document.getElementById('main-image-container');

    mainImageInput.addEventListener('change', function() {
        displayImage(this, mainImageContainer);
    });

    // Xử lý khi tải ảnh phụ
    const subImagesInput = document.getElementById('sub-images-input');
    const subImagesContainer = document.getElementById('sub-images-container');
    const subImageList = []; // Danh sách lưu các ảnh phụ đã chọn

    subImagesInput.addEventListener('change', function() {
        displayMultipleImages(this, subImagesContainer, subImageList);
    });

    // Hiển thị ảnh chính
    function displayImage(input, container) {
        container.innerHTML = ''; // Xóa nội dung cũ nếu có
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgElement = document.createElement('img');
                imgElement.src = e.target.result;
                imgElement.style.maxWidth = '200px';
                container.appendChild(imgElement);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Hiển thị nhiều ảnh phụ mà không làm mất ảnh trước đó
    function displayMultipleImages(input, container, imageList) {
        Array.from(input.files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Tạo một phần tử bao quanh ảnh và nút xóa
                const imgWrapper = document.createElement('div');
                imgWrapper.classList.add('img-wrapper');

                const imgElement = document.createElement('img');
                imgElement.src = e.target.result;

                // Nút xóa
                const deleteBtn = document.createElement('button');
                deleteBtn.classList.add('delete-btn');
                deleteBtn.textContent = 'x';
                deleteBtn.addEventListener('click', function() {
                    imgWrapper.remove();
                });

                imgWrapper.appendChild(imgElement);
                imgWrapper.appendChild(deleteBtn);
                container.appendChild(imgWrapper);
            };
            reader.readAsDataURL(file);
        });
    }
});
</script>

<script>
$(document).ready(function() {
    // Hàm kiểm tra tính hợp lệ của từng trường
    function validateField(field) {
        const fieldName = $(field).attr('name');

        // Kiểm tra giá bán lẻ (new_variant_prices[])
        if (fieldName === 'variant_prices[]') {
            const price = $(field).val();
            if (price === '' || isNaN(price) || parseFloat(price) <= 0) {
                $(field).addClass('is-invalid');
                $(field).siblings('.error-message').text('Giá bán lẻ phải lớn hơn 0');
            } else {
                $(field).removeClass('is-invalid');
                $(field).siblings('.error-message').text('');
            }
        }
        // Kiểm tra số lượng (new_variant_stocks[])
        if (fieldName === 'variant_stocks[]') {
            const stock = $(field).val();
            if (stock === '' || isNaN(stock) || parseFloat(stock) <= 0) {
                $(field).addClass('is-invalid');
                $(field).siblings('.error-message').text('Số lượng phải lớn hơn 0');
            } else {
                $(field).removeClass('is-invalid');
                $(field).siblings('.error-message').text('');
            }
        }
    }

    // Lắng nghe sự kiện input cho các trường biến thể mới và kiểm tra ngay lập tức khi người dùng nhập
    $(document).on('input',
        'input[name="variant_prices[]"], input[name="variant_stocks[]"]',
        function() {
            validateField(this); // Kiểm tra trường đang nhập ngay lập tức
        });

    // Kiểm tra toàn bộ khi submit form
    $('#myForm').on('submit', function(event) {
        let isValid = true;

        // Kiểm tra tất cả các trường biến thể mới
        $('input[name="variant_prices[]"], input[name="variant_stocks[]"]')
            .each(function() {
                validateField(this); // Kiểm tra từng trường
                if ($(this).hasClass('is-invalid')) {
                    isValid = false; // Nếu có lỗi, ngăn không cho submit
                }
            });

        // Ngăn chặn submit nếu có lỗi
        if (!isValid) {
            event.preventDefault();
        }
    });
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const MAX_TITLE_LENGTH = 60;
    const MAX_KEYWORDS_LENGTH = 255;
    const MAX_DESCRIPTION_LENGTH = 160;

    const metaTitleInput = document.querySelector('input[name="meta_title"]');
    const metaKeywordsInput = document.querySelector('input[name="meta_keywords"]');
    const metaDescriptionInput = document.querySelector('textarea[name="meta_description"]');

    const metaTitleCounter = document.getElementById('meta-title-counter');
    const metaKeywordsCounter = document.getElementById('meta-keywords-counter');
    const metaDescriptionCounter = document.getElementById('meta-description-counter');

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

    // Thêm sự kiện `keydown` và `input` cho các trường
    metaTitleInput.addEventListener("keydown", (event) =>
        handleKeydownEvent(event, metaTitleInput, MAX_TITLE_LENGTH)
    );
    metaTitleInput.addEventListener("input", () =>
        handleInputEvent(metaTitleInput, metaTitleCounter, MAX_TITLE_LENGTH)
    );

    metaKeywordsInput.addEventListener("keydown", (event) =>
        handleKeydownEvent(event, metaKeywordsInput, MAX_KEYWORDS_LENGTH)
    );
    metaKeywordsInput.addEventListener("input", () =>
        handleInputEvent(metaKeywordsInput, metaKeywordsCounter, MAX_KEYWORDS_LENGTH)
    );

    metaDescriptionInput.addEventListener("keydown", (event) =>
        handleKeydownEvent(event, metaDescriptionInput, MAX_DESCRIPTION_LENGTH)
    );
    metaDescriptionInput.addEventListener("input", () =>
        handleInputEvent(metaDescriptionInput, metaDescriptionCounter, MAX_DESCRIPTION_LENGTH)
    );
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
<script>
document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById('myForm'); // Form của bạn
    const variantContainer = document.getElementById('variant-container'); // Container chứa danh sách biến thể

    // Hàm kiểm tra xem có ít nhất một biến thể hay không
    function validateVariants() {
        const variants = variantContainer.querySelectorAll('.variant');
        if (variants.length === 0) {
            alert('Bạn phải tạo ít nhất một biến thể trước khi lưu sản phẩm!');
            return false;
        }
        return true;
    }

    // Lắng nghe sự kiện submit trên form
    form.addEventListener('submit', function(event) {
        // Kiểm tra biến thể trước khi gửi form
        if (!validateVariants()) {
            event.preventDefault(); // Ngăn chặn submit nếu không có biến thể
        }
    });
});
</script>

@endsection