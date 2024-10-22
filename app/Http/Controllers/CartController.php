<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductDetail;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function index()
    {
        // Lấy tất cả sản phẩm trong giỏ hàng từ session
        $cartItems = Session::get('cart', []); // Sử dụng session để lấy dữ liệu giỏ hàng
        
        return view('user.sanpham.cart', compact('cartItems')); // Truyền dữ liệu giỏ hàng sang view
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart(Request $request)
    {
        // Kiểm tra xem sản phẩm đã được chọn chưa
        $request->validate([
            'product_detail_id' => 'required|exists:product_details,id', // Kiểm tra xem sản phẩm tồn tại trong bảng product_details
            'size' => 'required|string',
            'color' => 'required|string',
            'quantity' => 'required|integer|min:1', // Kiểm tra số lượng sản phẩm
        ]);

        // Lấy giỏ hàng từ session
        $cart = Session::get('cart', []);

        // Lấy thông tin sản phẩm từ request
        $productDetailId = $request->input('product_detail_id');
        $size = $request->input('size');
        $color = $request->input('color');
        $quantity = $request->input('quantity');

        // Lấy thông tin chi tiết sản phẩm từ database
        $productDetail = ProductDetail::find($productDetailId);

        // Kiểm tra xem sản phẩm có tồn tại không
        if (!$productDetail) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found.',
            ], 404);
        }

        // Kiểm tra nếu sản phẩm đã có trong giỏ hàng
        if (isset($cart[$productDetailId])) {
            // Nếu đã có, cập nhật số lượng
            $cart[$productDetailId]['quantity'] += $quantity;
        } else {
            // Nếu chưa có, thêm mới vào giỏ hàng
            $cart[$productDetailId] = [
                'product_detail_id' => $productDetailId,
                'size' => $size,
                'color' => $color,
                'quantity' => $quantity,
                'product_name' => $productDetail->product_code, // Lấy tên sản phẩm từ database
                'price' => $productDetail->price, // Lấy giá sản phẩm từ database
                'image' => $productDetail->image, // Lấy hình ảnh sản phẩm từ database
            ];
        }

        // Lưu giỏ hàng vào session
        Session::put('cart', $cart);

        // Trả về phản hồi JSON cho Ajax
        return response()->json([
            'status' => 'success',
            'message' => 'Product added to cart successfully!',
            'cart_count' => count($cart), // Số lượng sản phẩm trong giỏ hàng
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
            $total = number_format($total, 2); // Định dạng tổng

            // Trả về JSON để JavaScript cập nhật lại giao diện
            return response()->json([
                'status' => 'success',
                'item_price' => $itemSubtotal, // Giá subtotal của sản phẩm
                'total_price' => $total, // Tổng giá trị đơn hàng
            ]);
        }

        // Nếu không tìm thấy sản phẩm, trả về lỗi
        return response()->json([
            'status' => 'error',
            'message' => 'Product not found in cart',
        ], 404);
    }
}
