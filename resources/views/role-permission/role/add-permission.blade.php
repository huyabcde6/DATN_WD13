@extends('layouts.admin')

@section('title')
Quản lý Vai trò & Quyền
@endsection

@section('content')
    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}
        </div>
    @endif

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">

                @if (session('status'))
                    <div class="alert alert-success">{{session('status')}}</div>

                @endif
                <div class="card">
                    <div class="card-header">
                        <h4>
                            Vai trò : {{ $role->name }}
                            <a href="{{ url('roles') }}" class="btn btn-danger float-end ">Quay lại</a>
                        </h4>
                    </div>
                    <div class="card-body">

                        <form action="{{ url('roles/' . $role->id . '/give-permission') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                @error('permission')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <label for="">Permission </label>
                                <div class="row">
                                    @foreach ($permission as $permission)
                                        <div class="col-md-2">
                                            <label>
                                                <input
                                                    type="checkbox"
                                                    name="permission[]"
                                                    value="{{ $permission->name }}"
                                                    {{ in_array($permission->id, $rolePermissions) ? 'checked':'' }}

                                                />
                                                {{$permission->name}}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
