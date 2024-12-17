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
class PaymentController extends Controller
{
    public function vnpay_payment(Request $request){
    $data=$request->all();
    $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    $vnp_Returnurl = "http://datn_wd13.test/orders/create";
    $vnp_TmnCode = "CBUFG76T";
    $vnp_HashSecret = "47FRLEZ6HZROYFCX079635906MLC6IEE"; //Chuỗi bí mật

    $vnp_TxnRef = $request->id_donhang; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
    $vnp_OrderInfo = "Thanh toán hóa đơn";
    $vnp_OrderType = "PolyStore";
    $vnp_Amount = $data['total'] * 100;
    $vnp_Locale = "VN";
    $vnp_BankCode = "NCB";
    $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

    $inputData = array(
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
    );

    if (isset($vnp_BankCode) && $vnp_BankCode != "") {
        $inputData['vnp_BankCode'] = $vnp_BankCode;
    }
    if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
        $inputData['vnp_Bill_State'] = $vnp_Bill_State;
    }

    //var_dump($inputData);
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
        $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
    }
    $returnData = array('code' => '00'
        , 'message' => 'success'
        , 'data' => $vnp_Url);
        if (isset($_POST['redirect'])) {
            header('Location: ' . $vnp_Url);
            die();
        } else {
            echo json_encode($returnData);
        }
        // vui lòng tham khảo thêm tại code demo


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
public function generateUniqueOrderCode()
{
    do {
        // Tạo mã đơn hàng bằng cách sử dụng ID người dùng và thời gian hiện tại
        $orderCode = 'ORD-' . Auth::id() . '-' . now()->timestamp;
    } while (Order::where('order_code', $orderCode)->exists());

    return $orderCode;
}

}