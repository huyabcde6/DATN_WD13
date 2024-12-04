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
<<<<<<< HEAD
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

=======
    public function index()
    {
        $sizes = Size::all();
        return view('admin.sizes.index', compact('sizes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sizes.create');
    }
>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'value' => 'required|string|max:255',
        ]);
<<<<<<< HEAD

=======
    
>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19
        Size::create([
            'value' => $request->value,
            'status' => $request->has('status') ? $request->status : true,
        ]);
<<<<<<< HEAD

        return redirect()->route('admin.sizes.index')->with('success', 'Kích thước mới đã được thêm thành công.');
=======
    
        return redirect()->route('sizes.index')->with('success', 'Kích thước mới đã được thêm thành công');
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
        $size = Size::findOrFail($id); // Tìm kích thước theo ID
        return view('admin.sizes.edit', compact('size'));
>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'value' => 'required|string|max:255',
        ]);
<<<<<<< HEAD

        $size = Size::findOrFail($id); // Tìm kích thước theo ID
=======
    
        $size = Size::findOrFail($id);
>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19
        $size->update([
            'value' => $request->value,
            'status' => $request->has('status') ? $request->status : true,
        ]);
<<<<<<< HEAD

        return redirect()->route('admin.sizes.index')->with('success', 'Kích thước đã được cập nhật thành công.');
=======
    
        return redirect()->route('sizes.index')->with('success', 'Kích thước đã được cập nhật thành công');
>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $size = Size::findOrFail($id);
        $size->delete();

<<<<<<< HEAD
        return redirect()->route('admin.sizes.index')->with('success', 'Kích thước đã được xóa thành công.');
=======
        return redirect()->route('sizes.index')->with('success', 'Kích thước đã được xóa thành công');
>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19
    }
}
