<?php

namespace App\Http\Controllers;

use App\Models\categories;
use App\Models\Coupon_Conditions;
use App\Models\Coupons;
use App\Models\products;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
    public function index()
    {
        // Lấy tất cả mã giảm giá cùng với các điều kiện liên quan
        $coupons = Coupons::with('conditions')->paginate(10); // Phân trang 10 mã giảm giá mỗi trang
        return view('admin.Coupons.indexCoupons', compact('coupons'));
    }
    public function create()
    {
        // Lấy tất cả sản phẩm và danh mục
        $products = products::all();
        $categories = categories::all();

        return view('admin.Coupons.addCoupons', compact('products', 'categories'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:coupons,code',
            'discount_type' => 'required|string|in:percentage,fixed_amount',
            'discount_value' => 'required|numeric|min:0',
            'max_discount_amount' => 'required|numeric|min:0',
            'min_order_amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'total_quantity' => 'required|integer|min:1',
            'status' => 'required|string|in:active,disabled,disabled',
        ]);
        // dd($validated);
        $coupon = Coupons::create($validated);

        // Lưu điều kiện áp dụng cho sản phẩm
        if ($request->filled('product_id')) {
            foreach ($request->product_id as $productId) {
                $coupon->conditions()->create(['product_id' => $productId]);
            }
        }

        // Lưu điều kiện áp dụng cho danh mục
        if ($request->filled('category_id')) {
            foreach ($request->category_id as $categoryId) {
                $coupon->conditions()->create(['category_id' => $categoryId]);
            }
        }

        return redirect()->route('admin.Coupons.index')->with('success', 'Mã giảm giá được thêm thành công!');
    }
    public function destroy($id)
    {
        // Tìm mã giảm giá theo ID
        $coupon = Coupons::findOrFail($id);

        // Xóa điều kiện áp dụng liên quan trong bảng `coupon_conditions`
        $coupon->conditions()->delete();

        // Xóa mã giảm giá
        $coupon->delete();

        // Điều hướng về danh sách và hiển thị thông báo
        return redirect()->route('admin.Coupons.index')->with('success', 'Xóa mã giảm giá thành công!');
    }
    public function edit($id)
    {
        $coupon = Coupons::findOrFail($id);
        $products = products::all(); // Lấy danh sách sản phẩm
        $categories = categories::all(); // Lấy danh sách danh mục

        return view('admin.coupons.editCoupont', compact('coupon', 'products', 'categories'));
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:coupons,code,' . $id,
            'discount_type' => 'required|string|in:percentage,fixed_amount',
            'discount_value' => 'required|numeric|min:0',
            'max_discount_amount' => 'required|numeric|min:0',
            'min_order_amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'total_quantity' => 'required|integer|min:1',
            'status' => 'required|string|in:active,expired,disabled',
        ]);

        $coupon = Coupons::findOrFail($id);

        // Cập nhật thông tin mã giảm giá
        $coupon->update($validated);

        // Xóa các điều kiện cũ
        $coupon->conditions()->delete();

        // Lưu các điều kiện mới
        if ($request->filled('product_id')) {
            foreach ($request->product_id as $productId) {
                $coupon->conditions()->create(['product_id' => $productId]);
            }
        }

        if ($request->filled('category_id')) {
            foreach ($request->category_id as $categoryId) {
                $coupon->conditions()->create(['category_id' => $categoryId]);
            }
        }

        return redirect()->route('admin.Coupons.index')->with('success', 'Cập nhật mã giảm giá thành công!');
    }
}
