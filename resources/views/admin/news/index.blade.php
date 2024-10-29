@extends('admin.layouts.app')

@section('content')
    <h1>News List</h1>
    <a href="{{ route('admin.news.create') }}" class="btn btn-primary">Create News</a>
    
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Published</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($news as $item)
                <tr>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->is_published ? 'Yes' : 'No' }}</td>
                    <td>
                        <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('admin.news.destroy', $item) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    {{ $news->links() }}
@endsection