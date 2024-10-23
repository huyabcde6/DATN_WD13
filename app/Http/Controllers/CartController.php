<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductDetail;
use App\Models\products;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function index()
    {
        // Lấy tất cả sản phẩm trong giỏ hàng từ session
        $cartItems = Session::get('cart', []); // Sử dụng session để lấy dữ liệu giỏ hàng
        
        // Thiết lập phí vận chuyển
        $shippingFee = 5.00;

        // Tính tổng Sub Total (tổng tiền hàng trước phí vận chuyển)
        $subTotal = 0;
        foreach ($cartItems as $item) {
            $subTotal += $item['price'] * $item['quantity'];
        }

        // Tính tổng tiền bao gồm phí vận chuyển
        $total = $subTotal + $shippingFee;

        // Truyền dữ liệu giỏ hàng, phí vận chuyển và tổng tiền sang view
        return view('user.sanpham.cart', compact('cartItems', 'subTotal', 'shippingFee', 'total'));
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart(Request $request)
{
    // Kiểm tra dữ liệu đầu vào
    $request->validate([
        'product_detail_id' => 'required|exists:product_details,id',
        'size' => 'required|string',
        'color' => 'required|string',
        'quantity' => 'required|integer|min:1',
    ]);

    // Lấy giỏ hàng từ session
    $cart = Session::get('cart', []);
    $productDetailId = $request->input('product_detail_id');
    $size = $request->input('size');
    $color = $request->input('color');
    $quantity = $request->input('quantity');

    // Lấy thông tin chi tiết sản phẩm
    $productDetail = ProductDetail::find($productDetailId);
    if (!$productDetail) {
        return response()->json(['status' => 'error', 'message' => 'Product not found.'], 404);
    }

    // Thêm sản phẩm vào giỏ hàng
    if (isset($cart[$productDetailId])) {
        $cart[$productDetailId]['quantity'] += $quantity;
    } else {
        $cart[$productDetailId] = [
            'product_detail_id' => $productDetailId,
            'size' => $size,
            'color' => $color,
            'quantity' => $quantity,
            'product_name' => $productDetail->products->name,
            'price' => $productDetail->price,
            'image' => $productDetail->image,
        ];
    }

    // Lưu giỏ hàng vào session
    Session::put('cart', $cart);

    // Tính toán tổng tiền
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    // Thêm phí vận chuyển
    $shippingFee = 5.00;
    $totalWithShipping = $total + $shippingFee;

    // Trả về phản hồi JSON cho Ajax
    return response()->json([
        'status' => 'success',
        'message' => 'Product added to cart successfully!',
        'total_price' => number_format($totalWithShipping, 2), // Tổng tiền bao gồm phí vận chuyển
    ]);
}


    public function removeFromCart($productDetailId)
    {
        $cart = Session::get('cart', []);

        // Xóa sản phẩm khỏi giỏ hàng
        if (isset($cart[$productDetailId])) {
            unset($cart[$productDetailId]);
        }

        // Cập nhật session
        Session::put('cart', $cart);

        return redirect()->back()->with('success', 'Product removed from cart successfully!');
    }

    public function update(Request $request)
    {
        // Lấy thông tin từ yêu cầu AJAX
        $productDetailId = $request->input('product_detail_id');
        $quantity = $request->input('quantity');

        // Tìm sản phẩm trong giỏ hàng
        $cart = session()->get('cart', []);

        if (isset($cart[$productDetailId])) {
            // Cập nhật số lượng sản phẩm
            $cart[$productDetailId]['quantity'] = $quantity;

            // Lưu lại giỏ hàng vào session
            session()->put('cart', $cart);

            // Tính toán giá của sản phẩm
            $itemPrice = $cart[$productDetailId]['price'];
            $itemSubtotal = number_format($itemPrice * $quantity, 2); // Tính subtotal

            // Tính tổng giá trị đơn hàng
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            // Thêm phí vận chuyển
            $shippingFee = 5.00;
            $totalWithShipping = $total + $shippingFee;

            // Trả về JSON để JavaScript cập nhật lại giao diện
            return response()->json([
                'status' => 'success',
                'item_price' => $itemSubtotal, // Giá subtotal của sản phẩm
                'total_price' => number_format($totalWithShipping, 2), // Tổng giá trị đơn hàng bao gồm phí vận chuyển
            ]);
        }

        // Nếu không tìm thấy sản phẩm, trả về lỗi
        return response()->json([
            'status' => 'error',
            'message' => 'Product not found in cart',
        ], 404);
    }
    public function getTotal()
{
    $cart = Session::get('cart', []);
    $total = 0;

    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    return response()->json([
        'total_price' => number_format($total, 2),
    ]);
}

}
