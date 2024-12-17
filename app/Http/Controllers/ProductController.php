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
        // Lấy các tham số từ request
        $sort = $request->input('sort');
        $limit = $request->input('limit', 12);
        $categoryFilter = $request->input('category');
        $colorsFilter = $request->input('colors', []);
        $minPrice = $request->input('min_price', 0);
        $maxPrice = $request->input('max_price', 1000000);
        $keyword = $request->input('keyword');
        
        // Truy vấn sản phẩm
        $query = products::query();
        if ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%');
        }
        // Lọc theo danh mục
        if ($categoryFilter) {
            $query->where('categories_id', $categoryFilter);
        }

        // Lọc theo màu sắc
        if (!empty($colorsFilter)) {
            $query->whereHas('productDetails', function ($query) use ($colorsFilter) {
                $query->whereIn('color_id', $colorsFilter);
            });
        }

        // Lọc theo khoảng giá
        if ($minPrice && $maxPrice) {
            $query->whereBetween('price', [$minPrice, $maxPrice]);
        }

        // Sắp xếp sản phẩm
        switch ($sort) {
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'newest':
                $query->latest();
                break;
            case 'oldest':
                $query->oldest();
                break;
            default:
                $query->orderBy('id', 'asc');
                break;
        }

        // Lấy tất cả danh mục
        $categories = Categories::all();
        $colors = Color::all();
        // Phân trang sản phẩm
        $products = $query->paginate($limit);

        // Trả về view với danh sách sản phẩm và danh mục
        return view('user.sanpham.shop_sidebar', compact('products', 'categories', 'colors'));
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
    // public function search(Request $request)
    // {
    //     $query = products::query();

    //     if ($request->filled('name')) {
    //         $query->where('name', 'like', '%' . $request->input('name') . '%');
    //     }

        

    //     $products = $query->get();

    //     return view('user.khac.index', compact('products'));
    // }
}