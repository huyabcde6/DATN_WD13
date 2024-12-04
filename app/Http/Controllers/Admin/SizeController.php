<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Size;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Size::query();

        // Tìm kiếm theo tên
        if ($request->has('search') && $request->search) {
            $query->where('value', 'like', '%' . $request->search . '%');
        }

        // Sắp xếp theo giá trị hoặc trạng thái
        if ($request->has('sort') && in_array($request->sort, ['value', 'status'])) {
            $query->orderBy($request->sort, $request->direction ?? 'asc');
        }

        $sizes = $query->paginate(10);

        return view('admin.sizes.index', compact('sizes'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'value' => 'required|string|max:255',
        ], [
            'value.required' => 'Kích thước không được để trống',
            'value.string' => 'Kích thước phải là chuỗi',
            'value.max' => 'Kích thước không vượt qua 255 ký tự',
        ]);

        Size::create([
            'value' => $request->value,
            'status' => $request->has('status') ? $request->status : true,
        ]);

        return redirect()->route('admin.sizes.index')->with('success', 'Kích thước mới đã được thêm thành công.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'value' => 'required|string|max:255',
        ], [
            'value.required' => 'Kích thước không được để trống',
            'value.string' => 'Kích thước phải là chuỗi',
            'value.max' => 'Kích thước không vượt qua 255 ký tự',
        ]);

        $size = Size::findOrFail($id); // Tìm kích thước theo ID
        $size->update([
            'value' => $request->value,
            'status' => $request->has('status') ? $request->status : true,
        ]);

        return redirect()->route('admin.sizes.index')->with('success', 'Kích thước đã được cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $size = Size::findOrFail($id);
        $size->delete();

        return redirect()->route('admin.sizes.index')->with('success', 'Kích thước đã được xóa thành công.');
    }
}
