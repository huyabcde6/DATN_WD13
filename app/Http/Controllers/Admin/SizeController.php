<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SizeRequet;
use Illuminate\Http\Request;
use App\Models\Size;

class SizeController extends Controller
{
    // public function __construct(){
    //     $this->middleware('permission:view size', ['only' => ['index']]);
    //     $this->middleware('permission:create size', ['only' => ['create', 'store']]);
    //     $this->middleware('permission:edit size', ['only' => ['update', 'edit']]);
    //     $this->middleware('permission:delete size', ['only' => ['destroy']]);
    // }

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
    public function store(SizeRequet $request)
    {
        Size::create([
            'value' => $request->value,
            'status' => $request->has('status') ? $request->status : true,
        ]);

        return redirect()->route('admin.sizes.index')->with('success', 'Kích thước mới đã được thêm thành công.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SizeRequet $request, string $id)
    {
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
        // Tìm kích thước theo ID
        $size = Size::findOrFail($id);

        // Kiểm tra nếu có sản phẩm nào đang sử dụng kích thước này
        $isUsed = $size->productDetails()->exists();

        if ($isUsed) {
            return redirect()->route('admin.sizes.index')
                ->with('error', 'Không thể xóa kích thước này vì đang được sử dụng trong sản phẩm.');
        }

        // Nếu không được sử dụng, xóa kích thước
        $size->delete();

        return redirect()->route('admin.sizes.index')
            ->with('success', 'Kích thước đã được xóa thành công.');
    }

}
