<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function updateAddress(Request $request)
    {
        // Xác thực đầu vào
        $request->validate([
            'address' => 'required|string|max:255',
        ]);

        // Lấy người dùng hiện tại
        $user = Auth::user();

        // Cập nhật địa chỉ
        $user->address = $request->input('address');
        $user->save();

        // Redirect về trang trước với thông báo thành công
        return redirect()->back()->with('success', 'Địa chỉ của bạn đã được cập nhật thành công.');
    }
}
