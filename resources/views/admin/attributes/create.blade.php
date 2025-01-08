@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Create Attribute</h1>

    <form action="{{ route('admin.attributes.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="slug">Slug</label>
            <input type="text" name="slug" id="slug" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Create</button>
    </form>
</div>
@endsection
@section('js')
<script src="{{ asset('assets/admin/libs/quill/quill.core.js')}}"></script>
<script src="{{ asset('assets/admin/libs/quill/quill.min.js')}}"></script>
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