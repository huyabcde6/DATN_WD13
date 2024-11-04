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
                            <div class="col-lg-5">
                                <div class="mb-3">
                                    <label for="name">Tên sản phẩm</label>
                                    <input type="text" name="name" class="form-control" value="{{ $products->name }}"
                                        placeholder="Tên sản phẩm" id="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input type="text" name="slug" class="form-control" placeholder="Slug" id="slug"
                                        value="{{ $products->slug }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="price">Giá sản phẩm</label>
                                    <input type="number" name="price" id="price" value="{{ $products->price }}"
                                        class="form-control" placeholder="Giá sản phẩm" required>
                                </div>
                                <div class="mb-3">
                                    <label for="discount_price">Giá khuyến mãi</label>
                                    <input type="number" name="discount_price" value="{{ $products->discount_price }}"
                                        id="discount_price" class="form-control" placeholder="Giá khuyến mãi" required>
                                </div>
                                <div class="mb-3">
                                    <label for="stock_quantity">Số lượng hàng</label>
                                    <input type="number" name="stock_quantity" value="{{ $products->stock_quantity }}"
                                        id="stock_quantity" class="form-control" placeholder="Số lượng tồn kho"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="short_description">Mô tả ngắn</label>
                                    <textarea name="short_description" id="short_description" class="form-control"
                                        placeholder="Mô tả ngắn của sản phẩm"
                                        required>{{ $products->short_description }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="categories_id">Danh mục</label>
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
                                        <input class="form-check-input" type="radio" name="is_show" id="gridRadios1"
                                            value="1" {{ $products->is_show == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="gridRadios1">Hiển thị</label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="is_show" id="gridRadios2"
                                            value="0" {{ $products->is_show == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="gridRadios2">Ẩn</label>
                                    </div>
                                </div>
                                <label class="form-label">Tùy chỉnh</label>
                                <div class="form-switch mb-2 d-flex justify-content-evenly ps-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_new" id="is_new"
                                            {{ $products->is_new == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_new">New</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_hot" id="is_hot"
                                            {{ $products->is_hot == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_hot">Hot</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Mô tả chi tiết sản phẩm</label>
                                    <div id="quill-editor" style="height: 400px;"></div>
                                    <textarea name="description" id="description_content"
                                        class="d-none">{{ $products->description }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="avata">Hình ảnh sản phẩm</label>
                                    <input class="form-control mb-3" type="file" name="avata" id="avata">
                                    <img src="{{ url('storage/'. $products->avata) }}" alt="Hình ảnh sản phẩm"
                                        style="width: 100px; height: auto;">
                                </div>

                                <div class="button-group">
                                    <label for="sizes">Chọn kích thước</label>
                                    <div class="options" id="sizes">
                                        @foreach($sizes as $size)
                                        <button type="button" class="option-button"
                                            data-value="{{ $size->size_id }}">{{ $size->value }}</button>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="button-group">
                                    <label for="colors">Chọn màu sắc</label>
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
                                <h4>Biến thể (Kích thước: {{ $variant->size->value }}, Màu:
                                    {{ $variant->color->value }})</h4>
                                <input type="hidden" name="variant_ids[]" value="{{ $variant->id }}">
                                <div>
                                    <label for="">Số
                                        lượng</label>
                                    <input type="number" name="quantities[]" class="form-control"
                                        value="{{ $variant->quantity }}">
                                </div>
                                <div>
                                    <label for="">Giá</label>
                                    <input type="number" name="prices[]" id="" class="form-control"
                                        value="{{ $variant->price }}">
                                </div>
                                <div>
                                    <label for="">Giá
                                        khuyến mãi</label>
                                    <input type="number" name="discount_prices[]" id="" class="form-control"
                                        value="{{ $variant->discount_price }}">
                                </div>
                                <div>
                                    <label for="">Hình
                                        ảnh</label>
                                    <input type="file" name="variant_images[]" id="" class="form-control"
                                        accept="image/*">
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

    // Tạo một tập hợp biến thể đã tồn tại để kiểm tra
    const existingVariantsSet = new Set(
        <?php echo json_encode(array_map(function($variant) {
            return $variant['size_id'] . '_' . $variant['color_id']; // Tạo chuỗi duy nhất cho từng biến thể
        }, $existingVariants)); ?>
    );

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

            // Tạo chuỗi duy nhất cho biến thể
            const variantKey = `${size.id}_${color.id}`;

            // Kiểm tra xem biến thể đã tồn tại hay chưa
            if (!existingVariantsSet.has(variantKey)) {
                const variantForm = document.createElement('div');
                variantForm.innerHTML = `
                    <h4>Biến thể (Kích thước: ${size.value}, Màu: ${color.value})</h4>
                        <div>
                            <label for="variant_quantity_${size.id}_${color.id}">Số lượng</label>
                            <input type="number" name="variant_quantity[${size.id}][${color.id}]" id="variant_quantity_${size.id}_${color.id}" class="form-control" required>
                        </div>
                        <div>
                            <label for="variant_price_${size.id}_${color.id}">Giá</label>
                            <input type="number" name="variant_price[${size.id}][${color.id}]" id="variant_price_${size.id}_${color.id}" class="form-control" required>
                        </div>
                        <div>
                            <label for="variant_discount_price_${size.id}_${color.id}">Giá khuyến mãi</label>
                            <input type="number" name="variant_discount_price[${size.id}][${color.id}]" id="variant_discount_price_${size.id}_${color.id}" class="form-control" required>
                        </div>
                        <div>
                            <label for="variant_image_${size.id}_${color.id}">Hình ảnh</label>
                            <input type="file" name="variant_image[${size.id}][${color.id}]" id="variant_image_${size.id}_${color.id}" class="form-control" accept="image/*" required>
                        </div>
                        <hr>
                `;
                container.appendChild(variantForm);
            }
        });
    });
});
</script>
@endsection