<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryProductController extends Controller
{   
    public function __construct(){
        $this->middleware('permission:view category', ['only' => ['index']]);
        $this->middleware('permission:create category', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit category', ['only' => ['update', 'edit']]);
        $this->middleware('permission:delete category', ['only' => ['destroy']]);
    }
    
    public function index(Request $request)
    {
        $query = categories::query();

        // Lọc theo từ khóa tìm kiếm
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Sắp xếp
        if ($request->filled('sort') && $request->filled('order')) {
            $query->orderBy($request->sort, $request->order);
        } else {
            $query->orderBy('id', 'desc'); // Mặc định sắp xếp theo id giảm dần
        }

        // Lấy dữ liệu và phân trang
        $categories = $query->select('id', 'name', 'status')->paginate(6);

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
        return view('admin.categories.create');
    }

    /**
     * Lưu danh mục mới vào cơ sở dữ liệu.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255|unique:categories,name',
            ],
            [
                'name.required' => 'Vui lòng nhập tên danh mục',
                'name.unique' => 'Tên danh mục đã tồn tại',
            ]
        );

        try {
            DB::beginTransaction();

            categories::create([
                'name' => $request->name,
                'status' => $request->boolean('status') // Dùng phương thức boolean để xử lý đúng kiểu boolean
            ]);

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

        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Cập nhật thông tin danh mục.
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255|unique:categories,name,' . $id,
            ],
            [
                'name.required' => 'Vui lòng nhập tên danh mục',
                'name.unique' => 'Tên danh mục đã tồn tại',
            ]
        );
        try {
            DB::beginTransaction();

            $category = categories::findOrFail($id);

            $category->update([
                'name' => $request->name,
                'status' => $request->boolean('status')
            ]);

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
        $category = categories::findOrFail($id);

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('status_succeed', 'Xóa thành công');
    }
}
