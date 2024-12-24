@extends('layouts.admin')

@section('css')
<style>
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
}

.option-button {
    padding: 10px 15px;
    border: 1px solid #007bff;
    border-radius: 4px;
    background-color: #ffffff;
    color: #007bff;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s, color 0.3s;
}

.option-button:hover {
    background-color: #007bff;
    color: #ffffff;
}

.option-button.selected {
    background-color: #007bff;
    color: #ffffff;
    border-color: #0056b3;
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
            <h4 class="fs-18 fw-semibold m-0">Cập nhật sản phẩm</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.products.update', $products->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="col-lg-7">
                                <div class="mb-3">
                                    <label for="name">Tên sản phẩm <span class="required text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" value="{{ $products->name }}"
                                        placeholder="Tên sản phẩm" id="name" required>
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input type="text" name="slug" class="form-control" placeholder="Slug" id="slug"
                                        value="{{ $products->slug }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="price">Giá sản phẩm <span class="required text-danger">*</span></label>
                                    <input type="number" name="price" id="price" value="{{ $products->price }}"
                                        class="form-control" placeholder="Giá sản phẩm" required>
                                    @error('price')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="discount_price">Giá khuyến mãi <span class="required text-danger">*</span></label>
                                    <input type="number" name="discount_price" value="{{ $products->discount_price }}"
                                        id="discount_price" class="form-control" placeholder="Giá khuyến mãi" required>
                                    @error('discount_price')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="short_description">Mô tả ngắn <span class="required text-danger">*</span></label>
                                    <textarea name="short_description" id="short_description" class="form-control"
                                        placeholder="Mô tả ngắn của sản phẩm"
                                        required>{{ $products->short_description }}</textarea>
                                        @error('short_description')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Mô tả chi tiết sản phẩm</label>
                                    <div id="quill-editor" style="height: 400px;"></div>
                                    <textarea name="description" id="description_content"
                                        class="d-none">{{ $products->description }}</textarea>
                                        @error('description')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                                </div>


                            </div>
                            <div class="col-lg-5">
                                <div class="mb-3">
                                    <label for="categories_id">Danh mục </label>
                                    <select name="categories_id" id="categories_id" class="form-select" required>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $products->categories_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-10 d-flex gap-2">
                                    <label class="form-label">Trạng thái</label>
                                    <div class="form-check">
                                        <input class="form-check-input mx-1" type="radio" name="is_show"
                                            id="gridRadios1" value="1"
                                            {{ old('is_show', $products->iS_show) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="gridRadios1">Hiển thị</label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input mx-1" type="radio" name="is_show"
                                            id="gridRadios2" value="0"
                                            {{ old('is_show', $products->iS_show) == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="gridRadios2">Ẩn</label>
                                    </div>
                                </div>
                                <div class="form-switch mb-2 d-flex gap-2">
                                    <label class="form-label start">Tùy chỉnh</label>
                                    <div class="form-check">
                                        <input class="form-check-input mx-1" type="checkbox" name="is_new" id="is_new"
                                            value="1" {{ old('iS_new', $products->iS_new) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_new">New</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input mx-1" type="checkbox" name="is_hot" id="is_hot"
                                            value="1" {{ old('iS_hot', $products->iS_hot) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_hot">Hot</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="avata">Hình ảnh sản phẩm <span class="required text-danger">*</span></label>
                                    <input class="form-control mb-3" type="file" name="avata">
                                    <img src="{{ url('storage/'. $products->avata) }}" alt="Hình ảnh sản phẩm"
                                        style="width: 80px; height: auto;">
                                </div>

                                <div class="mb-3">
                                    <label for="images">Hình ảnh phụ <span class="required text-danger">*</span></label>
                                    <input class="form-control mb-3" type="file" name="images[]" id="images" multiple>

                                    <h4 class="collapse-button" data-bs-toggle="collapse"
                                        data-bs-target="#additionalImages" aria-expanded="false"
                                        aria-controls="additionalImages">
                                        Xem thêm
                                    </h4>
                                    <div class="mt-2 collapse" id="additionalImages">
                                        @foreach($products->productImages as $image)
                                        <div class="product-images mt-3"
                                            style="display: inline-block; position: relative; margin: 5px;">
                                            <img src="{{ url('storage/'. $image->image_path) }}" alt="Hình ảnh phụ"
                                                style="width: 100px; height: 100px;">
                                            <button type="button"
                                                class="btn-close position-absolute top-0 start-100 translate-middle"
                                                aria-label="Close" style="color: red;"
                                                data-image-id="{{ $image->id }}"></button>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <input type="hidden" name="deleted_images" id="deletedImages">
                                <div class="button-group">
                                    <label for="sizes">Chọn kích thước <span class="required text-danger">*</span></label>
                                    <div class="options" id="sizes">
                                        @foreach($sizes as $size)
                                        <button type="button" class="option-button"
                                            data-value="{{ $size->size_id }}">{{ $size->value }}</button>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="button-group">
                                    <label for="colors">Chọn màu sắc <span class="required text-danger">*</span></label>
                                    <div class="options" id="colors">
                                        @foreach($colors as $color)
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
                            <div>
                                @foreach($variants as $variant)
                                <div class="card border">
                                    <h4 class="mt-3 mx-3">Biến thể (Kích thước: {{ $variant->size->value }}, Màu:
                                        {{ $variant->color->value }})</h4>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-lg-1 mx-4">
                                                <div id="variant-preview-container_${size.id}_${color.id}"
                                                    class="mt-2 pl-3"></div>
                                            </div>
                                            <input type="hidden" name="variant_ids[]" value="{{ $variant->id }}">
                                            <div class="col-lg-4 mx-5">
                                                <div class="mb-2">
                                                    <label for="">Hình
                                                        ảnh <span class="required text-danger">*</span></label>
                                                    <input type="file" name="variant_images[]" id=""
                                                        class="form-control" accept="image/*">
                                                </div>
                                                <div class="mb-2">
                                                    <label for="">Số
                                                        lượng <span class="required text-danger">*</span></label>
                                                    <input type="number" name="quantities[]" class="form-control"
                                                        value="{{ $variant->quantity }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 mx-3 ">
                                                <div class="mb-2">
                                                    <label for="">Giá <span class="required text-danger">*</span></label>
                                                    <input type="number" name="prices[]" id="" class="form-control"
                                                        value="{{ $variant->price }}">
                                                </div>
                                                <div class="mb-2">
                                                    <label for="">Giá
                                                        khuyến mãi <span class="required text-danger">*</span></label>
                                                    <input type="number" name="discount_prices[]" id=""
                                                        class="form-control" value="{{ $variant->discount_price }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <hr>
                                @endforeach
                            </div>
                            <div id="variants-container">

                            </div>

                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary">Lưu sản phẩm</button>
                            </div>
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
<script src="{{ asset('assets/admin/libs/quill/quill.core.js')}}"></script>
<script src="{{ asset('assets/admin/libs/quill/quill.min.js')}}"></script>


<script>
document.getElementById('images').addEventListener('change', function(event) {
    const previewContainer = document.getElementById('preview-container');
    previewContainer.innerHTML = ''; // Clear previous content

    const files = Array.from(event.target.files);

    // Create preview for selected files
    files.forEach((file, index) => {
        const fileReader = new FileReader();
        fileReader.onload = function(e) {
            const imageWrapper = document.createElement('div');
            imageWrapper.classList.add('position-relative', 'me-2', 'mb-2');
            imageWrapper.style.width = '70px';
            imageWrapper.style.height = '70px';

            imageWrapper.innerHTML = `
                <img src="${e.target.result}" alt="Preview" class="img-thumbnail" style="width: 100%; height: 100%; object-fit: cover;">
                <button type="button" class="btn-close position-absolute top-0 start-100 translate-middle" aria-label="Close" data-index="${index}"></button>
            `;

            previewContainer.appendChild(imageWrapper);
        };
        fileReader.readAsDataURL(file);
    });

    // Handle remove image button click for newly uploaded images
    previewContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-close')) {
            const index = parseInt(e.target.getAttribute('data-index'));
            const dt = new DataTransfer();

            files.forEach((file, i) => {
                if (i !== index) {
                    dt.items.add(file); // Keep files that are not removed
                }
            });

            event.target.files = dt.files; // Update file list of the input
            e.target.parentElement.remove(); // Remove the image element from preview
        }
    });
});

// Handle removal of old image through API or form submission
// Xử lý xóa hình ảnh cũ
document.querySelectorAll('.btn-close').forEach(button => {
    button.addEventListener('click', function(e) {
        const imageId = e.target.getAttribute('data-image-id');
        const deletedImagesInput = document.getElementById('deletedImages');

        // Thêm ID hình ảnh bị xóa vào trường deleted_images
        let deletedImages = deletedImagesInput.value ? deletedImagesInput.value.split(',') : [];
        deletedImages.push(imageId);
        deletedImagesInput.value = deletedImages.join(',');

        // Xóa hình ảnh khỏi giao diện
        e.target.closest('.product-images').remove();

        // Gửi yêu cầu xóa ảnh qua API (ví dụ dùng fetch) nếu cần
        if (imageId) {
            fetch(`/api/delete-image/${imageId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        alert('Có lỗi xảy ra khi xóa ảnh!');
                    }
                })
                .catch(error => {
                    alert('Có lỗi xảy ra khi xóa ảnh!');
                });
        }
    });
});
</script>

<script>
// Quill Editor Setup for product description
document.addEventListener('DOMContentLoaded', function() {
    var quill = new Quill("#quill-editor", {
        theme: "snow",
    });
    var old_content = `{!! $products->description !!}`;
    quill.root.innerHTML = old_content;

    quill.on('text-change', function() {
        var html = quill.root.innerHTML;
        document.getElementById('description_content').value = html;
    });
});

// Slug Generator
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

// Handle Size and Color Selection
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

// Generate Variants for selected sizes and colors
document.getElementById('generate-variants').addEventListener('click', function() {
    const selectedSizeButtons = document.querySelectorAll('#sizes .option-button.selected');
    const selectedColorButtons = document.querySelectorAll('#colors .option-button.selected');

    if (selectedSizeButtons.length === 0 || selectedColorButtons.length === 0) {
        alert('Please select at least one size and one color.');
        return;
    }

    const container = document.getElementById('variants-container');
    container.innerHTML = ''; // Clear existing variants

    const existingVariantsSet = new Set(
        <?php echo json_encode(array_map(function($variant) {
            return $variant['size_id'] . '_' . $variant['color_id'];
        }, $existingVariants)); ?>
    );

    const fragment = document.createDocumentFragment();

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

            const variantKey = `${size.id}_${color.id}`;

            if (!existingVariantsSet.has(variantKey)) {
                const variantForm = document.createElement('div');
                variantForm.innerHTML = `
                    <div class="card border">
                        <h4 class="mt-3 mx-3">Variant (Size: ${size.value}, Color: ${color.value})</h4>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-lg-1 mx-4">
                                    <div id="variant-preview-container_${size.id}_${color.id}" class="mt-2 pl-3"></div>
                                </div>
                                <div class="col-lg-4 mx-5">
                                    <div class="mb-2">
                                        <label for="variant_image_${size.id}_${color.id}">Ảnh <span class="required text-danger">*</span></label>
                                        <input type="file" name="variant_image[${size.id}][${color.id}]" id="variant_image_${size.id}_${color.id}" class="form-control" accept="image/*" required>
                                    </div>
                                    <div class="mb-2">
                                        <label for="variant_quantity_${size.id}_${color.id}">Số lượng <span class="required text-danger">*</span></label>
                                        <input type="number" name="variant_quantity[${size.id}][${color.id}]" id="variant_quantity_${size.id}_${color.id}" class="form-control" min="1" required>
                                    </div>
                                </div>
                                <div class="col-lg-4 mx-3 ">
                                    <div class="mb-2">
                                        <label for="variant_price_${size.id}_${color.id}">Giá <span class="required text-danger">*</span></label>
                                        <input type="number" name="variant_price[${size.id}][${color.id}]" id="variant_price_${size.id}_${color.id}" class="form-control" min="1" required>
                                    </div>
                                    <div class="mb-2">
                                        <label for="variant_discount_price_${size.id}_${color.id}">Giá khuyến mãi <span class="required text-danger">*</span></label>
                                        <input type="number" name="variant_discount_price[${size.id}][${color.id}]" id="variant_discount_price_${size.id}_${color.id}" class="form-control" min="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                `;
                fragment.appendChild(variantForm);
            }
        });
    });

    container.appendChild(fragment);
});

// Collapse Button Logic
document.addEventListener('DOMContentLoaded', function() {
    const collapseButton = document.querySelector('.collapse-button');
    collapseButton.addEventListener('click', () => {
        collapseButton.classList.toggle('active');
    });
});
</script>
@endsection