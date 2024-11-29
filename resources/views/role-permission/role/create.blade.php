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
                <div class="card">
                    <div class="card-header">
                        <h4>
                            Create Roles
                            <a href="{{ url('roles') }}" class="btn btn-danger float-end ">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{url('roles')}}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="">Roles Name</label>
                                <input type="text" name="name" class="form-control" />
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
