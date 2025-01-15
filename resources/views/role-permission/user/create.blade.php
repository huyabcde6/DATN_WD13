@extends('layouts.admin')
@section('content')

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            Thêm mới tài khoản
                            <a href="{{ url('userAdmin') }}" class="btn btn-danger float-end ">Quay lại</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{url('userAdmin')}}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="">Tên tài khoản</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control" />
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for=""> Email</label>
                                <input type="text" name="email" value="{{ old('email') }}" class="form-control" />
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="">Mật khẩu</label>
                                <input type="text" name="password" value="{{ old('password') }}" class="form-control" />
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for=""> Vai trò</label>
                                <select name="roles[]" class="form-control" multiple>
                                    
                                    @foreach ($roles as $role )
                                    <option @selected(in_array($role, old('roles', []))) value="{{ $role }}">{{ $role }}</option>
                                    @endforeach
                                </select>
                                @error('roles')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection