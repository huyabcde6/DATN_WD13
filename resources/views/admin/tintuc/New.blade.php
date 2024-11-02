@extends('layouts.admin')

@section('title')
Danh sách Tin Tức
@endsection
@section('css')
<style>
    /* From Uiverse.io by victoryamaykin */
    .switch {
        position: relative;
        display: inline-block;
        width: 120px;
        height: 34px;
    }

    .switch input {
        display: none;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #3C3C3C;
        -webkit-transition: .4s;
        transition: .4s;
        border-radius: 34px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked+.slider {
        background-color: #0E6EB8;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(85px);
    }

    /*------ ADDED CSS ---------*/
    .slider:after {
        content: 'DISABLED';
        color: white;
        display: block;
        position: absolute;
        transform: translate(-50%, -50%);
        top: 50%;
        left: 50%;
        font-size: 10px;
        font-family: Verdana, sans-serif;
    }

    input:checked+.slider:after {
        content: 'ENABLED';
    }

    /*--------- END --------*/
</style>
@endsection

@section('content')
<!-- @if (session()->has('error'))
<div class="alert alert-danger">
    {{ session()->get('error') }}
</div>
@endif
-->
@if (session()->has('success'))
<div class="alert alert-success">
    {{ session()->get('success') }}
</div>
@endif
<div class="d-flex justify-content-center m-3">
    <h2>Danh Sách Tin Tức</h2>
</div>
<a href="addNew"><button type="button" class="btn btn-info bg-5">Thêm mới</button></a>
<div class="row">

    <div class="col-12">
        <div class="card">


            <div class="card-body">
                <table id="scroll-vertical-datatable" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>Tiêu đề</th>
                            <th>Ảnh bìa</th>
                            <th>Mô tả ngắn</th>
                            <th>View</th>
                            <th>Ngày Đăng</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($db as $tiem)
                        <tr>

                            <td>{{$tiem->title}}</td>
                            <td><img src="{{Storage::url($tiem->avata)}}" alt="" width="200px"></td>
                            <td>{{$tiem->description}}</td>
                            <td>{{$tiem->view}}</td>
                            <td>{{$tiem->new_date}}</td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox">
                                    <span class="slider"></span>
                                </label>
                            </td>
                            <td>{{$tiem->title}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection