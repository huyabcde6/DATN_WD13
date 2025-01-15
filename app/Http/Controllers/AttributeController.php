<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Http\Requests\AttributeRequest;
use App\Http\Requests\AttributeUpdateRequest;

class AttributeController extends Controller
{
    public function __construct(){
        $this->middleware('permission:Xem thuộc tính biến thể', ['only' => ['index']]);
        $this->middleware('permission:Thêm mới thuộc tính biến thể', ['only' => ['create', 'store']]);
        $this->middleware('permission:Sửa thuộc tính biến thể', ['only' => ['update', 'edit']]);
    }
    public function index()
    {
        $attributes = Attribute::all();
        return view('admin.attributes.index', compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.attributes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AttributeRequest  $request)
    {
        Attribute::create($request->validated());

        return redirect()->route('admin.attributes.index')->with('success', 'Thêm mới thuộc tính thành công!');
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
    public function edit(Attribute $attribute)
    {
        return view('admin.attributes.edit', compact('attribute'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AttributeUpdateRequest  $request, Attribute $attribute)
    {
        $attribute->update($request->validated());

        return redirect()->route('admin.attributes.index')->with('success', 'Cập nhật thuộc tính thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attribute $attribute)
    {
        $attribute->delete();

        return redirect()->route('admin.attributes.index')->with('success', 'Attribute deleted successfully!');
    }
}
