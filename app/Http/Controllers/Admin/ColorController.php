<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Color;

class ColorController extends Controller
{
    /**
<<<<<<< HEAD
     * Hiển thị danh sách các màu.
     */
    // Controller (ColorController.php)

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

=======
     * Display a listing of the resource.
     */
    public function index()
    {
        $colors = Color::all();
>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19
        return view('admin.colors.index', compact('colors'));
    }

    /**
<<<<<<< HEAD
     * Hiển thị form tạo mới màu.
=======
     * Show the form for creating a new resource.
>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19
     */
    public function create()
    {
        return view('admin.colors.create');
    }

    /**
<<<<<<< HEAD
     * Lưu màu mới vào cơ sở dữ liệu.
     */
    public function store(Request $request)
    {
        $request->validate([
            'value' => 'required|string|max:255',
            'color_code' => 'nullable|string|max:255',
            'status' => 'nullable|boolean',
        ]);

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
    public function update(Request $request, $id)
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
=======
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19
