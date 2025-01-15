<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\OrderAction;

class AdminController extends Controller

{
    public function __construct(){
        $this->middleware('permission:Xem danh sách admin', ['only' => ['index']]);
        $this->middleware('permission:Thêm mới tài khoản admin', ['only' => ['create', 'store']]);
        $this->middleware('permission:Chỉnh sửa vai trò cho admin', ['only' => ['update', 'edit']]);
    }
    public function index()
    {
        // Lọc tất cả người dùng có vai trò
        $users = User::whereHas('roles')->get();
        $notifications = OrderAction::orderBy('created_at', 'desc') // Sắp xếp theo thời gian
            ->limit(10) // Giới hạn số lượng thông báo hiển thị
            ->get();
        $unreadCount = OrderAction::where('is_read', false)->count();
        // Trả về view với danh sách người dùng
        return view('role-permission.user.index', [
            'users' => $users,
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
        ]);
    }

    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        $notifications = OrderAction::orderBy('created_at', 'desc') // Sắp xếp theo thời gian
            ->limit(10) // Giới hạn số lượng thông báo hiển thị
            ->get();
        $unreadCount = OrderAction::where('is_read', false)->count();
        return view('role-permission.user.create', [
            'roles' => $roles,
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users,email', // Loại bỏ ràng buộc định dạng email
            'password' => 'required|string|min:8',
            'roles' => 'required|array',
        ]);
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'], // Lưu email như tài khoản
            'password' => Hash::make($validated['password']),
        ]);
        $user->syncRoles($validated['roles']);

        return redirect('/userAdmin')->with('status', 'Admin thêm mới thành công');
    }

    /**
     * Display the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'name')->all();
        $userRoles = $user->roles->pluck('name', 'name')->all();
        $notifications = OrderAction::orderBy('created_at', 'desc') // Sắp xếp theo thời gian
        ->limit(10) // Giới hạn số lượng thông báo hiển thị
        ->get();
        $unreadCount = OrderAction::where('is_read', false)->count();
        return view('role-permission.user.edit', [
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles,
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Hiển thị dữ liệu để kiểm tra

        // Xác thực dữ liệu
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'roles' => 'required|array', // Yêu cầu mảng roles
        ]);

        // Chuẩn bị dữ liệu để cập nhật
        $data = [
            'name' => $validated['name'],
        ];

        // Cập nhật thông tin người dùng
        $user->update($data);

        // Đồng bộ vai trò
        $user->syncRoles($validated['roles']);

        // Điều hướng lại trang user admin với thông báo
        return redirect('/userAdmin')->with('success', 'User updated successfully.');
    }


}
