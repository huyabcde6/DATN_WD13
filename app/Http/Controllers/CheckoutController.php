<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product; // Thêm dòng này để sử dụng mô hình Product
use App\Models\products;

class CheckoutController extends Controller
{
    public function buyNow(Request $request)
    {
        $user = Auth::user();

        // Lấy thông tin sản phẩm và số lượng từ request
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        // Tìm sản phẩm theo ID
        $product = products::findOrFail($productId); // Sử dụng Product model thay vì ProductController

        // Kiểm tra xem số lượng trong kho có đủ không
        if ($product->stock < $quantity) {
            return redirect()->back()->with('error', 'Số lượng sản phẩm không đủ.');
        }

        // Tính tổng tiền
        $subTotal = $product->price * $quantity;
        $shippingFee = 30000; // 30,000 VND phí vận chuyển
        $total = $subTotal + $shippingFee;

        // Trả về view với các dữ liệu cần thiết
        return view('user.sanpham.thanhtoan', compact(
            'user',
            'product',
            'quantity',
            'subTotal',
            'shippingFee',
            'total'
        ));
    }
}
