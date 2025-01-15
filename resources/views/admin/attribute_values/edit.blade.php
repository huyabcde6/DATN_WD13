@extends('layouts.admin')

@section('title', 'Chỉnh Sửa Giá Trị')

@section('content')
<div class="container mt-5">
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Chỉnh Sửa Giá Trị</h4>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('admin.attribute_values.update', $attributeValue) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Thuộc tính -->
                    <div class="col-md-6 mb-3">
                        <label for="attribute_id" class="form-label">Thuộc Tính</label>
                        <select name="attribute_id" id="attribute_id" class="form-select @error('attribute_id') is-invalid @enderror" required>
                            @foreach ($attributes as $attribute)
                                <option value="{{ $attribute->id }}" {{ $attributeValue->attribute_id == $attribute->id ? 'selected' : '' }}>
                                    {{ $attribute->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('attribute_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Giá trị -->
                    <div class="col-md-6 mb-3">
                        <label for="value" class="form-label">Giá Trị<span class="text-danger">*</span>:</label>
                        <input type="text" name="value" id="value" class="form-control @error('value') is-invalid @enderror" value="{{ $attributeValue->value }}" required>
                        @error('value')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Mã màu -->
                    <div class="col-md-6 mb-3" id="color_code_group" style="display: none;">
                        <label for="color_code" class="form-label">Mã Màu</label>
                        <input type="text" name="color_code" id="color_code" class="form-control @error('color_code') is-invalid @enderror" value="{{ $attributeValue->color_code }}">
                        @error('color_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Nút hành động -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.attribute_values.index') }}" class="btn btn-secondary">Quay Lại</a>
                    <button type="submit" class="btn btn-primary">Cập Nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const attributeSelect = document.getElementById('attribute_id');
        const colorCodeGroup = document.getElementById('color_code_group');

        // Hàm kiểm tra và hiển thị/ẩn trường "Mã Màu"
        const toggleColorCodeField = () => {
            const selectedOption = attributeSelect.options[attributeSelect.selectedIndex];
            const attributeName = selectedOption.text.toLowerCase();

            if (attributeName.includes('màu sắc')) {
                colorCodeGroup.style.display = 'block';
            } else {
                colorCodeGroup.style.display = 'none';
            }
        };

        // Kiểm tra khi tải trang
        toggleColorCodeField();

        // Lắng nghe sự kiện thay đổi giá trị dropdown
        attributeSelect.addEventListener('change', toggleColorCodeField);
    });
</script>
@endsection
