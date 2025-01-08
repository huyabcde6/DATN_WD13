@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Edit Attribute Value</h1>

    <form action="{{ route('admin.attribute_values.update', $attributeValue) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="attribute_id">Attribute</label>
            <select name="attribute_id" id="attribute_id" class="form-control" required>
                @foreach ($attributes as $attribute)
                    <option value="{{ $attribute->id }}" {{ $attributeValue->attribute_id == $attribute->id ? 'selected' : '' }}>
                        {{ $attribute->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="value">Value</label>
            <input type="text" name="value" id="value" class="form-control" value="{{ $attributeValue->value }}" required>
        </div>

        <div class="form-group">
            <label for="color_code">Color Code</label>
            <input type="text" name="color_code" id="color_code" class="form-control" value="{{ $attributeValue->color_code }}">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Update</button>
    </form>
</div>
@endsection
