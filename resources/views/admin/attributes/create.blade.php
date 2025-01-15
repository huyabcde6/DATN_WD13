@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Thêm mới thuộc tính</h4>
        </div>
    </div>
    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('admin.attributes.store') }}" method="POST">
                @csrf

                <div class="row">
                    <!-- Tên thuộc tính -->
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Tên Thuộc Tính <span class="text-danger">*</span>:</label>
                        <input type="text" name="name" id="name" placeholder="Nhập tên thuộc tính" class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div class="col-md-6 mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" name="slug" id="slug" class="form-control" readonly>
                    </div>
                </div>

                <!-- Nút hành động -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.attributes.index') }}" class="btn btn-secondary">Quay Lại</a>
                    <button type="submit" class="btn btn-primary">Lưu Thuộc Tính</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
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
@endsection
