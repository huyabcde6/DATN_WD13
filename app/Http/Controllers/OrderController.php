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
    public function index(Request $request)
    {
        // Sử dụng quan hệ 'status' thay vì 'status_donhang_id'
        $query = Auth::user()->order()->with(['status', 'orderDetails.products'])->orderBy('created_at', 'desc');

        // Lọc theo trạng thái nếu có
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status_donhang_id', $request->status);
        }

        $orders = $query->paginate(3); // Mỗi lần tải 3 đơn hàng

        // Nếu là request AJAX (khi cuộn hoặc lọc), trả về HTML của orders
        if ($request->ajax()) {
            return view('user.khac.partials.orders', compact('orders'))->render();
        }

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
    public function create(Request $request)
    {   
        $user = Auth::user();

        if ($request->isMethod('post')) {
            $productId = $request->input('products_id');
            $quantity = $request->input('quantity');
            $size = $request->input('size');
            $color = $request->input('color');
    
            // Lấy sản phẩm từ CSDL
            $product = Product::find($productId);
            if (!$product) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sản phẩm không tồn tại.'
                ], 404);
            }
    
            // Tính tổng tiền
            $subTotal = $product->price * $quantity;
            $shippingFee = 30000; // 30,000 VND phí vận chuyển
            $total = $subTotal + $shippingFee;
    
            // Trả về JSON để JavaScript điều hướng tới trang thanh toán
            return response()->json([
                'status' => 'success',
                'message' => 'Đơn hàng đã được xử lý.',
                'redirect_url' => route('checkout.page', [
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'size' => $size,
                    'color' => $color,
                    'sub_total' => $subTotal,
                    'shipping_fee' => $shippingFee,
                    'total' => $total
                ])
            ]);
        }
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
                $carts = Session::get('cart', []); // Giỏ hàng trong session

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
                if ($request->input('method') === "VNPAY") {
                    
                    // Lưu giao dịch và chuyển hướng đến VNP
                    DB::commit(); // Lưu đơn hàng trước khi chuyển hướng
                    return $this->processVNP($order); // Hàm xử lý thanh toán VNP
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
     * Xử lý thanh toán qua VNP
     */
    private function processVNP($order)
    {
        // Tạo URL thanh toán VNP
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('orders.vnp.return'); // URL trả về sau khi thanh toán
        $vnp_TmnCode = "CBUFG76T"; // Mã website VNP
        $vnp_HashSecret = "47FRLEZ6HZROYFCX079635906MLC6IEE"; // Chuỗi bí mật VNP

        $vnp_TxnRef = $order->order_code; // Mã đơn hàng
        $vnp_OrderInfo = "Thanh toán đơn hàng #" . $order->order_code;
        $vnp_OrderType = "PolyStore";
        $vnp_Amount = $order->total_price * 100; // Số tiền (nhân 100 vì VNP dùng đơn vị VND nhỏ nhất)
        $vnp_Locale = 'vn';
        $vnp_BankCode = '';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        ];
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return redirect($vnp_Url);
    }

    /**
     * Xử lý callback từ VNP
     */
    public function handleVNPReturn(Request $request)
    {
        $vnp_ResponseCode = $request->input('vnp_ResponseCode');
        $vnp_TxnRef = $request->input('vnp_TxnRef');

        $order = Order::where('order_code', $vnp_TxnRef)->first();
        
        if ($vnp_ResponseCode == '00') {
            // Thanh toán thành công
            if ($order) {
                $order->update([
                    'payment_status' => 'đã thanh toán',
                    'method' => 'VNPAY'
                ]);
                Session::forget('cart');
                return redirect()->route('orders.index')->with('success', 'Thanh toán thành công.');
            }
        } else {
            // Thanh toán thất bại hoặc bị hủy
            if ($order) {
                $order->update([
                    'payment_status' => 'thất bại',
                    'method' => 'VNPAY',
                    'status_donhang_id' => StatusDonHang::getIdByType(StatusDonHang::DA_HUY),
                ]);
            }
            return redirect()->route('cart.index')->with('error', 'Thanh toán thất bại.');
        }
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
                    $params['payment_status'] = 'đã thanh toán';
                } elseif ($request->has('cho_xac_nhan')) {
                    $params['status_donhang_id'] = StatusDonHang::getIdByType(StatusDonHang::CHO_HOAN);
                    if ($request->filled('return_reason')) {
                        $params['return_reason'] = $request->input('return_reason');
                    } else {
                        throw new \Exception('Bạn phải cung cấp lý do trả hàng.');
                    }
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
