<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductDetail;
use App\Models\products;
use App\Models\Color;
use App\Models\Coupon_Conditions;
use App\Models\Coupons;
use App\Models\Size;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function index()
    {

        $cartItems = Session::get('cart', []);


        $shippingFee = 30000;

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

            // Kiểm tra xem sản phẩm có giá khuyến mãi không
            $price = $productDetail->discount_price ? $productDetail->discount_price : $productDetail->price;

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
                    'price' => $price, // Dùng giá khuyến mãi nếu có
                    'image' => $productDetail->products->avata,
                ];
            }

            // Lưu giỏ hàng vào session
            Session::put('cart', $cart);

            // Tính toán tổng tiền
            $total = array_reduce($cart, function ($carry, $item) {
                return $carry + ($item['price'] * $item['quantity']);
            }, 0);

            // Thêm phí vận chuyển
            $shippingFee = 30000; // Phí vận chuyển 30.000 VND
            $totalWithShipping = $total + $shippingFee;

            // Trả về phản hồi JSON cho Ajax
            return response()->json([
                'status' => 'success',
                'message' => 'Product added to cart successfully!',
                'total_price' => number_format($totalWithShipping, 0, ',', '.') . ' đ', // Định dạng tiền tệ
            ]);
        } catch (\Exception $e) {
            \Log::error('Error adding to cart: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Có lỗi xảy ra, vui lòng thử lại sau.'], 500);
        }
    }


    public function removeFromCart($productDetailId)
    {
        $cart = Session::get('cart', []);
        $couponApplied = session('discount_applied', 0); // Lấy giá trị mã giảm giá đã áp dụng

        // Kiểm tra xem sản phẩm có trong giỏ hàng không
        if (isset($cart[$productDetailId])) {
            // Lấy thông tin chi tiết sản phẩm bị xóa
            $productDetail = ProductDetail::find($productDetailId);

            // Nếu giỏ hàng có mã giảm giá và sản phẩm bị xóa có liên quan đến mã giảm giá, xóa mã giảm giá
            if ($couponApplied > 0 && $this->isProductInAppliedDiscount($productDetail)) {
                // Xóa mã giảm giá đã áp dụng
                session()->forget('discount_applied');
            }

            // Xóa sản phẩm khỏi giỏ hàng
            unset($cart[$productDetailId]);

            // Cập nhật lại giỏ hàng trong session
            Session::put('cart', $cart);

            // Tính toán lại tổng giá trị giỏ hàng (không có mã giảm giá)
            $total = 0;
            $totalQuantity = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
                $totalQuantity += $item['quantity'];
            }

            // Nếu giỏ hàng trống (số lượng sản phẩm = 0), xóa giỏ hàng khỏi session
            if ($totalQuantity == 0) {
                Session::forget('discount_applied');
            }
            // Thêm phí vận chuyển
            $shippingFee = 30000; // Phí vận chuyển 30.000 VND
            $totalWithShipping = $total + $shippingFee;

            // Trả về JSON với thông tin cập nhật
            return response()->json([
                'status' => 'success',
                'message' => 'Product removed from cart successfully!',
                'sub_total' => number_format($total, 0, ',', '.') . ' đ',
                'shipping_fee' => number_format($shippingFee, 0, ',', '.') . ' đ',
                'discount_value' => '0 đ', // Không còn mã giảm giá nữa
                'total_after_discount' => number_format($totalWithShipping, 0, ',', '.') . ' đ', // Tổng sau khi tính phí vận chuyển và không có giảm giá
                'discount_removed' => true, // Mã giảm giá đã bị xóa
            ]);
        }

        // Trả về lỗi nếu sản phẩm không tồn tại trong giỏ hàng
        return response()->json([
            'status' => 'error',
            'message' => 'Product not found in cart!',
        ], 404);
    }

    // Kiểm tra sản phẩm có trong điều kiện mã giảm giá đã áp dụng hay không
    private function isProductInAppliedDiscount($productDetail)
    {
        // Kiểm tra xem sản phẩm có thuộc điều kiện mã giảm giá (có thể áp dụng cho sản phẩm hoặc danh mục)
        $coupon = Coupons::find(session('discount_applied'));

        if (!$coupon) {
            return false;
        }

        // Kiểm tra điều kiện áp dụng mã giảm giá
        $couponConditions = Coupon_Conditions::where('coupon_id', $coupon->id)->get();

        foreach ($couponConditions as $condition) {
            if ($condition->product_id && $condition->product_id == $productDetail->products_id) {
                return true;
            }

            if ($condition->category_id) {
                $product = products::find($productDetail->products_id);
                if ($product && $product->categories_id == $condition->category_id) {
                    return true;
                }
            }
        }

        return false;
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
            $itemSubtotal = number_format($itemPrice * $quantity, 0, ',', '.') . ' đ'; // Tính subtotal

            // Tính tổng giá trị đơn hàng
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            // Thêm phí vận chuyển
            $shippingFee = 30000; // Phí vận chuyển 30.000 VND
            $totalWithShipping = $total + $shippingFee;

            // Trả về JSON để JavaScript cập nhật lại giao diện
            return response()->json([
                'status' => 'success',
                'item_price' => $itemSubtotal, // Giá subtotal của sản phẩm
                'total_price' => number_format($totalWithShipping, 0, ',', '.') . ' đ', // Tổng giá trị đơn hàng bao gồm phí vận chuyển
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

        // Thêm phí vận chuyển
        $shippingFee = 30000; // Phí vận chuyển 30.000 VND
        $totalWithShipping = $total + $shippingFee;

        return response()->json([
            'total_price' => number_format($totalWithShipping, 0, ',', '.') . ' đ', // Định dạng tiền tệ
        ]);
    }

    public function count()
    {
        $count = session('cart') ? count(session('cart')) : 0;
        return response()->json(['count' => $count]);
    }
    public function applyVoucher(Request $request)
    {
        $request->validate([
            'vocher' => 'required|string',
            'total' => 'required|numeric'
        ]);

        // Kiểm tra mã giảm giá đã áp dụng trước đó trong session
        if (session()->has('discount_applied')) {
            return back()->withErrors(['vocher' => 'Đã áp dụng mã giảm giá trước đó.']);
        }

        // Kiểm tra mã giảm giá
        $coupon = Coupons::where('code', $request->vocher)
            ->where('status', 'active')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        if (!$coupon) {
            return back()->withErrors(['vocher' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn.']);
        }

        // Kiểm tra điều kiện của mã giảm giá (áp dụng cho sản phẩm hoặc danh mục)
        $couponConditions = Coupon_Conditions::where('coupon_id', $coupon->id)->get();

        $cartTotal = $request->total;
        $discount = 0;

        // Kiểm tra nếu mã giảm giá không có điều kiện (không áp dụng cho sản phẩm hoặc danh mục cụ thể)
        if ($couponConditions->isEmpty()) {
            if ($cartTotal >= $coupon->min_order_amount) {
                $discount = $this->calculateDiscount($coupon, $cartTotal);
            }
        } else {
            // Kiểm tra mã giảm giá áp dụng cho sản phẩm hoặc danh mục
            foreach ($couponConditions as $condition) {
                if ($condition->product_id) {
                    $product = products::find($condition->product_id);
                    if ($product && $cartTotal >= $coupon->min_order_amount) {
                        $discount = $this->calculateDiscount($coupon, $cartTotal);
                    }
                } elseif ($condition->category_id) {
                    // Nếu mã giảm giá áp dụng cho danh mục sản phẩm
                    $categoryProducts = products::where('categories_id', $condition->category_id)->get();
                    foreach ($categoryProducts as $product) {
                        if ($cartTotal >= $coupon->min_order_amount) {
                            $discount = $this->calculateDiscount($coupon, $cartTotal);
                        }
                    }
                }
            }
        }

        if ($discount > 0) {
            // Trừ số lượng mã trong database
            $coupon->decrement('total_quantity');
            session(['discount_applied' => $discount]);

            return back()->with('vocher', 'Mã giảm giá áp dụng thành công!');
        } else {
            return back()->withErrors(['vocher' => 'Mã giảm giá không áp dụng cho đơn hàng này.']);
        }
    }

    private function calculateDiscount($coupon, $total)
    {
        if ($coupon->discount_type == 'percentage') {
            return ($coupon->discount_value / 100) * $total;
        } else {
            return min($coupon->discount_value, $total);
        }
    }
}
