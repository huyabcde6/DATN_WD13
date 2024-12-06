<?php

namespace App\Http\Controllers;

use App\Events\StatusOder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductDetail;
use App\Models\StatusDonHang;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmationMail;
use App\Models\Coupon_Conditions;
use App\Models\Coupons;
use App\Models\products;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Hiển thị danh sách các đơn hàng.
     */
    public function index()
    {
        $orders = Auth::user()->order()->with('status')->get(); // Lấy đơn hàng của người dùng kèm theo trạng thái
        return view('user.khac.my_account', compact('orders'));
    }

    /**
     * Hiển thị chi tiết của một đơn hàng cụ thể.
     */
    public function show($id)
    {
        $order = Order::with(['orderDetails.productDetail.products', 'status'])->findOrFail($id);
        return view('user.khac.order_detail', compact('order'));
    }

    /**
     * Hiển thị form tạo đơn hàng mới.
     */
    public function create()
    {
        $user = Auth::user();

        // Lấy các sản phẩm trong giỏ hàng từ session
        $cartItems = Session::get('cart', []);
        if (!empty($cartItems)) {

            $subTotal = 0;
            foreach ($cartItems as $item) {
                $subTotal += $item['price'] * $item['quantity']; // Tính tổng tiền của giỏ hàng
            }

            // Phí vận chuyển bằng VND
            $shippingFee = 30000; // 30,000 VND
            $total = $subTotal + $shippingFee; // Tổng cộng bao gồm phí vận chuyển

            return view('user.sanpham.thanhtoan', compact(
                'cartItems',
                'subTotal',
                'shippingFee',
                'total',
                'user'
            ));
        }

        return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn hiện tại trống.');
    }

    /**
     * Lưu trữ một đơn hàng mới vào cơ sở dữ liệu.
     */
    public function store(Request $request)
    {
        if ($request->isMethod('POST')) {
            DB::beginTransaction();
            try {
                // Chuẩn bị dữ liệu cho đơn hàng
                $params = $request->except('_token');
                $params['order_code'] = $this->generateUniqueOrderCode(); // Tạo mã đơn hàng duy nhất
                $params['date_order'] = now(); // Lấy thời gian hiện tại
                $params['status_donhang_id'] = 1; // Trạng thái đơn hàng mặc định là chờ xử lý

                // Tạo đơn hàng
                $order = Order::query()->create($params);
                $orderId = $order->id;
                $carts = Session::get('cart', []);

                // Thêm chi tiết đơn hàng
                foreach ($carts as $productDetailId => $value) {
                    $orderDetail = $order->orderDetails()->create([
                        'order_id' => $orderId,
                        'product_detail_id' => $productDetailId,
                        'quantity' => $value['quantity'],
                        'color' => $value['color'],
                        'size' => $value['size'],
                        'price' => $value['price'],
                    ]);

                    // Giảm số lượng sản phẩm trong kho sau khi mua
                    $productDetail = ProductDetail::find($productDetailId);
                    if ($productDetail) {
                        $productDetail->quantity -= $value['quantity'];
                        $productDetail->save();
                    }
                }

                DB::commit();

                // Gửi email xác nhận đơn hàng
                Mail::to(Auth::user()->email)->send(new OrderConfirmationMail($order));

                // Xóa giỏ hàng trong session
                Session::put('cart', []);
                return redirect()->route('orders.index')->with('success', 'Đơn hàng đã được tạo thành công.');
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Lỗi tạo đơn hàng: ' . $e->getMessage());
                return redirect()->route('cart.index')->with('error', 'Có lỗi xảy ra trong quá trình tạo đơn hàng: ' . $e->getMessage());
            }
        }

        return redirect()->route('cart.index')->with('error', 'Phương thức không hợp lệ.');
    }

    /**
     * Tạo mã đơn hàng duy nhất.
     */
    public function generateUniqueOrderCode()
    {
        do {
            // Tạo mã đơn hàng bằng cách sử dụng ID người dùng và thời gian hiện tại
            $orderCode = 'ORD-' . Auth::id() . '-' . now()->timestamp;
        } while (Order::where('order_code', $orderCode)->exists());

        return $orderCode;
    }

    /**
     * Cập nhật trạng thái đơn hàng (hủy hoặc đã giao).
     */
    public function update(Request $request, $id)
    {
        if ($request->isMethod('POST')) {
            DB::beginTransaction();

            try {
                $order = Order::findOrFail($id);
                $params = [];

                // Kiểm tra hành động hủy đơn hàng hoặc giao hàng
                if ($request->has('huy_don_hang')) {
                    $params['status_donhang_id'] = StatusDonHang::getIdByType(StatusDonHang::DA_HUY);
                } elseif ($request->has('da_giao_hang')) {
                    $params['status_donhang_id'] = StatusDonHang::getIdByType(StatusDonHang::DA_GIAO_HANG);
                } else {
                    throw new \Exception('Hành động không hợp lệ.');
                }

                // Cập nhật trạng thái đơn hàng
                $order->update($params);

                DB::commit();
                return redirect()->route('orders.index')->with('success', 'Đơn hàng đã được cập nhật thành công.');
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Lỗi cập nhật đơn hàng: ' . $e->getMessage());
                return redirect()->route('orders.index')->with('error', 'Có lỗi xảy ra trong quá trình cập nhật đơn hàng: ' . $e->getMessage());
            }
        }

        return redirect()->route('orders.index')->with('error', 'Phương thức không hợp lệ.');
    }

    public function applyVoucher(Request $request)
    {
        // Validate dữ liệu từ client
        $request->validate([
            'voucher' => 'required|string',
            'total' => 'required|numeric'
        ]);

        // Kiểm tra mã giảm giá trong DB
        $coupon = Coupons::where('code', $request->voucher)
            ->where('status', 'active')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        // Nếu không tìm thấy mã giảm giá hợp lệ hoặc số lượng mã đã hết
        if (!$coupon || $coupon->total_quantity <= $coupon->used_quantity) {
            return response()->json([
                'error' => 'Mã giảm giá không hợp lệ hoặc đã hết lượt sử dụng.'
            ], 400);
        }

        // Kiểm tra nếu mã đã áp dụng trước đó
        if (Session::has('discount_applied')) {
            // Xóa mã giảm giá cũ nếu có
            Session::forget('discount_applied');
        }

        // Kiểm tra điều kiện áp dụng của mã giảm giá
        $cartTotal = $request->total;
        $discount = 0;

        // Lấy các điều kiện áp dụng của mã giảm giá
        $couponConditions = Coupon_Conditions::where('coupon_id', $coupon->id)->get();

        // Kiểm tra điều kiện áp dụng cho toàn bộ giỏ hàng
        if ($couponConditions->isEmpty()) {
            if ($cartTotal >= $coupon->min_order_amount) {
                $discount = $this->calculateDiscount($coupon, $cartTotal);
            }
        } else {
            // Kiểm tra điều kiện áp dụng cho sản phẩm hoặc danh mục cụ thể
            foreach ($couponConditions as $condition) {
                if ($condition->product_id) {
                    $product = Products::find($condition->product_id);
                    if ($product && $cartTotal >= $coupon->min_order_amount) {
                        $discount = $this->calculateDiscount($coupon, $cartTotal);
                        break;
                    }
                } elseif ($condition->category_id) {
                    $categoryProducts = Products::where('categories_id', $condition->category_id)->get();
                    foreach ($categoryProducts as $product) {
                        if ($cartTotal >= $coupon->min_order_amount) {
                            $discount = $this->calculateDiscount($coupon, $cartTotal);
                            break 2; // Thoát cả vòng lặp
                        }
                    }
                }
            }
        }

        // Nếu không đủ điều kiện để áp dụng mã
        if ($discount <= 0) {
            return response()->json([
                'error' => 'Mã giảm giá không áp dụng được cho đơn hàng này.'
            ], 400);
        }

        // Cập nhật mã giảm giá trong session
        Session::put('discount_applied', $coupon->code);

        // Tăng số lượng mã đã sử dụng
        $coupon->increment('used_quantity');

        // Tính lại tổng tiền sau khi áp dụng giảm giá
        $newTotal = $cartTotal - $discount;

        // Trả dữ liệu về cho client (giao diện)
        // Trả về dữ liệu JSON
        return response()->json([
            'message' => 'Mã giảm giá áp dụng thành công!',
            'discount' => number_format($discount, 0, ',', '.'),
            'total' => number_format($newTotal, 0, ',', '.')
        ]);
    }

    private function calculateDiscount($coupon, $total)
    {
        if ($coupon->discount_type == 'percentage') {
            $discount = ($coupon->discount_value / 100) * $total;
            // Giới hạn giảm giá tối đa (nếu có)
            return $coupon->max_discount_amount ? min($discount, $coupon->max_discount_amount) : $discount;
        } else {
            // Giảm giá cố định
            return min($coupon->discount_value, $total);
        }
    }
}
