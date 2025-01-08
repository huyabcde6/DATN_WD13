<?php

namespace App\Http\Controllers;

use App\Http\Requests\CouponRequestUpdate;
use App\Http\Requests\CouponRequest;
use App\Models\categories;
use App\Models\Coupon_Conditions;
use App\Models\Coupons;
use App\Models\product;
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
        $products = product::all();
        $categories = categories::all();

        return view('admin.Coupons.addCoupons', compact('products', 'categories'));
    }
    public function store(CouponRequest $request)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons,code',
        ]);
        $coupon = Coupons::create($request->all());

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
        $products = product::all(); // Lấy danh sách sản phẩm
        $categories = categories::all(); // Lấy danh sách danh mục

        return view('admin.coupons.editCoupont', compact('coupon', 'products', 'categories'));
    }
    public function update(CouponRequestUpdate $request, $id)
    {

        $validated = $request->all();

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
