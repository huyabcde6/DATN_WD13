<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\order;
use App\Models\StatusDonHang;

class UserController extends Controller

{
    public function __construct(){
        $this->middleware('permission:Xem danh sách người dùng', ['only' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::when($request->search, function ($query) use ($request) {
            $query->where('name', 'like', "%{$request->search}%");
        })
            ->latest('id')
            ->whereDoesntHave('roles')
            ->paginate(5);

        return view('admin.users.index', compact('users'));
    }
    public function show($id)
    {
        // Lấy thông tin người dùng
        $user = User::findOrFail($id);

        // Lấy số lượng đơn hàng đã đặt
        $totalOrders = order::where('user_id', $id)->count();

        // Lấy số lượng đơn hàng đã hoàn thành
        $completedOrders = order::where('user_id', $id)
            ->whereHas('status', function ($query) {
                $query->where('type', 'Hoàn thành');
            })
            ->count();

        return view('admin.users.show', compact('user', 'totalOrders', 'completedOrders'));
    }
    public function toggleActivation($id)
    {
        // Tìm người dùng theo ID
        $user = User::findOrFail($id);

        // Thay đổi trạng thái kích hoạt
        $user->status = $user->status == 1 ? 0 : 1;
        $user->save();

        // Trả về thông báo thành công
        return redirect()->route('admin.users.index')->with('success', 'Trạng thái tài khoản đã được cập nhật thành công.');
    }



}
