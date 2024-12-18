<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ColorRequest;
use Illuminate\Http\Request;
use App\Models\Color;

class ColorController extends Controller
{
    /**
     * Hiển thị danh sách các màu.
     */
    // Controller (ColorController.php)
    // public function __construct(){
    //     $this->middleware('permission:view color', ['only' => ['index']]);
    //     $this->middleware('permission:create color', ['only' => ['create', 'store']]);
    //     $this->middleware('permission:edit color', ['only' => ['update', 'edit']]);
    //     $this->middleware('permission:delete color', ['only' => ['destroy']]);
    // }

    public function index(Request $request)
    {
        $query = Color::query();

        // Xử lý tìm kiếm
        if ($request->has('search') && $request->search) {
            $query->where('value', 'like', '%' . $request->search . '%');
        }

        // Xử lý sắp xếp
        if ($request->has('sort') && in_array($request->sort, ['color_id', 'value', 'color_code'])) {
            $direction = $request->get('direction', 'asc');
            $query->orderBy($request->sort, $direction);
        }

        $colors = $query->paginate(10);

        return view('admin.colors.index', compact('colors'));
    }

    /**
     * Hiển thị form tạo mới màu.
     */
    public function create()
    {
        return view('admin.colors.create');
    }

    /**
     * Lưu màu mới vào cơ sở dữ liệu.
     */
    public function store(ColorRequest $request)
    {
        Color::create([
            'value' => $request->value,
            'color_code' => $request->color_code,
            'status' => $request->status ?? true,
        ]);

        return redirect()->route('admin.colors.index')->with('success', 'Màu mới đã được thêm thành công.');
    }

    /**
     * Hiển thị form chỉnh sửa màu.
     */
    public function edit(string $id)
    {
        $color = Color::findOrFail($id);
        return view('admin.colors.edit', compact('color'));
    }

    /**
     * Cập nhật thông tin màu trong cơ sở dữ liệu.
     */
    public function update(ColorRequest $request, $id)
    {
        $color = Color::findOrFail($id);

        // Cập nhật các trường khác
        $color->value = $request->input('value');
        $color->color_code = $request->input('color_code');

        // Xử lý trạng thái
        $color->status = $request->input('status'); // Sẽ nhận 0 hoặc 1 từ form

        $color->save();

        return redirect()->route('admin.colors.index')->with('success', 'Cập nhật màu sắc thành công.');
    }


    /**
     * Xóa màu khỏi cơ sở dữ liệu.
     */
    public function destroy(string $id)
    {
        $color = Color::findOrFail($id);
        $color->delete();

        return redirect()->route('admin.colors.index')->with('success', 'Màu đã được xóa thành công.');
    }
}
