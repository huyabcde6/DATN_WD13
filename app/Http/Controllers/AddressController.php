<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function updateAddress(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'address' => 'required|string|max:255', // Đảm bảo địa chỉ hợp lệ
            'number_phone' => 'required|numeric|digits_between:10,15', // Đảm bảo số điện thoại hợp lệ
        ]);

        // Lấy thông tin người dùng hiện tại
        $user = Auth::user();

        // Cập nhật thông tin
        $user->address = $request->input('address');
        $user->number_phone = $request->input('number_phone');
        $user->save();

        // Quay lại trang trước với thông báo thành công
        return redirect()->back()->with('success', 'Thông tin của bạn đã được cập nhật thành công.');
    }
}
