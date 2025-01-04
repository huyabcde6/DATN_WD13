@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Create Attribute Value</h1>

    <form action="{{ route('admin.attribute_values.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="attribute_id">Attribute</label>
            <select name="attribute_id" id="attribute_id" class="form-control" required>
                @foreach ($attributes as $attribute)
                    <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="value">Value</label>
            <input type="text" name="value" id="value" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="color_code">Color Code</label>
            <input type="text" name="color_code" id="color_code" class="form-control" placeholder="#FF0000">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Create</button>
    </form>
</div>
@endsection
