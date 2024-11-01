<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\products;

class ProductController extends Controller
{
    public function index()
    {
        $products = products::with('categories')->paginate(10);
        return view('admin.products.index', compact('products'));
    }
}
