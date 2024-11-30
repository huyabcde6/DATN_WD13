<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\products;
use App\Models\categories;
use App\Models\Color;
use App\Models\Order;
use App\Models\productComment;
use App\Models\Size;
use App\Models\ProductDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $products = products::with('categories')->get();
        $colors = Color::all();

        return view('user.sanpham.shop_sidebar', compact('products', 'colors'));
    }
    public function show($slug)
    {
        $product = products::with(['productDetails.color', 'productDetails.size', 'categories'])->where('slug', $slug)->firstOrFail();
        $products = products::with('categories')->get();
        $sizes = $product->productDetails->unique('size_id')->map(function ($detail) {
            return $detail->size;
        });

        $colors = $product->productDetails->unique('color_id')->map(function ($detail) {
            return $detail->color;
        });
        $productDetails = $product->productDetails;

        // Comment
        $comments = $product->productComments()->orderByDesc('created_at')->paginate(3);

        $hasPurchased = true;

        if (Auth::check()) {
            $hasPurchased = Order::where('user_id', auth()->id())
                ->whereHas('orderDetails', function ($query) use ($product) {
                    $query->where('product_detail_id', $product->id);
                })
                ->where('payment_status', 'pending') // Sửa điều kiện ở đây
                ->exists();
        }

        return view('user.sanpham.product_detail', compact('products', 'product', 'sizes', 'colors', 'productDetails', 'hasPurchased', 'comments'));
    }

    public function locMau(Request $request)
    {
        $colorID = $request->color_id;
        $products = products::with(['categories', 'productDetails.color'])
        ->whereHas('productDetails.color', function ($query) use ($colorID) {
            $query->where('color_id', $colorID);
        })
        ->get();
        $colors = Color::all();

            return view('user.sanpham.shop_sidebar', compact( 'products', 'colors'));
    }
}
