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
use App\Models\product;
use App\Models\ProductVariant;
use App\Models\Size;
use App\Mail\OrderStatusChanged;
use App\Models\OrderAction;
use App\Models\OrderStatusHistory;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Hiển thị danh sách các đơn hàng.
     */
    public function index(Request $request)
    {
        // Sử dụng quan hệ 'status' thay vì 'status_donhang_id'
        $query = Auth::user()->order()
            ->with([
                'status',
                'orderDetails.product',
                'orderDetails.product.productVariants'  // Ensure you're including the product variants
            ])
            ->join('order_details', 'order_details.order_id', '=', 'orders.id') // Join order_details to orders
            ->join('product_variants', 'product_variants.id', '=', 'order_details.product_variant_id') // Join product_variants
            ->join('products', 'products.id', '=', 'product_variants.product_id') // Join products to get the product_id
            ->select(
                'orders.*',
                'order_details.product_name',
                'products.id as product_id',  // Get the product_id
                'products.name as product_name',
                'products.price as product_price'
            )
            ->orderBy('orders.created_at', 'desc'); // Execute the query

        // Convert to array and dump it for debugging
        // dd($query->toArray());

        // Lọc theo trạng thái nếu có
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status_donhang_id', $request->status);
        }
        $role = User::whereHas('roles')->where('id', Auth::user()->id)->exists();
        $orders = $query->paginate(3);
        // dd($orders->toArray());
        // Mỗi lần tải 3 đơn hàng
        $reviewedProductIds = Auth::user()->reviews()->pluck('product_id')->toArray();
        // dd($reviewedProductIds);
        // Nếu là request AJAX (khi cuộn hoặc lọc), trả về HTML của orders
        if ($request->ajax()) {
            return view('user.khac.partials.orders', compact('orders'))->render();
        }
        $user = Auth::user();
        return view('user.khac.my_account', compact('orders', 'user', 'role', 'reviewedProductIds'));
    }
    public function show($id)
    {
        $order = Order::with(['orderDetails.productVariant.product', 'status'])->findOrFail($id);
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
        $selectedCart = Session::get('selected_cart', []);

        if (!empty($selectedCart)) {
            $subTotal = 0;

            foreach ($selectedCart as &$item) {
                // Lấy thông tin sản phẩm
                $product = Product::find($item['product_id']);
                if (!$product) {
                    return redirect()->route('cart.index')->with('error', 'Sản phẩm không tồn tại.');
                }

                // Gắn tên sản phẩm
                $item['name'] = $product->name;
                $item['slug'] = $product->slug;

                // Kiểm tra nếu có biến thể
                if (isset($item['variant_id'])) {
                    $variant = ProductVariant::find($item['variant_id']);
                    if ($variant) {
                        $item['variant_name'] = $variant->product_code; // Ví dụ: Mã biến thể
                    }
                }

                if (!isset($item['price']) || !isset($item['quantity'])) {
                    return redirect()->route('cart.index')->with('error', 'Giỏ hàng có dữ liệu không hợp lệ.');
                }

                $subTotal += $item['price'] * $item['quantity'];
            }

            $shippingFee = 30000; // Phí vận chuyển
            $total = $subTotal + $shippingFee;

            return view('user.sanpham.thanhtoan', compact(
                'selectedCart',
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
                $params['date_order'] = now(); // Thời gian đặt hàng
                $params['status_donhang_id'] = 1;
                $params['payment_status'] = 'Chưa thanh toán'; // Trạng thái mặc định

                // Tạo đơn hàng
                $order = Order::create($params);
                $orderId = $order->id;

                // Lấy giỏ hàng tạm thời từ session
                $selectedCart = Session::get('selected_cart', []);

                if (empty($selectedCart)) {
                    throw new \Exception('Giỏ hàng để thanh toán trống.');
                }

                // Trường hợp "Thanh toán giỏ hàng"
                foreach ($selectedCart as $item) {
                    $productVariant = ProductVariant::with('attributes.attributeValue')->find($item['variant_id']);

                    if (!$productVariant) {
                        throw new \Exception('Biến thể sản phẩm không tồn tại.');
                    }

                    // Kiểm tra lại số lượng kho trước khi giảm
                    if ($productVariant->stock_quantity < $item['quantity']) {
                        throw new \Exception('Số lượng sản phẩm không đủ trong kho');
                    }

                    // Cập nhật số lượng sản phẩm trong kho
                    $productVariant->stock_quantity -= $item['quantity'];
                    $productVariant->save();

                    $order->orderDetails()->create([
                        'order_id' => $orderId,
                        'product_variant_id' => $productVariant->id,
                        'quantity' => $item['quantity'],
                        'attributes' => $productVariant->attributes->map(function ($attr) {
                            return [
                                'name' => $attr->attributeValue->attribute->name,
                                'value' => $attr->attributeValue->value,
                            ];
                        }),
                        'price' => $item['price'],
                        'product_name' => $productVariant->product->name ?? 'Unknown',
                        'product_avata' => $productVariant->product->avata ?? null,
                    ]);
                }
                
                if (Session::has('discount_applied')) {
                    $couponId = Session::get('discount_applied');
                    $coupon = Coupons::find($couponId);

                    // Nếu không tìm thấy mã hoặc số lượng mã đã hết
                    if (!$coupon || $coupon->total_quantity <= $coupon->used_quantity) {
                        // Xóa mã giảm giá trong session để tránh lỗi lặp lại
                        Session::forget('discount_applied');

                        // Xóa đơn hàng vừa tạo
                        $order->delete();

                        // Trả về trang giỏ hàng kèm thông báo lỗi
                        return redirect()->route('cart.index')->with('error', 'Mã giảm giá đã hết lượt sử dụng.');
                    }

                    // Tăng số lượng đã sử dụng nếu mã hợp lệ
                    $this->incrementCouponUsage($coupon);
                }
                // Xóa sản phẩm đã thanh toán khỏi giỏ hàng chính
                $cart = Session::get('cart', []);
                $updatedCart = array_filter($cart, function ($cartItem) use ($selectedCart) {
                    foreach ($selectedCart as $selectedItem) {
                        if (
                            $cartItem['product_id'] === $selectedItem['product_id'] &&
                            ($cartItem['variant_id'] ?? null) === ($selectedItem['variant_id'] ?? null)
                        ) {
                            return false; // Xóa sản phẩm nếu nó có trong selected_cart
                        }
                    }
                    return true; // Giữ lại sản phẩm không có trong selected_cart
                });

                // Lưu lại giỏ hàng đã cập nhật
                Session::put('cart', array_values($updatedCart));

                // Xóa selected_cart
                Session::forget('selected_cart');
                // Kiểm tra mã giảm giá
                
                // Kiểm tra phương thức thanh toán
                if ($request->input('method') === "VNPAY") {
                    DB::commit(); // Lưu đơn hàng trước khi chuyển hướng
                    return $this->processVNP($order);
                }

                // Gửi email xác nhận đơn hàng
                Mail::to(Auth::user()->email)->send(new OrderConfirmationMail($order));

                DB::commit();
                return redirect()->route('thank_you', ['order' => $order->id])->with('success', 'Đơn hàng đã được tạo thành công.');
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Lỗi tạo đơn hàng: ' . $e->getMessage());
                return redirect()->route('cart.index')->with('error', 'Có lỗi xảy ra trong quá trình tạo đơn hàng: ' . $e->getMessage());
            }
        }

        return redirect()->route('cart.index')->with('error', 'Phương thức không hợp lệ.');
    }


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
                Mail::to(Auth::user()->email)->send(new OrderConfirmationMail($order));
                if (session('discount_applied')) {
                    $coupon = Coupons::where('id', session('discount_applied'))->first();
                    $coupon->increment('used_quantity');
                }
                return redirect()->route('thank_you', ['order' => $order->id])->with('success', 'Thanh toán thành công.');
            }
        } else {
            // Thanh toán thất bại hoặc bị hủy
            if ($order) {
                $order->update([
                    'payment_status' => 'thất bại',
                    'method' => 'VNPAY',
                    'status_donhang_id' => StatusDonHang::getIdByType(StatusDonHang::DA_HUY),
                ]);
                // Khôi phục sản phẩm về kho và thêm lại vào giỏ hàng
                $restoredCart = [];
                foreach ($order->orderDetails as $orderDetail) {
                    // Khôi phục số lượng trong kho
                    $productVariant = $orderDetail->productVariant;
                    if ($productVariant) {
                        $productVariant->stock_quantity += $orderDetail->quantity;
                        $productVariant->save();
                    }

                    // Thêm sản phẩm vào session giỏ hàng
                    $restoredCart[] = [
                        'product_id' => $orderDetail->productVariant->product_id,
                        'variant_id' => $orderDetail->product_variant_id,
                        'price' => $orderDetail->price,
                        'quantity' => $orderDetail->quantity,
                    ];
                }

                // Lấy giỏ hàng hiện tại và hợp nhất với sản phẩm đã khôi phục
                $cart = Session::get('cart', []);
                $updatedCart = array_merge($cart, $restoredCart);
                Session::put('cart', $updatedCart);
                // Xóa bỏ đơn hàng khi thanh toán thất bại
                $order->delete();
            }
            return redirect()->route('cart.index')->with('error', 'Thanh toán thất bại, đơn hàng đã bị hủy.');
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
                $previousStatus = $order->status;
                $params = [];

                // Kiểm tra hành động hủy đơn hàng hoặc giao hàng
                if ($request->has('huy_don_hang')) {
                    $params['status_donhang_id'] = StatusDonHang::getIdByType(StatusDonHang::DA_HUY);
                    foreach ($order->orderDetails as $orderDetail) {
                        $productVariant = $orderDetail->productVariant;
                        if ($productVariant) {
                            // Cộng lại số lượng sản phẩm vào kho
                            $productVariant->stock_quantity += $orderDetail->quantity;
                            $productVariant->save();
                        } else {
                            // Nếu không có variant, ghi lại log để theo dõi
                            Log::warning("Không tìm thấy productVariant cho đơn hàng chi tiết ID: " . $orderDetail->id);
                        }
                    }

                    // Lưu hành động vào bảng order_actions
                    OrderAction::create([
                        'user_id' => Auth::id(),
                        'order_id' => $order->id, // Hoặc có thể là product_variant nếu cần
                        'action' => 'cancel',
                        'comment' => 'Đơn hàng đã bị hủy.',
                    ]);
                } elseif ($request->has('hoan_thanh')) {
                    $params['status_donhang_id'] = StatusDonHang::getIdByType(StatusDonHang::HOAN_THANH);
                    $params['payment_status'] = 'đã thanh toán';
                    $this->moveOrderToInvoice($order);

                    // Lưu hành động vào bảng order_actions
                    OrderAction::create([
                        'user_id' => Auth::id(),
                        'order_id' => $order->id,
                        'action' => 'complete',
                        'comment' => 'Đơn hàng đã hoàn thành.',
                    ]);
                } elseif ($request->has('cho_xac_nhan')) {
                    $params['status_donhang_id'] = StatusDonHang::getIdByType(StatusDonHang::CHO_HOAN);
                    if ($request->filled('return_reason')) {
                        $params['return_reason'] = $request->input('return_reason');
                    } else {
                        throw new \Exception('Bạn phải cung cấp lý do trả hàng.');
                    }

                    // Lưu hành động vào bảng order_actions
                    OrderAction::create([
                        'user_id' => Auth::id(),
                        'order_id' => $order->id,
                        'action' => 'return',
                        'comment' => $request->input('return_reason'),
                    ]);
                } else {
                    throw new \Exception('Hành động không hợp lệ.');
                }

                // Cập nhật trạng thái đơn hàng
                $order->update($params);
                $currentStatus = $order->fresh()->status;
                $this->logStatusChange($order, $previousStatus, $currentStatus);
                broadcast(new OderEvent($order));
                Mail::to(Auth::user()->email)->send(new OrderStatusChanged($order));
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



    private function logStatusChange(Order $order, $previousStatus, $currentStatus)
    {
        OrderStatusHistory::create([
            'order_id' => $order->id,
            'previous_status_id' => $previousStatus ? $previousStatus->id : null, // Trạng thái trước khi thay đổi
            'current_status_id' => $currentStatus->id, // Trạng thái hiện tại
            'changed_at' => now(), // Thời gian thay đổi
            'changed_by' => Auth::id(), // Người thay đổi
        ]);
    }
    protected function moveOrderToInvoice(Order $order)
    {
        // Kiểm tra nếu hóa đơn đã tồn tại (tránh trùng lặp)
        if ($order->toInvoice()->exists()) {
            return;
        }

        $invoice = \App\Models\Invoice::create([
            'invoice_code' => $order->order_code,
            'user_id' => $order->user_id,
            'order_id' => $order->id,
            'nguoi_nhan' => $order->nguoi_nhan,
            'email' => $order->email,
            'number_phone' => $order->number_phone,
            'address' => $order->address,
            'status_donhang_id' => $order->status_donhang_id,
            'ghi_chu' => $order->ghi_chu,
            'method' => $order->method,
            'payment_status' => $order->payment_status,
            'subtotal' => $order->subtotal,
            'discount' => $order->discount,
            'shipping_fee' => $order->shipping_fee,
            'total_price' => $order->total_price,
            'date_invoice' => $order->created_at,
        ]);

        // Sao chép chi tiết đơn hàng sang chi tiết hóa đơn
        foreach ($order->orderDetails as $orderDetail) {
            $invoice->invoiceDetails()->create([
                'product_name'  => $orderDetail->product_name,
                'product_avata'  => $orderDetail->product_avata,
                'attributes'    => is_string($orderDetail->attributes)
                    ? json_decode($orderDetail->attributes, true)
                    : $orderDetail->attributes,
                'quantity' => $orderDetail->quantity,
                'price' => $orderDetail->price,
            ]);
        }
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
        Session::put('discount_applied', $coupon->id);

        // Tăng số lượng mã đã sử dụng
        // $coupon->increment('used_quantity');

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
    private function incrementCouponUsage($coupon)
    {
        // Kiểm tra và tăng số lượng mã giảm giá đã sử dụng
        if ($coupon) {
            $coupon->increment('used_quantity');

            // Đảm bảo số lượng mã đã sử dụng không vượt quá tổng số lượng
            if ($coupon->used_quantity > $coupon->total_quantity) {
                $coupon->used_quantity = $coupon->total_quantity;
                $coupon->save();
            }
        }
        Session::forget('discount_applied');
    }
}
