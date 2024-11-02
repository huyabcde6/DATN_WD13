<?php

namespace App\Http\Controllers;

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
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $orders = Auth::user()->order()->with('status')->get();;

        return view('user.khac.my_account', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['orderDetails.productDetail.products', 'status'])->findOrFail($id);
        return view('user.khac.order_detail', compact('order'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();

        $cartItems = Session::get('cart', []);
        if(!empty($cartItems)){

            $subTotal = 0;
            foreach ($cartItems as $item) {
                $subTotal += $item['price'] * $item['quantity'];
            }

            $shippingFee = 5.00;
            $total = $subTotal + $shippingFee;

            return view('user.sanpham.thanhtoan', compact(
                'cartItems', 'subTotal', 'shippingFee', 'total', 
                'user'
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
                return redirect()->route('orders.index')->with('success', 'Đơn hàng đã được tạo thành công.');

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

    public function update(Request $request, $id)
    {
        if ($request->isMethod('POST')) {
            DB::beginTransaction();

            try {
                $order = Order::findOrFail($id);
                $params = [];

                if ($request->has('huy_don_hang')) {
                    $params['status_donhang_id'] = StatusDonHang::getIdByType(StatusDonHang::DA_HUY);
                } elseif ($request->has('da_giao_hang')) {
                    $params['status_donhang_id'] = StatusDonHang::getIdByType(StatusDonHang::DA_GIAO_HANG);
                } else {
                    throw new \Exception('Hành động không hợp lệ.');
                }

                $order->update($params);

                DB::commit();
                return redirect()->route('orders.index')->with('success', 'Đơn hàng đã được cập nhật thành công.');
            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error('Order update error: ' . $e->getMessage());
                return redirect()->route('orders.index')->with('error', 'Có lỗi xảy ra trong quá trình cập nhật đơn hàng: ' . $e->getMessage());
            }
        }
        return redirect()->route('orders.index')->with('error', 'Phương thức không hợp lệ.');
    }
    
}