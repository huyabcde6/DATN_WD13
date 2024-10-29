@extends('admin.layouts.app')

@section('content')
    <h1>{{ isset($news) ? 'Edit News' : 'Create News' }}</h1>
    
    <form action="{{ isset($news) ? route('admin.news.update', $news) : route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($news))
            @method('PUT')
        @endif
        
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $news->title ?? old('title') }}" required>
        </div>
        
        <div class="form-group">
            <label for="content">Content</label>
            <textarea class="form-control" id="content" name="content" rows="5" required>{{ $news->content ?? old('content') }}</textarea>
        </div>
        
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" class="form-control-file" id="image" name="image">
        </div>
        
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="is_published" name="is_published" {{ (isset($news) && $news->is_published) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_published">Publish</label>
        </div>
        
        <button type="submit" class="btn btn-primary">{{ isset($news) ? 'Update' : 'Create' }}</button>
    </form>
@endsection