@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Gán Ca Làm Việc Cho {{ $user->name }}</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Hiển thị danh sách ca làm việc đã được gán -->
    <h3>Danh sách ca đã được gán:</h3>
    <ul>
        @forelse ($assignedShifts as $shift)
            <li>{{ $shift->name }} ({{ $shift->start_time }} - {{ $shift->end_time }}) - Ngày áp dụng: {{ $shift->pivot->assigned_date }}</li>
        @empty
            <li>Chưa có ca làm việc nào được gán.</li>
        @endforelse
    </ul>

    <!-- Form gán ca làm việc -->
    <form action="{{ route('user.assign-shift', $user->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="shift_id">Chọn Ca Làm Việc:</label>
            <select name="shift_id" id="shift_id" class="form-control">
                @foreach ($shifts as $shift)
                    <option value="{{ $shift->id }}">{{ $shift->name }} ({{ $shift->start_time }} - {{ $shift->end_time }})</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mt-3">
            <label for="assigned_date">Ngày Áp Dụng:</label>
            <input type="date" name="assigned_date" class="form-control" placeholder="Chọn ngày áp dụng">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Gán Ca</button>
    </form>
</div>
@endsection
