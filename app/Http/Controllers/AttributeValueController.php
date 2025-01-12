<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;

class AttributeValueController extends Controller
{
    public function __construct(){
        $this->middleware('permission:Xem giá trị biến thể', ['only' => ['index']]);
        $this->middleware('permission:Thêm mới giá trị biến thể', ['only' => ['create', 'store']]);
        $this->middleware('permission:Sửa giá trị biến thể', ['only' => ['update', 'edit']]);
        $this->middleware('permission:Xóa giá trị biến thể', ['only' => ['destroy']]);
    }
    public function index()
    {
        $attributeValues = AttributeValue::with('attribute')->get();
        return view('admin.attribute_values.index', compact('attributeValues'));
    }

    public function create()
    {
        $attributes = Attribute::all();
        return view('admin.attribute_values.create', compact('attributes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'value' => 'required|string|max:255',
            'color_code' => 'nullable|string|max:7',
        ]);

        AttributeValue::create($request->only('attribute_id', 'value', 'color_code'));

        return redirect()->route('admin.attribute_values.index')->with('success', 'Attribute Value created successfully!');
    }

    public function edit(AttributeValue $attributeValue)
    {
        $attributes = Attribute::all();
        return view('admin.attribute_values.edit', compact('attributeValue', 'attributes'));
    }

    public function update(Request $request, AttributeValue $attributeValue)
    {
        $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'value' => 'required|string|max:255',
            'color_code' => 'nullable|string|max:7',
        ]);

        $attributeValue->update($request->only('attribute_id', 'value', 'color_code'));

        return redirect()->route('admin.attribute_values.index')->with('success', 'Attribute Value updated successfully!');
    }

    public function destroy(AttributeValue $attributeValue)
    {
        $attributeValue->delete();

        return redirect()->route('admin.attribute_values.index')->with('success', 'Attribute Value deleted successfully!');
    }
}
