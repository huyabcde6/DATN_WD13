@extends('layouts.home')

@section('content')
<div class="breadcrumb-area bg-light">
    <div class="container-fluid">
        <div class="breadcrumb-content text-center">
            <h1 class="title">Tìm Kiếm</h1>
            <ul>
                <li>
                    <a href="index.html">Trang chủ </a>
                </li>
                <li class="active">Tìm Kiếm</li>
            </ul>
            
        </div>
    </div>
</div>
@if($products->isEmpty())
    <p>No products found.</p>
@else
    <div class="row shop_wrapper grid_3">
        @foreach($products as $product)
        <div class="col-lg-4 col-md-4 col-sm-6 product" data-aos="fade-up" data-aos-delay="200">
            <div class="product-inner">
                <div class="thumb">
                    <a href="{{ route('product.show', $product->slug) }}" class="image">
                        <img class="image" src="{{ url('storage/'. $product->avata) }}" alt="Product" width="auto" height="auto" />
                    </a>
                    <div class="actions">
                        <a href="wishlist.html" title="Wishlist" class="action wishlist"><i class="pe-7s-like"></i></a>
                        <a href="#" title="Quickview" class="action quickview" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"><i class="pe-7s-search"></i></a>
                        <a href="compare.html" title="Compare" class="action compare"><i class="pe-7s-shuffle"></i></a>
                    </div>
                </div>
                <div class="content">
                    <h4 class="sub-title">{{ $product->categories->name }}</h4>
                    <h5 class="title"><a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a></h5>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce posuere metus vitae arcu imperdiet, id aliquet ante scelerisque. Sed sit amet sem vitae urna fringilla tempus.</p>
                    <span class="price">
                        @if ($product->discount_price)
                        <span class="new">{{ number_format($product->discount_price, 0, '', '.') }} ₫</span>&nbsp;&nbsp;
                        <span class="old">{{ number_format($product->price, 0, '', '.') }} ₫</span>
                        @else
                        <span class="new">{{ number_format($product->price, 0, '', '.') }} ₫</span>
                        @endif
                    </span>

                    <div class="shop-list-btn">
                        <a title="Wishlist" href="#" class="btn btn-sm btn-outline-dark btn-hover-primary wishlist"><i class="fa fa-heart"></i></a>
                        <a href="{{ route('product.show', $product->slug) }}" class="btn btn-sm btn-outline-dark btn-hover-primary" title="Add To Cart"><i class="mdi mdi-eye text-muted fs-7 "></i> Xem chi tiết</a>
                        <a title="Compare" href="#" class="btn btn-sm btn-outline-dark btn-hover-primary compare"><i class="fa fa-random"></i></a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif
@endsection