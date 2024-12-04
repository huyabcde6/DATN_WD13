<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductDetail;
<<<<<<< HEAD
use App\Models\StatusDonHang;
=======
>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmationMail;
<<<<<<< HEAD
use Illuminate\Support\Facades\Log;
=======
>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19

class OrderController extends Controller
{
    /**
<<<<<<< HEAD
     * Hiển thị danh sách các đơn hàng của người dùng.
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
                'cartItems', 'subTotal', 'shippingFee', 'total', 
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
     * Cập nhật trạng thái đơn hàng (Admin chỉ thay đổi trạng thái đơn hàng).
     */
    public function update(Request $request, $id)
    {
        if ($request->isMethod('POST')) {
            Log::info('Request data:', $request->all());
            DB::beginTransaction();

            try {
                $order = Order::findOrFail($id);
                $params = [];

                // Kiểm tra hành động hủy đơn hàng hoặc giao hàng
                if ($request->has('huy_don_hang')) {
                    $params['status_donhang_id'] = StatusDonHang::getIdByType(StatusDonHang::DA_HUY);
                } elseif ($request->has('da_giao_hang')) {
                    $params['status_donhang_id'] = StatusDonHang::getIdByType(StatusDonHang::DA_GIAO_HANG);
                } elseif ($request->has('cho_xac_nhan')) {
                    $params['status_donhang_id'] = StatusDonHang::getIdByType(StatusDonHang::CHO_HOAN);
                    if ($request->filled('return_reason')) {
                        $params['return_reason'] = $request->input('return_reason');
                    } else {
                        throw new \Exception('Bạn phải cung cấp lý do trả hàng.');
                    }
                }else {
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
}
=======
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Lấy thông tin người dùng hiện tại đã đăng nhập
        $user = Auth::user();

        // Lấy giỏ hàng từ session
        $cartItems = Session::get('cart', []);
        if(!empty($cartItems)){

            $subTotal = 0;
            foreach ($cartItems as $item) {
                $subTotal += $item['price'] * $item['quantity'];
            }

            $shippingFee = 5.00;
            $total = $subTotal + $shippingFee;

            // Kiểm tra nếu người dùng đã có thông tin địa chỉ, số điện thoại, email
            $existingAddress = $user->address ?? '';
            $existingPhone = $user->number_phone ?? '';
            $existingEmail = $user->email;

            // Trả về view với thông tin đã điền sẵn
            return view('user.sanpham.thanhtoan', compact(
                'cartItems', 'subTotal', 'shippingFee', 'total', 
                'user', 'existingAddress', 'existingPhone', 'existingEmail'
            ));
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    if ($request->isMethod('POST')) {
        DB::beginTransaction();
        try {
            $params = $request->except('_token');
            $params['order_code'] = $this->generateUniqueOrderCode();
            $params['date_order'] = now();
            $params['status_donhang_id'] = 1;

            $order = Order::query()->create($params);
            $orderId = $order->id;
            $carts = Session::get('cart', []);

            foreach ($carts as $productDetailId => $value) {
                $orderDetail = $order->orderDetails()->create([
                    'order_id' => $orderId,
                    'product_detail_id' => $productDetailId,
                    'quantity' => $value['quantity'],
                    'color' => $value['color'],
                    'size' => $value['size'],
                    'price' => $value['price'],
                ]);

                $productDetail = ProductDetail::find($productDetailId);
                if ($productDetail) {
                    $productDetail->quantity -= $value['quantity'];
                    $productDetail->save();
                }
            }

            DB::commit();

            Mail::to(Auth::user()->email)->send(new OrderConfirmationMail($order));

            Session::put('cart', []);
            return redirect()->route('cart.index')->with('success', 'Đơn hàng đã được tạo thành công.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Order creation error: ' . $e->getMessage());
            return redirect()->route('cart.index')->with('error', 'Có lỗi xảy ra trong quá trình tạo đơn hàng: ' . $e->getMessage());
        }
    }
}


    function generateUniqueOrderCode() {
        do {
            $orderCode = 'ORD-' . Auth::id() . '-' . now()->timestamp;
        } while (Order::where('order_code', $orderCode)->exists());
        return $orderCode;
    }
    
}
>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19
