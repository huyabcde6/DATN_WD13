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

    public function index(Request $request)
{
    // Khởi tạo query cho sản phẩm
    $query = products::with(['categories', 'productDetails', 'productImages']);

    // Lọc theo từ khóa tìm kiếm
    if ($request->filled('keyword')) {
        $query->where('name', 'like', "%{$request->keyword}%");

    }

    // Lọc theo danh mục
    if ($request->filled('category')) {
        $query->where('categories_id', $request->category);
    }

    // Lọc theo giá
    if ($request->filled('min_price') && $request->filled('max_price')) {
        $query->whereBetween('price', [(float)$request->min_price, (float)$request->max_price]);
    }

    // Lọc theo màu sắc
    if ($request->filled('colors')) {
        $colors = explode(',', $request->colors); // Chuyển chuỗi thành mảng
        $query->whereHas('productDetails', function ($q) use ($colors) {
            $q->whereIn('color_id', $colors);
        });
    }

    // Lọc theo kích thước
    if ($request->filled('sizes')) {
        $sizes = explode(',', $request->sizes);
        $query->whereHas('productDetails', function ($q) use ($sizes) {
            $q->whereIn('size_id', $sizes);
        });
    }

    // Lấy danh sách sản phẩm sau khi lọc
    $products = $query->paginate(12);

    // Lấy danh mục
    $categories = categories::all();

    // Lấy màu sắc
    $colors = Color::withCount('productDetails')->get();

    // Lấy kích thước
    $sizes = Size::withCount('productDetails')->get();

    // Sản phẩm gần đây
    $recentProducts = products::latest()->take(5)->get();

    // Dữ liệu cho bộ lọc giá
    $priceRange = [
        'min' => products::min('price'),
        'max' => products::max('price'),
    ];

    // Trả dữ liệu sang view
    return view('user.sanpham.shop_sidebar', compact('products', 'categories', 'colors', 'sizes', 'recentProducts', 'priceRange'));
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
