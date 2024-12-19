<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminController extends Controller

{
    public function index()
    {
        // Lọc tất cả người dùng có vai trò
        $users = User::whereHas('roles')->get();

        // Trả về view với danh sách người dùng
        return view('role-permission.user.index', [
            'users' => $users
        ]);
    }

    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('role-permission.user.create', [
            'roles' => $roles
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            "password" => Hash::make($request->password),
        ]);
        $user->syncRoles($request->roles);

        return redirect('/userAdmin')->with('status', 'Admin thêm mới thành công');
    }

    /**
     * Display the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'name')->all();
        $userRoles = $user->roles->pluck('name', 'name')->all();
        return view('role-permission.user.edit', [
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
        ];
        if (!empty($request->password)) {
            $data += [
                'password' => Hash::make($request->password),
            ];
        }
        $user->update($data);
        $user->syncRoles($request->roles);

        return redirect('/userAdmin')->with('status', 'Admin cập nhập thành công');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();
        return redirect('/userAdmin')->with('success', 'Xóa thành công!');
    }
}
