<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Color;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colors = Color::all();
        return view('admin.colors.index', compact('colors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.colors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'value' => 'required|string|max:255',
        ]);
    
        Color::create([
            'value' => $request->value,
            'status' => $request->has('status') ? $request->status : true,
        ]);
    
        return redirect()->route('admin.colors.index')->with('success', 'Kích thước mới đã được thêm thành công');
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
        $color = Color::findOrFail($id); // Tìm kích thước theo ID
        return view('admin.colors.edit', compact('color'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'value' => 'required|string|max:255',
        ]);
    
        $color = Color::findOrFail($id);
        $color->update([
            'value' => $request->value,
            'status' => $request->has('status') ? $request->status : true,
        ]);
    
        return redirect()->route('admin.colors.index')->with('success', 'Kích thước đã được cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $color = Color::findOrFail($id);
        $color->delete();

        return redirect()->route('admin.colors.index')->with('success', 'Kích thước đã được xóa thành công');
    }
}
