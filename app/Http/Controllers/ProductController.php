<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\products;
use App\Models\categories;
use App\Models\Color;
use App\Models\Size;


class ProductController extends Controller
{
    public function index()
    {
        $products = products::with('categories')->get();
        return view('user.sanpham.shop_sidebar', compact('products'));
    }
    public function show($id)
    {
        $product = products::with(['productDetails.color', 'productDetails.size', 'categories'])->findOrFail($id);
        $sizes = Size::all();
        $colors = Color::all();
        
        return view('user.sanpham.product_detail', compact('product', 'sizes', 'colors'));
    }

}
