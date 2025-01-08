<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Models\ProductVariant;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function index()
    {
        $cartItems = Session::get('cart', []);
        $shippingFee = 30000;
        $subTotal = 0;

        foreach ($cartItems as &$item) {
            $product = Product::with('variants.attributes.attributeValue')->find($item['product_id']);
            $variant = isset($item['variant_id']) && $item['variant_id']
                ? ProductVariant::with('attributes.attributeValue')->find($item['variant_id'])
                : null;

            if ($product) {
                $item['name'] = $product->name;
                $item['slug'] = $product->slug;
                $item['image'] = $product->avata;
                $item['price'] = $variant ? $variant->price : $product->price;
                $item['variant'] = $variant;
                $item['stock_quantity'] = $variant ? $variant->stock_quantity : $product->stock_quantity;

                // Lấy giá trị thuộc tính từ biến thể
                $item['attributes'] = $variant ? $variant->attributes->map(function ($attribute) {
                    return [
                        'name' => $attribute->attributeValue->attribute->name ?? null,
                        'value' => $attribute->attributeValue->value ?? null,
                    ];
                })->toArray() : [];

                $subTotal += $item['price'] * $item['quantity'];
            }
        }

        $total = $subTotal + $shippingFee;

        return view('user.sanpham.cart', compact('cartItems', 'subTotal', 'shippingFee', 'total'));
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart(Request $request)
    {
        try {
            $productId = $request->input('product_id');
            $variantId = $request->input('variant_id', null);
            $quantity = $request->input('quantity', 1);

            \Log::info('Dữ liệu từ client:', $request->all());

            // Tìm sản phẩm và biến thể
            $product = Product::find($productId);
            $variant = $variantId ? ProductVariant::with('attributes.attributeValue')->find($variantId) : null;

            if (!$product) {
                return response()->json(['success' => false, 'message' => 'Sản phẩm không tồn tại.'], 400);
            }

            $price = $variant ? $variant->price : $product->price;

            if (!$price || $price <= 0) {
                return response()->json(['success' => false, 'message' => 'Giá sản phẩm không hợp lệ.'], 400);
            }

            if ($variant && $variant->stock_quantity < $quantity) {
                return response()->json(['success' => false, 'message' => 'Số lượng không đủ trong kho.'], 400);
            } elseif (!$variant && $product->stock_quantity < $quantity) {
                return response()->json(['success' => false, 'message' => 'Số lượng không đủ trong kho.'], 400);
            }

            // Đảm bảo giỏ hàng là mảng
            $cart = Session::get('cart', []);
            if (!is_array($cart)) {
                \Log::error('Giỏ hàng không phải là mảng:', ['cart' => $cart]);
                $cart = [];
            }

            // Kiểm tra sản phẩm đã tồn tại trong giỏ hàng
            $productFound = false;
            foreach ($cart as &$item) {
                if (
                    $item['product_id'] === $productId &&
                    (isset($item['variant_id']) ? $item['variant_id'] === $variantId : true)
                ) {
                    $item['quantity'] += $quantity;
                    $productFound = true;
                    break;
                }
            }

            // Nếu sản phẩm chưa tồn tại, thêm mới
            if (!$productFound) {
                $cart[] = [
                    'product_id' => $productId,
                    'variant_id' => $variantId,
                    'quantity' => $quantity,
                    'price' => $price,
                ];
            }

            // Lưu lại giỏ hàng vào session
            Session::put('cart', $cart);

            \Log::info('Giỏ hàng sau khi cập nhật:', $cart);

            return response()->json(['success' => true, 'message' => 'Sản phẩm đã được thêm vào giỏ hàng!', 'cart' => $this->getCartData()]);
        } catch (\Exception $e) {
            \Log::error('Lỗi trong addToCart:', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Có lỗi xảy ra. Vui lòng thử lại sau!'], 500);
        }
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function removeFromCart($productId, $variantId = null)
    {
        try {
            $cart = Session::get('cart', []);

            if (!is_array($cart)) {
                \Log::error('Giỏ hàng không hợp lệ.', ['cart' => $cart]);
                return redirect()->back()->with('error', 'Giỏ hàng không hợp lệ.');
            }

            $updatedCart = array_filter($cart, function ($item) use ($productId, $variantId) {
                return !(($item['product_id'] == $productId) && ($item['variant_id'] == $variantId));
            });

            $updatedCart = array_values($updatedCart); // Sắp xếp lại chỉ số mảng
            Session::put('cart', $updatedCart);

            \Log::info('Giỏ hàng sau khi xóa sản phẩm:', ['cart' => $updatedCart]);

            return redirect()->back()->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng!');
        } catch (\Exception $e) {
            \Log::error('Lỗi khi xóa sản phẩm:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại.');
        }
    }

    public function update(Request $request)
    {
        try {
            $productId = $request->input('product_id');
            $variantId = $request->input('variant_id', null);
            $quantity = $request->input('quantity', 1);

            // Kiểm tra số lượng hợp lệ
            if ($quantity <= 0) {
                return response()->json(['success' => false, 'message' => 'Số lượng không hợp lệ.']);
            }

            $cart = Session::get('cart', []);
            $productFound = false;

            foreach ($cart as &$item) {
                // Kiểm tra sản phẩm và biến thể trong giỏ hàng
                if ($item['product_id'] == $productId && $item['variant_id'] == $variantId) {
                    $item['quantity'] = $quantity;

                    // Cập nhật giá mới nếu có thay đổi
                    $product = Product::find($productId);
                    $variant = $variantId ? ProductVariant::with('attributes.attributeValue')->find($variantId) : null;

                    if ($variant) {
                        $item['price'] = $variant->price;
                    } else {
                        $item['price'] = $product->price;
                    }

                    $productFound = true;
                    break;
                }
            }

            // Nếu không tìm thấy sản phẩm trong giỏ, trả về lỗi
            if (!$productFound) {
                return response()->json(['success' => false, 'message' => 'Sản phẩm không tồn tại trong giỏ hàng.']);
            }

            // Cập nhật giỏ hàng vào session
            Session::put('cart', $cart);

            // Trả về dữ liệu giỏ hàng mới
            return response()->json([
                'success' => true,
                'cart' => $this->getCartData()
            ]);
        } catch (\Exception $e) {
            \Log::error('Lỗi khi cập nhật số lượng:', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Có lỗi xảy ra. Vui lòng thử lại.']);
        }
    }

    public function count()
    {
        $count = session('cart') ? count(session('cart')) : 0;
        return response()->json(['count' => $count]);
    }
    // Lấy thông tin giỏ hàng
    private function getCartData()
    {
        $cart = Session::get('cart', []);
        $cartData = [
            'items' => array_map(function ($item) {
                $product = Product::with('variants.attributes.attributeValue')->find($item['product_id']);
                $variant = isset($item['variant_id']) ? ProductVariant::with('attributes.attributeValue')->find($item['variant_id']) : null;

                if (!$product || ($variant && !$variant->price)) {
                    \Log::warning('Dữ liệu sản phẩm hoặc biến thể không hợp lệ.', ['item' => $item]);
                    return null;
                }

                $variantAttributes = $variant ? $variant->attributes->map(function ($attr) {
                    return [
                        'name' => $attr->attributeValue->attribute->name ?? null,
                        'value' => $attr->attributeValue->value ?? null,
                    ];
                })->toArray() : [];

                return [
                    'product_id' => $item['product_id'],
                    'variant_id' => $item['variant_id'] ?? null,
                    'quantity' => $item['quantity'],
                    'name' => $product->name ?? null,
                    'price' => $variant ? $variant->price : ($product ? $product->price : 0),
                    'image' => $variant ? $variant->image : ($product ? $product->avata : null),
                    'stock_quantity' => $variant ? $variant->stock_quantity : ($product ? $product->stock_quantity : 0),
                    'variant' => $variantAttributes,
                ];
            }, array_filter($cart)), // Loại bỏ các phần tử null
            'total' => array_reduce($cart, function ($carry, $item) {
                $product = Product::find($item['product_id']);
                $variant = isset($item['variant_id']) ? ProductVariant::find($item['variant_id']) : null;
                $price = $variant ? $variant->price : ($product ? $product->price : 0);
                return $carry + $price * $item['quantity'];
            }, 0) + 30000, // Cộng phí ship
        ];

        return $cartData;
    }
}
