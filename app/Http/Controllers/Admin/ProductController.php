<?php

namespace App\Http\Controllers\Admin;

use App\Models\AttributeValue;
use App\Models\Attribute;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use Illuminate\Http\Request;
use App\Models\categories;
use App\Models\product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\ProductVariant;
use App\Models\ProductVariantAttribute;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Xem danh sách sản phẩm', ['only' => ['index', 'show']]);
        $this->middleware('permission:Thêm mới sản phẩm', ['only' => ['create', 'store']]);
        $this->middleware('permission:Cập nhật sản phẩm', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Xóa sản phẩm', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $query = product::query();

        // Sắp xếp mặc định theo 'created_at' theo thứ tự giảm dần
        $query->orderBy('created_at', 'desc');

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

        // Lấy danh sách các danh mục
        $categories = categories::all();

        // Lấy danh sách sản phẩm với phân trang
        $products = $query->paginate(10);

        return view('admin.products.index', compact('products', 'categories'));
    }


    public function create()
    {
        $categories = categories::where('status', true)->get();
        $attributes = Attribute::with('values')->get();
        return view('admin.products.create', compact('categories', 'attributes'));
    }


    public function store(ProductRequest  $request)
    {
        DB::beginTransaction();

        try {
            // Tìm sản phẩm theo ID
            $product = new product();

            // Cập nhật thông tin sản phẩm
            $product->name = $request->name;
            $product->slug = $request->slug;
            $product->categories_id = $request->categories_id;
            $product->price = $request->price;
            $product->discount_price = $request->discount_price;
            $product->short_description = $request->short_description;
            $product->description = $request->description;
            $product->is_show = $request->is_show ?? 1; // Hiển thị mặc định nếu không chọn
            $product->is_new = $request->has('is_new') ? 1 : 0; // True nếu checkbox được chọn
            $product->is_hot = $request->has('is_hot') ? 1 : 0;

            // Xử lý ảnh đại diện
            if ($request->hasFile('avata')) {
                $product->avata = Storage::disk('public')->put('products', $request->file('avata'));
            }

            $product->save();

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePath = Storage::disk('public')->put('product_images', $image);

                    // Lưu đường dẫn ảnh vào bảng liên kết `ProductImages` (bảng chứa các ảnh phụ)
                    $product->productImages()->create(['image_path' => $imagePath]);
                }
            }
            $this->storeVariants($product, $request);
            // $users = User::all();
            // foreach($users as $userNotify){
            //     $userNotify->notify(new CreateProduct($product, 'Có sản phẩm mới.', 'Sản phẩm mới'));
            // }
            DB::commit();
            return redirect()->route('admin.products.index')->with('success', 'Thêm mới sản phẩm thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error adding product: ' . $e->getMessage(), [
                'request_data' => $request->all(), // Ghi lại dữ liệu request nếu cần
                'stack_trace' => $e->getTraceAsString() // Ghi lại stack trace
            ]);
            return back()->withErrors(['error' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
        }
    }
    private function storeVariants($product, $request) {
        $variantPrices = $request->input('variant_prices', []); // Đảm bảo là mảng
        $variantStocks = $request->input('variant_stocks', []);
        $variantSkus = $request->input('variant_skus', []);
        $variantImages = $request->file('variant_images', []);
        $variantValues = $request->input('values', []);
    
        // Kiểm tra nếu không phải là mảng, trả về lỗi hoặc bỏ qua
        if (!is_array($variantPrices) || !is_array($variantStocks) || !is_array($variantSkus) || !is_array($variantValues)) {
            throw new \InvalidArgumentException('Invalid input data.');
        }
        foreach ($variantPrices as $index => $price) {
            // Kiểm tra tồn tại giá trị tại $index
            $sku = $variantSkus[$index] ?? null;
            $stock = $variantStocks[$index] ?? null;
            $image = $variantImages[$index] ?? null;
    
            if ($sku === null || $stock === null) {
                continue; // Bỏ qua nếu dữ liệu không hợp lệ
            }
    
            $variant = ProductVariant::create([
                'product_id' => $product->id,
                'product_code' => $sku,
                'price' => $price,
                'stock_quantity' => $stock,
                'image' => $image ? $this->uploadImageVariant($image) : null,
            ]);
            if (isset($variantValues[$index]) && is_array($variantValues[$index])) {
                foreach ($variantValues[$index] as $value) {
                    if (isset($value['attribute_id'], $value['attribute_value_id'])) {
                        ProductVariantAttribute::create([
                            'product_variant_id' => $variant->id,
                            'attribute_id' => $value['attribute_id'],
                            'attribute_value_id' => $value['attribute_value_id'],
                        ]);
                    }
                }
            }
        }
    }
    private function uploadImageVariant($image) {
        if($image){
            return $image->store('product_variants', 'public');
        }
        return null;
    }

    public function update(ProductUpdateRequest $request, $id)
    {
        DB::beginTransaction();
        try {

            // Tìm sản phẩm theo ID
            $product = product::findOrFail($id);

            // Cập nhật thông tin sản phẩm
            $product->name = $request->name;
            $product->slug = $request->slug;
            $product->categories_id = $request->categories_id;
            $product->price = $request->price;
            $product->discount_price = $request->discount_price;
            $product->short_description = $request->short_description;
            $product->description = $request->description;
            $product->is_show = $request->is_show ? 1 : 0;
            $product->is_new = $request->has('is_new'); // True nếu checkbox được chọn
            $product->is_hot = $request->has('is_hot');

            // Xử lý ảnh đại diện
            if ($request->hasFile('avata')) {
                if ($product->avata && Storage::disk('public')->exists($product->avata)) {
                    Storage::disk('public')->delete($product->avata); // Xóa ảnh cũ
                }
                $product->avata = $request->file('avata')->store('products', 'public');
            }

            $product->save();

            $deleteImages = json_decode($request->input('deleted_images', '[]'));
            // Thêm hình ảnh phụ mới
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('product_images', 'public');
                    $product->productImages()->create(['image_path' => $imagePath]);
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

            $deleteVariantIds = $request->input('delete_variant_ids', []);
            if (!empty($deleteVariantIds)) {
                VarianAttribute::whereIn('product_variant_id', $deleteVariantIds)->delete();
                ProductVariant::whereIn('id', $deleteVariantIds)->delete();
            }

            $this->updateExistingVariants($request, $product);

            $this->addNewVariants($request, $product);

            DB::commit();


            return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công!');
        } catch (\Exception $e) {
            Log::error('Error updating product: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'stack_trace' => $e->getTraceAsString()
            ]);
            DB::rollBack();
            return back()->withErrors(['error' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
        }
    }

    private function updateExistingVariants($request, $product)
    {

        $variantIds = $request->input('variant_ids', []);
        $variantPrices = $request->input('variant_prices', []);
        $variantStocks = $request->input('variant_stocks', []);
        $variantSkus = $request->input('variant_skus', []);
        $variantImages = $request->file('variant_images', []);
        foreach ($variantIds as $index => $variantId) {
            $variant = ProductVariant::find($variantId);
            if ($variant) {
                $variant->update([
                    'price' => $variantPrices[$index],
                    'product_code' => $variantSkus[$index],
                    'stock_quantity' => $variantStocks[$index],
                    'image' => isset($variantImages[$index]) ? $this->uploadImageVariant($variantImages[$index]) : $variant->image,
                ]);
            }
        }
    }

    private function addNewVariants($request, $product)
    {
        // dd($request->all());

        $newVariantPrices = $request->input('new_variant_prices', []);
        $newVariantStocks = $request->input('new_variant_stocks', []);
        $newVariantSkus = $request->input('new_variant_skus', []);
        $newVariantImages = $request->file('new_variant_images', []);
        $newValues = $request->input('new_values', []);
        foreach ($newVariantPrices as $index => $price) {
            $newVariant = ProductVariant::create([
                'product_id' => $product->id,
                'product_code' => $newVariantSkus[$index],
                'price' => $price,
                'stock_quantity' => $newVariantStocks[$index],
                'image' => isset($newVariantImages[$index]) ? $this->uploadImageVariant($newVariantImages[$index]) : null,
            ]);

            if (isset($newValues[$index])) {
                foreach ($newValues[$index] as $value) {
                    ProductVariantAttribute::create([
                        'product_variant_id' => $newVariant->id,
                        'attribute_id' => $value['attribute_id'],
                        'attribute_value_id' => $value['attribute_value_id'],
                    ]);
                }
            }
        }
    }

    public function edit($id)
    {

        $product = Product::with('variants.attributes.attributeValue.attribute')->findOrFail($id);
        $categories = categories::where('status', true)->get();
        $attributes = Attribute::with('values')->get();
        $usedAttributes = $this->processUseAttributes($product);
        $this->processVariants($product);
        $data = [
            'product' => $product,
            'categories' => $categories,
            'attributes' => $attributes,
            'usedAttributes' => $usedAttributes,
        ];

        return view('admin.products.edit', compact('data', 'product', 'attributes', 'usedAttributes', 'categories'));
    }

    private function processUseAttributes($product)
    {
        $usedAttributes = [];

        foreach ($product->variants as $variant) {
            // Duyệt qua các thuộc tính của mỗi biến thể
            foreach ($variant->attributes as $attribute) {
                // Kiểm tra nếu attributeValue tồn tại và là đối tượng
                if ($attribute->attributeValue && is_object($attribute->attributeValue)) {
                    // Duyệt qua các giá trị thuộc tính của mỗi thuộc tính
                    foreach ($attribute->attributeValue as $attributeValue) {
                        // Kiểm tra nếu attribute tồn tại và là đối tượng
                        if (is_object($attributeValue) && isset($attributeValue->attribute) && is_object($attributeValue->attribute)) {
                            // Thêm giá trị thuộc tính vào mảng dùng
                            $attribuleId = $attributeValue->attribute->id;
                            $valueId = $attributeValue->id;

                            if (!isset($useAttributes[$attribuleId])) {
                                $usedAttributes[$attribuleId] = [];
                            }

                            if (!in_array($valueId, $useAttributes[$attribuleId])) {
                                $usedAttributes[$attribuleId][] = $valueId;
                            }
                        }
                    }
                }
            }
        }

        return $usedAttributes;
    }


    private function processVariants($product)
    {
        // Khởi tạo một mảng để chứa thông tin biến thể
        $variantsData = [];

        foreach ($product->variants as $variant) {
            // Lưu trữ thông tin cơ bản của biến thể (như giá, tồn kho, v.v.)
            $variantData = [
                'id' => $variant->id,
                'product_code' => $variant->product_code,
                'price' => $variant->price,
                'stock_quantity' => $variant->stock_quantity,
                'attributes' => [],
            ];

            // Duyệt qua các thuộc tính của biến thể và lưu trữ chúng
            foreach ($variant->attributes as $attribute) {
                foreach ($attribute->attributeValue as $attributeValue) {
                    // Kiểm tra nếu attributeValue là một đối tượng hợp lệ
                    if (is_object($attributeValue) && isset($attributeValue->value)) {
                        // Lưu trữ thông tin thuộc tính và giá trị của nó
                        $variantData['attributes'][] = [
                            'attribute_name' => $attribute->attribute->name,   // Tên thuộc tính
                            'value' => $attributeValue->value,      // Giá trị thuộc tính
                            'value_id' => $attributeValue->id,      // ID của giá trị thuộc tính
                        ];
                    }
                }
            }

            // Thêm thông tin biến thể vào mảng variantsData
            $variantsData[] = $variantData;
        }

        // Trả về dữ liệu biến thể đã xử lý
        return $variantsData;
    }

    public function show($id)
    {
        // Lấy sản phẩm theo ID cùng với các biến thể và thuộc tính của chúng
        $product = Product::with(['variants.attributes.attributeValue.attribute', 'productImages'])->findOrFail($id);
        $attributes = Attribute::with('values')->get();
        // Lấy các thuộc tính đã sử dụng trong sản phẩm
        $usedAttributes = $this->processUseAttributes($product);
        $this->processVariants($product);
        // Lấy danh sách danh mục sản phẩm để hiển thị
        $categories = categories::all();
        // Trả về view hiển thị sản phẩm chi tiết
        return view('admin.products.show', compact('product', 'usedAttributes', 'categories'));
    }
    public function destroy($id)
    {
        $products = product::findOrFail($id);
        $products->delete();

        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được xóa .');
    }
}
