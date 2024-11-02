<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\CategoryProductRequest;
use App\Models\categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryProductController extends Controller
{
    public function index()
    {
        $categories = categories::select('id', 'name', 'status')->paginate(perPage: 6);

        return view('admin.categories.index', compact('categories'));
    }


    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(CategoryProductRequest $request)
    {
        try {
            DB::beginTransaction();

            categories::create([
                'name' => $request->name,
                'status' => $request->status ? 1 : 0
            ]);

            DB::commit();

            return redirect()->route('admin.categories.index')->with('status_succeed', 'Thêm mới thành công');
        } catch (\Exception $th) {
            DB::rollBack();

            return back()->with('status_failed', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $category = categories::find($id);

        if (!$category) {
            return redirect()->route('admin.categories.index')->with('status_failed', 'Danh mục không tồn tại');
        }

        return view('admin.categories.edit', compact('category'));
    }

    public function update(CategoryProductRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $category = categories::find($id);

            if (!$category) {
                return redirect()->route('admin.categories.index')->with('status_failed', 'Danh mục không tồn tại');
            }

            $category->update([
                'name' => $request->name,
                'status' => $request->status ? 1 : 0
            ]);

            DB::commit();

            return redirect()->route('admin.categories.index')->with('status_succeed', 'Cập nhật thành công');
        } catch (\Exception $th) {
            DB::rollBack();

            return back()->with('status_failed', $th->getMessage());
        }
    }

    public function delete($id)
    {
        $category = categories::find($id);

        if (!$category) {
            return redirect()->route('admin.categories.index')->with('status_failed', 'Danh mục không tồn tại');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('status_succeed', 'Xóa thành công');
    }
}
