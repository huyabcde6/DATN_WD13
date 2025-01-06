<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;
use App\Models\Attribute;
use App\Models\ProductVariantAttribute;
use App\Models\ProductVariant;
use App\Models\AttributeValue;
use App\Models\categories;

use App\Models\Order;
use App\Models\productComment;
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

        $minPrice = $request->input('min_price', 0);
        $maxPrice = $request->input('max_price', 1000000);
        $keyword = $request->input('keyword');
        
        // Truy vấn sản phẩm
        $query = product::query();
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
        $categories = Categories::where('status', 1)->get();

        // Phân trang sản phẩm
        $products = $query->paginate($limit);

        // Trả về view với danh sách sản phẩm và danh mục
        return view('user.sanpham.shop_sidebar', compact('products', 'categories'));
    }

    public function show($slug)
{
    // Lấy sản phẩm với các quan hệ liên quan
    $product = Product::with([
        'productImages',
        'variants.attributes.attributeValue',
        'categories',
    ])->where('slug', $slug)->firstOrFail();

    $attributeValues = [];

    // Thu thập giá trị attribute_value_id
    foreach ($product->variants as $variant) {
        foreach ($variant->attributes as $attribute) {
            $attributeValues[] = $attribute->attribute_value_id;
        }
    }

    // Lấy chi tiết attribute values
    $attributeDetails = AttributeValue::whereIn('id', $attributeValues)->get();
    $attributes = [];

    foreach ($attributeDetails as $attributeDetail) {
        $attribute = $attributeDetail->attribute;
        if (!in_array($attribute, $attributes)) {
            $attributes[] = $attribute;
        }
    }

    // Thu thập biến thể sản phẩm
    $variants = $product->variants->map(function ($variant) {
        return [
            'variant_id' => $variant->id,
            'product_code' => $variant->product_code,
            'price' => $variant->price,
            'image' => $variant->image,
            'stock_quantity' => $variant->stock_quantity,
            'attributes' => $variant->attributes->map(function ($attribute) {
                return [
                    'attribute_id' => $attribute->id,
                    'attribute_name' => $attribute->attributeValue->attribute->name ?? null,
                    'attribute_slug' => $attribute->attributeValue->attribute->slug ?? null,
                    'attribute_value_id' => $attribute->attribute_value_id ?? null,
                    'attribute_value_value' => $attribute->attributeValue->value ?? null,
                    'attribute_value_color_code' => $attribute->attributeValue->color_code ?? null,
                ];
            }),
        ];
    });
    $products = Product::with('categories')->get();
    // Trả về view

    return view('user.sanpham.product_detail', compact('product', 'products', 'variants', 'attributes'));
}

}