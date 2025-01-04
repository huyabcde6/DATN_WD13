@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Attribute Values</h1>
    <a href="{{ route('admin.attribute_values.create') }}" class="btn btn-primary mb-3">Create New Attribute Value</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Attribute</th>
                <th>Value</th>
                <th>Color Code</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attributeValues as $attributeValue)
                <tr>
                    <td>{{ $attributeValue->id }}</td>
                    <td>{{ $attributeValue->attribute->name }}</td>
                    <td>{{ $attributeValue->value }}</td>
                    <td>{{ $attributeValue->color_code }}</td>
                    <td>
                        <a href="{{ route('admin.attribute_values.edit', $attributeValue) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.attribute_values.destroy', $attributeValue) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
