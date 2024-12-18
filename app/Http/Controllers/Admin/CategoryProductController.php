<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryProductRequest;
use App\Http\Requests\CategoryRequest;
use App\Models\categories;
use App\Models\products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryProductController extends Controller
{
    // public function __construct(){
    //     $this->middleware('permission:view category', ['only' => ['index']]);
    //     $this->middleware('permission:create category', ['only' => ['create', 'store']]);
    //     $this->middleware('permission:edit category', ['only' => ['update', 'edit']]);
    //     $this->middleware('permission:delete category', ['only' => ['destroy']]);
    // }

    public function index(Request $request)
    {
        $query = DB::table('categories')
            ->leftJoin('products', 'categories.id', '=', 'products.categories_id') // Liên kết bảng categories và products
            ->select(
                'categories.id',
                'categories.name',
                'categories.status',
                DB::raw('COUNT(products.id) as product_count') // Đếm số lượng sản phẩm
            )
            ->groupBy('categories.id', 'categories.name', 'categories.status'); // Nhóm theo các cột trong categories

        // Lọc theo từ khóa tìm kiếm
        if ($request->filled('search')) {
            $query->where('categories.name', 'like', '%' . $request->search . '%');
        }

        // Sắp xếp
        if ($request->filled('sort') && $request->filled('order')) {
            $query->orderBy($request->sort, $request->order);
        } else {
            $query->orderBy('categories.id', 'desc'); // Mặc định sắp xếp theo id giảm dần
        }

        // Lấy dữ liệu và phân trang
        $categories = $query->paginate(6);
        return view('admin.categories.index', compact('categories'))
            ->with('search', $request->search)
            ->with('sort', $request->sort)
            ->with('order', $request->order);
    }



    /**
     * Hiển thị form tạo danh mục mới.
     */
    public function create()
    {

        $products = products::whereHas('categories', function ($query) {
            $query->where('name', 'không xác định');
        })
        ->orWhere('categories_id', null)
        ->get();
    
        return view('admin.categories.create', compact('products'));
    }

    /**
     * Lưu danh mục mới vào cơ sở dữ liệu.
     */
    public function store(CategoryProductRequest $request)
    {
        try {
            DB::beginTransaction();

            $category = categories::create([
                'name' => $request->name,
                'status' => $request->boolean('status') // Dùng phương thức boolean để xử lý đúng kiểu boolean

            ]);
            if ($request->has('products')) {
                foreach ($request->products as $productId) {
                    $product =   products::find($productId);
                    $product->categories_id = $category->id;
                    $product->save();
                }
            }
            DB::commit();

            return redirect()->route('admin.categories.index')
                ->with('status_succeed', 'Thêm mới thành công');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('status_failed', $e->getMessage());
        }
    }

    /**
     * Hiển thị form chỉnh sửa danh mục.
     */
    public function edit($id)
    {
        $category = categories::findOrFail($id);
        $products = products::where('categories_id', 13)->orWhere('categories_id', null)->get();

        return view('admin.categories.edit', compact('category', 'products'));
    }

    /**
     * Cập nhật thông tin danh mục.
     */
    public function update(CategoryRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $category = categories::findOrFail($id);
            $category->update([
                'name' => $request->name,
                'status' => $request->boolean('status')
            ]);
            if ($request->has('products')) {
                foreach ($request->products as $productId) {
                    $product =   products::find($productId);
                    $product->categories_id = $category->id;
                    $product->save();
                }
            }
            DB::commit();

            return redirect()->route('admin.categories.index')
                ->with('status_succeed', 'Cập nhật thành công');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('status_failed', $e->getMessage());
        }
    }


    /**
     * Xóa danh mục.
     */
    public function destroy($id)
    {
        // Tìm danh mục theo ID
        $category = categories::findOrFail($id);

        // Tìm danh mục mặc định có name = "Không xác định"
        $defaultCategory = categories::where('name', 'Không xác định')->first();

        // Kiểm tra nếu danh mục đang xóa là danh mục mặc định
        if ($category->name == 'Không xác định') {
            return redirect()->route('admin.categories.index')
                ->with('status_error', 'Không thể xóa danh mục "Không xác định"');
        }

        // Kiểm tra nếu danh mục mặc định không tồn tại
        if (!$defaultCategory) {
            return redirect()->route('admin.categories.index')
                ->with('status_error', 'Không thể xóa danh mục vì danh mục mặc định "Không xác định" không tồn tại');
        }

        // Cập nhật tất cả sản phẩm trong danh mục này về danh mục mặc định
        products::where('categories_id', $id)->update(['categories_id' => $defaultCategory->id]);

        // Xóa danh mục
        $category->delete();

        // Quay lại trang danh mục với thông báo thành công
        return redirect()->route('admin.categories.index')
            ->with('status_succeed', 'Xóa danh mục thành công');
    }

}
