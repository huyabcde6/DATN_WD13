<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller

{
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
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|max:20',
            'roles' => 'required'
        ],
        [
            'name.required' => 'Tên không được để trống',
            'name.string' => 'Tên phải là chuỗi',
            'name.max' => 'Tên không vượt quá 255 ký tự',
            'password.required' => 'Password không được để trống',
            'password.string' => 'Password phải là chuỗi',
            'password.min' => 'Password phải có độ dài từ 8 đến 20 ký tự',
            'password.max' => 'Password phải có độ dài từ 8 đến 20 ký tự',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại',
            'email.max' => 'Email không được vượt qua 255 ký tự',
            'roles.required' => 'Vui lòng chọn vai trò'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            "password" => Hash::make($request->password),
        ]);
        $user->syncRoles($request->roles);

        return redirect('/users')->with('status', 'User đăng nhập thành công');
    }

    /**
     * Display the specified resource.
     */
    public function edit(User $user)
    {

        $roles = Role::pluck('name', 'name')->all();
        $userRoles = $user->roles->pluck('name','name')->all();
        return view('role-permission.user.edit', [
            'user' => $user,
            'roles'=> $roles,
            'userRoles' => $userRoles
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|max:20',
            'roles' => 'required'
        ],
        [
            'name.required' => 'Tên không được để trống',
            'name.string' => 'Tên phải là chuỗi',
            'name.max' => 'Tên không vượt quá 255 ký tự',
            'password.required' => 'Password không được để trống',
            'password.string' => 'Password phải là chuỗi',
            'password.min' => 'Password phải có độ dài từ 8 đến 20 ký tự',
            'password.max' => 'Password phải có độ dài từ 8 đến 20 ký tự',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại',
            'email.max' => 'Email không được vượt qua 255 ký tự',
            'roles.required' => 'Vui lòng chọn vai trò'
        ]);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];
        if(!empty($request->password)){
            $data += [
                'password' => Hash::make($request->password),
            ];
        }
        $user->update($data);
        $user->syncRoles($request->roles);

        return redirect('/users')->with('status', 'User cập nhập thành công');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();
        return redirect('/users')->with('success', 'Xóa thành công!');
    }

}
