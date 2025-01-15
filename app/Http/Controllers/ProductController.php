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
        $query = $products = Product::where('iS_show', 1)
            ->whereHas('categories', function ($query) {
                $query->where('status', 1); // Lọc danh mục có trạng thái là "hiện"
            });
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
        $attributes = Attribute::with('values')
        ->where('name', 'Màu sắc') // Giả sử thuộc tính màu sắc có tên là "Màu sắc"
        ->first();

        // Lấy tất cả danh mục
        $categories = Categories::where('status', 1)->get();

        // Phân trang sản phẩm
        $products = $query->paginate($limit);

        // Trả về view với danh sách sản phẩm và danh mục
        return view('user.sanpham.shop_sidebar', compact('products', 'categories', 'attributes'));
    }

    public function show($slug)
    {
        // Comment

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
        $comments = $product->productComments()
            ->where('is_hidden', 0)
            ->orderByDesc('created_at')
            ->get();
        $hasPurchased = true;
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

        return view('user.sanpham.product_detail', compact('product', 'products', 'variants', 'attributes', 'comments'));
    }

    public function filterProducts(Request $request)
    {
        // Debug request nhận được
        \Log::info('Filter Request:', $request->all());
    
        $query = Product::with(['categories'])->select([
            'id', 
            'name', 
            'slug', 
            'avata', 
            'price', 
            'discount_price', 
            'short_description',
            'categories_id'
        ]);
        
        if ($request->has('category') && $request->category) {
            $query->where('categories_id', $request->category);
        }
        if ($request->has('prices') && is_array($request->prices)) {
            $query->where(function ($q) use ($request) {
                foreach ($request->prices as $priceRange) {
                    [$min, $max] = explode('-', $priceRange);
                    $q->orWhereBetween('price', [(float)$min, (float)$max]);
                }
            });
        }
        if ($request->has('keyword') && $request->keyword) {
            $query->where('name', 'LIKE', '%' . $request->keyword . '%');
        }
    
        if ($request->has('colors') && is_array($request->colors)) {
            $query->whereHas('variants.attributes.attributeValue', function ($q) use ($request) {
                $q->whereIn('value', $request->colors);
            });
        }
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                default:
                    break;
            }
        }
    
        // Phân trang
        $limit = $request->get('limit', 12);
        $products = $query->paginate($limit);
    
        // Debug response trả về
        \Log::info('Filter Response:', $products->toArray());
    
        return response()->json([
            'products' => [
                'data' => $products->items(),
                'links' => $products->links()->toHtml(),
            ],
        ]);
    }
    


}

