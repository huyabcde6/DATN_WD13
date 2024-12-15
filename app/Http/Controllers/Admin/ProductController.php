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
    public function __construct(){
        $this->middleware('permission:view product', ['only' => ['index']]);
        $this->middleware('permission:create product', ['only' => ['create', 'store', 'add']]);
        $this->middleware('permission:edit product', ['only' => ['index']]);
        $this->middleware('permission:delete product', ['only' => ['destroy']]);
    }

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
        try {
            // Tìm sản phẩm theo ID
            $product = new products();

            // Cập nhật thông tin sản phẩm
            $product->name = $request->name;
            $product->slug = $request->slug;
            $product->categories_id = $request->categories_id;
            $product->price = $request->price;
            $product->discount_price = $request->discount_price;
            $product->short_description = $request->short_description;
            $product->description = $request->description;
            $product->is_show = $request->is_show ?? 1; // Hiển thị mặc định nếu không chọn
            $product->is_new = $request->has('is_new'); // True nếu checkbox được chọn
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

        try {
            // Tìm sản phẩm theo ID
            $product = products::findOrFail($id);

            // Cập nhật thông tin sản phẩm
            $product->name = $request->name;
            $product->slug = $request->slug;
            $product->categories_id = $request->categories_id;
            $product->price = $request->price;
            $product->discount_price = $request->discount_price;
            $product->short_description = $request->short_description;
            $product->description = $request->description;
            $product->is_show = $request->is_show ? 1 : 0;
            $product->is_new = $request->has('is_new') ? true : false;
            $product->is_hot = $request->has('is_hot') ? true : false;

            // Xử lý ảnh đại diện
            if ($request->hasFile('avata')) {
                if ($product->avata && Storage::disk('public')->exists($product->avata)) {
                    Storage::disk('public')->delete($product->avata); // Xóa ảnh cũ
                }
                $product->avata = $request->file('avata')->store('products', 'public');
            }

            $product->save();
            // Xử lý xóa hình ảnh phụ
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    // Lưu hình ảnh mới
                    $path = $image->store('product_images', 'public');
                    $product->productImages()->create(['image_path' => $path]);
                }
            }
        
            // Xử lý các hình ảnh bị xóa
            if ($request->has('deleted_images') && !empty($request->deleted_images)) {
                $deletedImages = explode(',', $request->deleted_images);
                foreach ($deletedImages as $imageId) {
                    $image = ProductImage::find($imageId);
                    if ($image) {
                        // Xóa hình ảnh khỏi storage
                        Storage::disk('public')->delete($image->image_path);
                        // Xóa hình ảnh khỏi cơ sở dữ liệu
                        $image->delete();
                    }
                }
            }
            // $product->update($request->except('images', 'deleted_images'));
            // Cập nhật biến thể đã có
            if ($request->has('variant_ids')) {
                foreach ($request->variant_ids as $index => $variantId) {
                    $variant = ProductDetail::findOrFail($variantId);

                    // Xử lý ảnh biến thể
                    if ($request->hasFile("variant_images.$index")) {
                        if ($variant->image && Storage::disk('public')->exists($variant->image)) {
                            Storage::disk('public')->delete($variant->image); // Xóa ảnh cũ
                        }
                        $variant->image = $request->file("variant_images.$index")->store('images/variants', 'public');
                    }

                    $variant->update([
                        'quantity' => $request->quantities[$index],
                        'price' => $request->prices[$index],
                        'discount_price' => $request->discount_prices[$index],
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
                            if ($request->hasFile("variant_image.$sizeId.$colorId")) {
                                if ($existingVariant->image && Storage::disk('public')->exists($existingVariant->image)) {
                                    Storage::disk('public')->delete($existingVariant->image); // Xóa ảnh cũ
                                }
                                $existingVariant->image = $request->file("variant_image.$sizeId.$colorId")->store('product_variants', 'public');
                            }

                            $existingVariant->update([
                                'quantity' => $quantity,
                                'price' => $request->variant_price[$sizeId][$colorId],
                                'discount_price' => $request->variant_discount_price[$sizeId][$colorId],
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

                            if ($request->hasFile("variant_image.$sizeId.$colorId")) {
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