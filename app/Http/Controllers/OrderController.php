<?php

namespace App\Http\Controllers;

use App\Events\OderEvent;
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
use App\Models\Color;
use App\Models\Coupon_Conditions;
use App\Models\Coupons;
use App\Models\products;
use App\Models\Size;
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
        $role = User::whereHas('roles')->where('id', Auth::user()->id)->exists();
        $orders = $query->paginate(3); // Mỗi lần tải 3 đơn hàng

        // Nếu là request AJAX (khi cuộn hoặc lọc), trả về HTML của orders
        if ($request->ajax()) {
            return view('user.khac.partials.orders', compact('orders'))->render();
        }
        $user = Auth::user();
        return view('user.khac.my_account', compact('orders', 'user', 'role'));
    }
    public function show($id)
    {
        $order = Order::with(['orderDetails.productDetail.products', 'status'])->findOrFail($id);
        $totalAmount = $order->orderDetails->sum(function ($detail) {
            return $detail->price * $detail->quantity;
        });
        return view('user.khac.order_detail', compact('order', 'totalAmount'));
    }

    /**
     * Hiển thị form tạo đơn hàng mới.
     */
    public function create()
    {
        $user = Auth::user();
        // Lấy các sản phẩm trong giỏ hàng từ session
        $cartItems = Session::get('cart', []);
        // dd($cartItems);
        if (!empty($cartItems)) {

            $subTotal = 0;
            foreach ($cartItems as $item) {
                $subTotal += $item['price'] * $item['quantity']; // Tính tổng tiền của giỏ hàng
            }
            $mua = 'giohang';
            // Phí vận chuyển bằng VND
            $shippingFee = 30000; // 30,000 VND
            $total = $subTotal + $shippingFee; // Tổng cộng bao gồm phí vận chuyển

            return view('user.sanpham.thanhtoan', compact(
                'cartItems',
                'subTotal',
                'shippingFee',
                'total',
                'user',
                'mua'
            ));
        }

        return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn hiện tại trống.');
    }
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
                // Thêm chi tiết đơn hàng
                if ($request->mua === 'muangay') {
                    $order->orderDetails()->create([
                        'order_id' => $orderId,
                        'product_detail_id' => $request->product_detail_id,
                        'quantity' => $request->quantity,
                        'color' => $request->color,
                        'size' => $request->size,
                        'price' => $request->price,
                    ]);

                    // Giảm số lượng sản phẩm trong kho
                    $productDetail = ProductDetail::find($request->product_detail_id); // Tìm sản phẩm trong kho
                    if ($productDetail) {
                        if ($productDetail->quantity >= $request->quantity) { // Kiểm tra xem kho có đủ số lượng không
                            $productDetail->quantity -= $request->quantity; // Giảm số lượng trong kho
                            $productDetail->save(); // Lưu lại thay đổi
                        } else {
                            // Xử lý trường hợp không đủ hàng
                            throw new \Exception('Số lượng sản phẩm không đủ trong kho');
                        }
                    }
                } else {
                    // Trường hợp "Thanh toán giỏ hàng"

                    $carts = Session::get('cart', []); // Giỏ hàng trong session
                    foreach ($carts as $productDetailId => $value) {
                        $order->orderDetails()->create([
                            'order_id' => $orderId,
                            'product_detail_id' => $productDetailId,
                            'quantity' => $value['quantity'],
                            'color' => $value['color'] ?? null,
                            'size' => $value['size'] ?? null,
                            'price' => $value['price'],
                        ]);
                    }
                    // Giảm số lượng sản phẩm trong kho sau khi mua
                    $productDetail = ProductDetail::find($productDetailId);
                    if ($productDetail) {
                        $productDetail->quantity -= $value['quantity'];
                        $productDetail->save();
                    }
                    Session::forget('cart');
                }

                // Xóa giỏ hàng nếu đơn hàng được tạo từ giỏ hàng


                if ($request->input('method') === "VNPAY") {
                    // Lưu giao dịch và chuyển hướng đến VNP
                    DB::commit(); // Lưu đơn hàng trước khi chuyển hướng
                    return $this->processVNP($order); // Hàm xử lý thanh toán VNP
                }
                DB::commit();

                // Gửi email xác nhận đơn hàng
                Mail::to(Auth::user()->email)->send(new OrderConfirmationMail($order));
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
                broadcast(new OderEvent($order));
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
            'total' => 'required|numeric',
            'id_sp' => 'required|array',  // Thêm điều kiện kiểm tra id_sp
            'id_sp.*' => 'required|numeric',  // Kiểm tra từng sản phẩm trong id_sp
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
            Session::forget('discount_applied');
        }

        // Kiểm tra điều kiện áp dụng của mã giảm giá
        $cartTotal = $request->total;
        $discount = 0;
        $couponConditions = Coupon_Conditions::where('coupon_id', $coupon->id)->get();
        $isApplicable = false;

        if ($couponConditions->isEmpty()) {
            // Nếu không có điều kiện cụ thể, chỉ kiểm tra giá trị đơn hàng
            if ($cartTotal >= $coupon->min_order_amount) {
                $isApplicable = true;
            }
        } else {
            // Duyệt qua các điều kiện áp dụng
            foreach ($couponConditions as $condition) {
                if ($condition->product_id) {
                    // Kiểm tra mã giảm giá áp dụng cho sản phẩm cụ thể
                    if (in_array($condition->product_id, $request->id_sp)) {
                        $isApplicable = true;
                        break;
                    }
                } elseif ($condition->category_id) {
                    // Kiểm tra mã giảm giá áp dụng cho danh mục cụ thể
                    $categoryProducts = Products::where('categories_id', $condition->category_id)
                        ->whereIn('id', $request->id_sp)  // Lọc sản phẩm trong giỏ hàng thuộc danh mục này
                        ->get();
                    if ($categoryProducts->isNotEmpty()) {
                        $isApplicable = true;
                        break;
                    }
                }
            }
        }

        // Nếu điều kiện áp dụng thỏa mãn, tính giảm giá
        if ($isApplicable) {
            $discount = $this->calculateDiscount($coupon, $cartTotal);

            // Đảm bảo số tiền giảm không vượt quá số tiền giảm tối đa
            if ($coupon->max_discount_amount && $discount > $coupon->max_discount_amount) {
                $discount = $coupon->max_discount_amount;
            }
        }

        // Nếu không đủ điều kiện để áp dụng mã
        if ($discount <= 0) {
            return response()->json([
                'error' => 'Mã giảm giá không áp dụng được cho đơn hàng này.'
            ], 400);
        }

        // Kiểm tra số tiền giảm có vượt quá số tiền giảm tối đa không
        if ($coupon->max_discount_amount && $discount > $coupon->max_discount_amount) {
            $discount = $coupon->max_discount_amount;
        }

        // Cập nhật mã giảm giá trong session
        Session::put('discount_applied', $coupon->code);

        // Tăng số lượng mã đã sử dụng
        $coupon->increment('used_quantity');

        // Tính lại tổng tiền sau khi áp dụng giảm giá
        $newTotal = $cartTotal - $discount;

        // Trả về dữ liệu JSON
        return response()->json([
            'message' => 'Mã giảm giá áp dụng thành công!',
            'discount' => number_format($discount, 0, ',', '.'),
            'total' => number_format($newTotal, 0, ',', '.'),
        ]);
    }

    /**
     * Tính giá trị giảm giá.
     *
     * @param Coupons $coupon
     * @param float $cartTotal
     * @return float
     */
    private function calculateDiscount($coupon, $cartTotal)
    {
        if ($coupon->discount_type === 'percentage') {
            // Tính giảm giá theo phần trăm
            return ($coupon->discount_value / 100) * $cartTotal;
        } elseif ($coupon->discount_type === 'fixed_amount') {
            // Tính giảm giá theo số tiền cố định
            return $coupon->discount_value;
        }

        return 0;
    }
    public function muangay(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'products_id' => 'required|exists:products,id',
            'size' => 'required|integer|exists:sizes,size_id',
            'color' => 'required|integer|exists:colors,color_id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Lấy giỏ hàng từ session
        $productsId = $request->input('products_id');
        $sizeId = $request->input('size');
        $colorId = $request->input('color');
        $quantity = $request->input('quantity');

        $productDetail = ProductDetail::where('products_id', $productsId)
            ->where('size_id', $sizeId)
            ->where('color_id', $colorId)
            ->first();
        $variantKey = $productDetail->id;
        $price = $productDetail->discount_price ? $productDetail->discount_price : $productDetail->price;
        $cartItems[$variantKey] = [
            'product_detail_id' => $productDetail->id,
            'size' => $productDetail->size->value,
            'color' => $productDetail->color->value,
            'quantity' => $quantity,
            'product_name' => $productDetail->products->name,
            'product_id' => $productDetail->products_id,
            'price' => $price, // Dùng giá khuyến mãi nếu có
            'image' => $productDetail->products->avata,
            'slug' => $productDetail->products->slug,
        ];
        $mua = 'muangay';
        $subTotal = $price * $quantity;
        $shippingFee = 30000; // 30,000 VND
        $total = $subTotal + $shippingFee; // Tổng cộng bao gồm phí vận chuyển
        return view('user.sanpham.thanhtoan', compact(
            'cartItems',
            'subTotal',
            'shippingFee',
            'total',
            'user',
            'mua'
        ));
    }
}
