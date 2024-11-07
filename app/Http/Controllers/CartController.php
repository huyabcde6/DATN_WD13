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

        $cartItems = Session::get('cart', []); 
        

        $shippingFee = 5.00;

        $subTotal = 0;
        foreach ($cartItems as $item) {
            $subTotal += $item['price'] * $item['quantity'];
        }

        $total = $subTotal + $shippingFee;
        return view('user.sanpham.cart', compact('cartItems', 'subTotal', 'shippingFee', 'total'));
    }
    public function addToCart(Request $request)
    {
        try {
            // Kiểm tra dữ liệu đầu vào
            $request->validate([
                'products_id' => 'required|exists:products,id',
                'size' => 'required|integer|exists:sizes,size_id',
                'color' => 'required|integer|exists:colors,color_id',
                'quantity' => 'required|integer|min:1',
            ]);

            // Lấy giỏ hàng từ session
            $cart = Session::get('cart', []);
            $productsId = $request->input('products_id');
            $sizeId = $request->input('size');
            $colorId = $request->input('color');
            $quantity = $request->input('quantity');

            // Log thông tin đầu vào
            \Log::info('Adding to cart:', [
                'products_id' => $productsId,
                'size' => $sizeId,
                'color' => $colorId,
                'quantity' => $quantity,
            ]);

            // Lấy thông tin chi tiết sản phẩm biến thể
            $productDetail = ProductDetail::where('products_id', $productsId)
                ->where('size_id', $sizeId)
                ->where('color_id', $colorId)
                ->first();

            if (!$productDetail) {
                return response()->json(['status' => 'error', 'message' => 'Không tìm thấy sản phẩm hoặc không có sẵn biến thể.'], 404);
            }

            // Tạo key duy nhất cho biến thể
            $variantKey = $productDetail->id;

            // Thêm hoặc cập nhật sản phẩm trong giỏ hàng
            if (isset($cart[$variantKey])) {
                $cart[$variantKey]['quantity'] += $quantity;
            } else {
                $cart[$variantKey] = [
                    'product_detail_id' => $productDetail->id,
                    'size' => $productDetail->size->value,
                    'color' => $productDetail->color->value,
                    'quantity' => $quantity,
                    'product_name' => $productDetail->products->name,
                    'product_id' => $productDetail->products_id,
                    'price' => $productDetail->price,
                    'image' => $productDetail->image,
                ];
            }

            // Lưu giỏ hàng vào session
            Session::put('cart', $cart);

            // Tính toán tổng tiền
            $total = array_reduce($cart, function ($carry, $item) {
                return $carry + ($item['price'] * $item['quantity']);
            }, 0);

            // Thêm phí vận chuyển
            $shippingFee = 5.00;
            $totalWithShipping = $total + $shippingFee;

            // Trả về phản hồi JSON cho Ajax
            return response()->json([
                'status' => 'success',
                'message' => 'Product added to cart successfully!',
                'total_price' => number_format($totalWithShipping, 2),
            ]);
        } catch (\Exception $e) {
            \Log::error('Error adding to cart: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Có lỗi xảy ra, vui lòng thử lại sau.'], 500);
        }
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
    public function count()
    {
        $count = session('cart') ? count(session('cart')) : 0;
        return response()->json(['count' => $count]);
    }


}