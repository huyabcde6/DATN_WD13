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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'value' => 'required|string|max:255',
        ]);
    
        Size::create([
            'value' => $request->value,
            'status' => $request->has('status') ? $request->status : true,
        ]);
    
        return redirect()->route('admin.sizes.index')->with('success', 'Kích thước mới đã được thêm thành công');
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'value' => 'required|string|max:255',
        ]);
    
        $size = Size::findOrFail($id);
        $size->update([
            'value' => $request->value,
            'status' => $request->has('status') ? $request->status : true,
        ]);
    
        return redirect()->route('admin.sizes.index')->with('success', 'Kích thước đã được cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $size = Size::findOrFail($id);
        $size->delete();

        return redirect()->route('admin.sizes.index')->with('success', 'Kích thước đã được xóa thành công');
    }
}
