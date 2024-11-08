<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\categories;
use App\Models\products;
use App\Models\Size;
use App\Models\Color;
use App\Models\ProductDetail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Products::with('categories')->paginate(7);
        return view('admin.products.index', compact('products'));
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


            // Lưu biến thể sản phẩm mới
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

            // Cập nhật biến thể đã có
            if ($request->has('variant_ids')) {
                foreach ($request->variant_ids as $index => $variantId) {
                    $variant = ProductDetail::findOrFail($variantId);
                    $variant->update([
                        'quantity' => $request->quantities[$index],
                        'price' => $request->prices[$index],
                        'discount_price' => $request->discount_prices[$index],
                        // Xử lý upload hình ảnh nếu có
                        'image' => $request->hasFile('variant_images') ? $request->variant_images[$index]->store('images/variants') : $variant->image,
                    ]);
                }
            }

            // Lưu biến thể sản phẩm mới
            if ($request->has('variant_quantity')) {
                foreach ($request->variant_quantity as $sizeId => $colors) {
                    foreach ($colors as $colorId => $quantity) {
                        // Kiểm tra nếu biến thể đã tồn tại
                        $existingVariant = ProductDetail::where('products_id', $product->id)
                            ->where('size_id', $sizeId)
                            ->where('color_id', $colorId)
                            ->first();

                        if ($existingVariant) {
                            // Cập nhật biến thể đã tồn tại
                            $existingVariant->update([
                                'quantity' => $quantity,
                                'price' => $request->variant_price[$sizeId][$colorId],
                                'discount_price' => $request->variant_discount_price[$sizeId][$colorId],
                                // Xử lý ảnh của biến thể
                                'image' => isset($request->variant_image[$sizeId][$colorId])
                                    ? $request->file("variant_image.$sizeId.$colorId")->store('product_variants', 'public')
                                    : $existingVariant->image,
                            ]);
                        } else {
                            // Tạo mới biến thể
                            $variant = new ProductDetail();
                            $variant->products_id = $product->id;
                            $variant->product_code = 'SP-' . strtoupper(Str::random(8));
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
