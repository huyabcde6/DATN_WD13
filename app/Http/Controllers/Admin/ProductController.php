<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\categories;
use App\Models\products;
use App\Models\Size;
use App\Models\Color;
use App\Models\ProductDetail;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = products::query();

        if ($request->has('sort') && $request->has('order')) {
            $sort = $request->input('sort');
            $order = $request->input('order');
            $query->orderBy($sort, $order);
        } else {
            $query->orderBy('created_at', 'desc'); // Sắp xếp mặc định theo ngày tạo
        }

        // Tìm kiếm theo tên sản phẩm
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Lọc theo danh mục
        if ($request->has('categories_id') && $request->categories_id) {
            $query->where('categories_id', $request->categories_id);
        }

        // Lọc theo ngày
        if ($request->has('from_date') && $request->from_date) {
            $query->where('created_at', '>=', $request->from_date);
        }

        if ($request->has('to_date') && $request->to_date) {
            $query->where('created_at', '<=', $request->to_date);
        }

        $categories = categories::all();
        $products = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.products.index', compact('products', 'categories'));
    }


    public function create()
    {
        $categories = categories::where('status', true)->get();
        $sizes = Size::where('status', true)->get();
        $colors = Color::where('status', true)->get();

        return view('admin.products.create', compact('categories', 'sizes', 'colors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'categories_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lte:price',
            'stock_quantity' => 'required|integer|min:0',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'avata' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'variant_quantity.*.*' => 'required|integer|min:0',
            'variant_price.*.*' => 'nullable|numeric|min:0',
            'variant_discount_price.*.*' => 'nullable|numeric|min:0|lte:variant_price.*.*',
            'variant_image.*.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ],
    [
        'name.required' => 'Tên không được để trống',
        'name.string' => 'Tên phải là chuỗi',
        'name.max' => 'Tên không vượt qua 255 ký tự',
        'slug.string' => 'Slug phải là chuỗi',
        'slug.max' => 'Slug không vượt qua 255 ký tự',
        'categories_id.required' => 'Danh mục không được để trống',
        'categories_id.exists' => 'Danh mục không tồn tại',
        'price.required' => 'Giá không được để trống',
        'price.numeric' => 'Giá phải là số',
        'price.min' => 'Giá phải lớn hơn hoặc bằng 0',
        'discount_price.numeric' => 'Giá khuyến mãi phải là số',
        'discount_price.min' => 'Giá khuyến mãi phải lớn hơn hoặc bằng 0',
        'discount_price.lte' => 'Giá khuyến mãi phải nhỏ hơn hoặc bằng giá gốc',
        'stock_quantity.required' => 'Số lượng không được để trống',
        'stock_quantity.integer' => 'Số lượng phải là số nguyên',
        'stock_quantity.min' => 'Số lượng phải lớn hơn hoặc bằng 0',
        'short_description.string' => 'Mô tả ngắn phải là chuỗi',
        'short_description.max' => 'Mô tả ngắn không vượt qua 500 ký tự',
        'description.string' => 'Mô tả phải là chuỗi',
        'avata.required' => 'Hình ảnh không được để trống',
        'avata.image' => 'Ảnh đại diện phải là hình ảnh',
        'avata.mimes' => 'Ảnh đại diện phải có định dạng jpeg, png, jpg, gif',
        'avata.max' => 'Ảnh đại diện không vượt quá 2MB',
        'images.*.image' => 'Hình ảnh phải là hình ảnh',
        'images.*.mimes' => 'Hình ảnh phải có định dạng jpeg, png, jpg, gif',
        'images.*.max' => 'Hình ảnh không vượt quá 2MB',
        'variant_quantity.*.*.required' => 'Số lượng không được để trống',
        'variant_quantity.*.*.integer' => 'Số lượng phải là số nguyên',
        'variant_quantity.*.*.min' => 'Số lượng phải lớn hơn hoặc bằng 0',
        'variant_price.*.*.numeric' => 'Giá phải là số',
        'variant_price.*.*.min' => 'Giá phải lớn hơn hoặc bằng 0',
        'variant_discount_price.*.*.lte' => 'Giá khuyến mãi phải nhỏ hơn hoặc bằng giá gốc',
        'variant_discount_price.*.*.min' => 'Giá khuyến mãi phải lớn hơn hoặc bằng 0',
        'variant_image.*.*.image' => 'Hình ảnh phải là hình ảnh',
        'variant_image.*.*.mimes' => 'Hình ảnh phải có định dạng jpeg, png, jpg, gif',
        'variant_image.*.*.max' => 'Hình ảnh không vượt quá 2MB',
    ]);

        try {
            // Tìm sản phẩm theo ID
            $product = new products();

            // Cập nhật thông tin sản phẩm
            $product->name = $request->name;
            $product->slug = $request->slug;
            $product->categories_id = $request->categories_id;
            $product->price = $request->price;
            $product->discount_price = $request->discount_price;
            $product->stock_quantity = $request->stock_quantity;
            $product->short_description = $request->short_description;
            $product->description = $request->description;
            $product->is_show = $request->is_show;
            $product->is_new = $request->has('is_new');
            $product->is_hot = $request->has('is_hot');

            // Xử lý ảnh đại diện
            if ($request->hasFile('avata')) {
                $product->avata = $request->file('avata')->store('products', 'public');
            }

            $product->save();

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('product_images', 'public');

                    // Lưu đường dẫn ảnh vào bảng liên kết `ProductImages` (bảng chứa các ảnh phụ)
                    $product->productImages()->create(['image_path' => $imagePath]);
                }
            }


            // Lưu biến thể sản phẩm mới
            if (empty($request->variant_quantity)) {
                return back()->with('error', 'Vui lòng tạo biến thể cho sản phẩm');
            } else {
                foreach ($request->variant_quantity as $sizeId => $colors) {
                    foreach ($colors as $colorId => $quantity) {
                        $variant = new ProductDetail();
                        $variant->product_code = 'SP-' . strtoupper(Str::random(8));
                        $variant->products_id = $product->id;
                        $variant->size_id = $sizeId;
                        $variant->color_id = $colorId;
                        $variant->quantity = $quantity;
                        $variant->price = $request->variant_price[$sizeId][$colorId];
                        $variant->discount_price = $request->variant_discount_price[$sizeId][$colorId];

                        // Xử lý ảnh của biến thể
                        if (isset($request->variant_image[$sizeId][$colorId])) {
                            $variant->image = $request->file("variant_image.$sizeId.$colorId")->store('product_variants', 'public');
                        }

                        $variant->save();
                    }
                }
            }

            return redirect()->route('admin.products.index')->with('success', 'Thêm mới sản phẩm thành công!');
        } catch (\Exception $e) {
            Log::error('Error adding product: ' . $e->getMessage(), [
                'request_data' => $request->all(), // Ghi lại dữ liệu request nếu cần
                'stack_trace' => $e->getTraceAsString() // Ghi lại stack trace
            ]);
            return back()->withErrors(['error' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'slug' => 'nullable|string|max:255',
        'categories_id' => 'required|exists:categories,id',
        'price' => 'required|numeric|min:0',
        'discount_price' => 'nullable|numeric|min:0|lte:price',
        'stock_quantity' => 'required|integer|min:0',
        'short_description' => 'nullable|string|max:500',
        'description' => 'nullable|string',
        'avata' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        'variant_quantity.*.*' => 'required|integer|min:0',
        'variant_price.*.*' => 'nullable|numeric|min:0',
        'variant_discount_price.*.*' => 'nullable|numeric|min:0|lte:variant_price.*.*',
        'variant_image.*.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ],
[
    'name.required' => 'Tên không được để trống',
    'name.string' => 'Tên phải là chuỗi',
    'name.max' => 'Tên không vượt qua 255 ký tự',
    'slug.string' => 'Slug phải là chuỗi',
    'slug.max' => 'Slug không vượt qua 255 ký tự',
    'categories_id.required' => 'Danh mục không được để trống',
    'categories_id.exists' => 'Danh mục không tồn tại',
    'price.required' => 'Giá không được để trống',
    'price.numeric' => 'Giá phải là số',
    'price.min' => 'Giá phải lớn hơn hoặc bằng 0',
    'discount_price.numeric' => 'Giá khuyến mãi phải là số',
    'discount_price.min' => 'Giá khuyến mãi phải lớn hơn hoặc bằng 0',
    'discount_price.lte' => 'Giá khuyến mãi phải nhỏ hơn hoặc bằng giá gốc',
    'stock_quantity.required' => 'Số lượng không được để trống',
    'stock_quantity.integer' => 'Số lượng phải là số nguyên',
    'stock_quantity.min' => 'Số lượng phải lớn hơn hoặc bằng 0',
    'short_description.string' => 'Mô tả ngắn phải là chuỗi',
    'short_description.max' => 'Mô tả ngắn không vượt qua 500 ký tự',
    'description.string' => 'Mô tả phải là chuỗi',
    'avata.image' => 'Ảnh đại diện phải là hình ảnh',
    'avata.mimes' => 'Ảnh đại diện phải có định dạng jpeg, png, jpg, gif',
    'avata.max' => 'Ảnh đại diện không vượt quá 2MB',
    'images.*.image' => 'Hình ảnh phải là hình ảnh',
    'images.*.mimes' => 'Hình ảnh phải có định dạng jpeg, png, jpg, gif',
    'images.*.max' => 'Hình ảnh không vượt quá 2MB',
    'variant_quantity.*.*.required' => 'Số lượng không được để trống',
    'variant_quantity.*.*.integer' => 'Số lượng phải là số nguyên',
    'variant_quantity.*.*.min' => 'Số lượng phải lớn hơn hoặc bằng 0',
    'variant_price.*.*.numeric' => 'Giá phải là số',
    'variant_price.*.*.min' => 'Giá phải lớn hơn hoặc bằng 0',
    'variant_discount_price.*.*.lte' => 'Giá khuyến mãi phải nhỏ hơn hoặc bằng giá gốc',
    'variant_discount_price.*.*.min' => 'Giá khuyến mãi phải lớn hơn hoặc bằng 0',
    'variant_image.*.*.image' => 'Hình ảnh phải là hình ảnh',
    'variant_image.*.*.mimes' => 'Hình ảnh phải có định dạng jpeg, png, jpg, gif',
    'variant_image.*.*.max' => 'Hình ảnh không vượt quá 2MB',
]);
    try {
        // Tìm sản phẩm theo ID
        $product = products::findOrFail($id);

        // Cập nhật thông tin sản phẩm
        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->categories_id = $request->categories_id;
        $product->price = $request->price;
        $product->discount_price = $request->discount_price;
        $product->stock_quantity = $request->stock_quantity;
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->is_show = $request->is_show;
        $product->is_new = $request->has('is_new');
        $product->is_hot = $request->has('is_hot');

        // Xử lý ảnh đại diện
        if ($request->hasFile('avata')) {
            $product->avata = $request->file('avata')->store('products', 'public');
        }

        $product->save();

        // Cập nhật hình ảnh phụ
        if ($request->has('remove_images')) {
            foreach ($request->remove_images as $imageId) {
                $image = ProductImage::findOrFail($imageId);
                if (Storage::disk('public')->exists($image->image_path)) {
                    Storage::disk('public')->delete($image->image_path);
                }
                $image->delete();
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('product_images', 'public');
                $product->productImages()->create(['image_path' => $imagePath]);
            }
        }

        // Cập nhật biến thể đã có
        if ($request->has('variant_ids')) {
            foreach ($request->variant_ids as $index => $variantId) {
                $variant = ProductDetail::findOrFail($variantId);

                // Kiểm tra xem có ảnh mới cho biến thể này không
                $variantImage = $variant->image;
                if ($request->hasFile("variant_images.$index")) {
                    // Nếu có ảnh mới, lưu ảnh và cập nhật đường dẫn
                    $variantImage = $request->file("variant_images.$index")->store('images/variants', 'public');
                }

                // Cập nhật các thông tin của biến thể và giữ nguyên ảnh hiện tại nếu không có ảnh mới
                $variant->update([
                    'quantity' => $request->quantities[$index],
                    'price' => $request->prices[$index],
                    'discount_price' => $request->discount_prices[$index],
                    'image' => $variantImage,
                ]);
            }
        }

        // Lưu biến thể sản phẩm mới
        if ($request->has('variant_quantity')) {
            foreach ($request->variant_quantity as $sizeId => $colors) {
                foreach ($colors as $colorId => $quantity) {
                    $existingVariant = ProductDetail::where('products_id', $product->id)
                        ->where('size_id', $sizeId)
                        ->where('color_id', $colorId)
                        ->first();

                    if ($existingVariant) {
                        $existingVariant->update([
                            'quantity' => $quantity,
                            'price' => $request->variant_price[$sizeId][$colorId],
                            'discount_price' => $request->variant_discount_price[$sizeId][$colorId],
                            'image' => isset($request->variant_image[$sizeId][$colorId])
                                ? $request->file("variant_image.$sizeId.$colorId")->store('product_variants', 'public')
                                : $existingVariant->image,
                        ]);
                    } else {
                        $variant = new ProductDetail();
                        $variant->products_id = $product->id;
                        $variant->product_code = 'SP-' . strtoupper(Str::random(8));
                        $variant->size_id = $sizeId;
                        $variant->color_id = $colorId;
                        $variant->quantity = $quantity;
                        $variant->price = $request->variant_price[$sizeId][$colorId];
                        $variant->discount_price = $request->variant_discount_price[$sizeId][$colorId];

                        if (isset($request->variant_image[$sizeId][$colorId])) {
                            $variant->image = $request->file("variant_image.$sizeId.$colorId")->store('product_variants', 'public');
                        }

                        $variant->save();
                    }
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    } catch (\Exception $e) {
        Log::error('Error updating product: ' . $e->getMessage(), [
            'request_data' => $request->all(),
            'stack_trace' => $e->getTraceAsString()
        ]);
        return back()->withErrors(['error' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
    }
}


    public function edit($id)
    {
        $products = products::findOrFail($id);
        $categories = categories::where('status', true)->get();
        $sizes = Size::where('status', true)->get();
        $colors = Color::where('status', true)->get();
        $product = products::findOrFail($id);
        $existingVariants = $product->ProductDetails()->get(['size_id', 'color_id'])->toArray();
        $variants = $product->productDetails;
        return view('admin.products.edit', compact('products', 'variants', 'colors', 'existingVariants', 'sizes', 'categories'));
    }


    public function show(string $id)
    {
        $product = products::findOrFail($id);

        $variants = $product->productDetails;
        return view('admin.products.show', compact('product', 'variants'));
    }

    public function destroy($id)
    {
        $products = products::findOrFail($id);
        $products->delete();

        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được xóa .');
    }
}

