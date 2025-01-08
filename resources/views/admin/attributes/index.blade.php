@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Attributes</h1>
    <a href="{{ route('admin.attributes.create') }}" class="btn btn-primary mb-3">Create New Attribute</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attributes as $attribute)
                <tr>
                    <td>{{ $attribute->id }}</td>
                    <td>{{ $attribute->name }}</td>
                    <td>{{ $attribute->slug }}</td>
                    <td>
                        <a href="{{ route('admin.attributes.edit', $attribute) }}" class="btn btn-warning btn-sm">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
