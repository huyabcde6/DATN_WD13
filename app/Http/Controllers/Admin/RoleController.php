<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class RoleController extends Controller
{
    public function __construct(){
        $this->middleware('permission:Xem danh sách vai trò', ['only' => ['index']]);
        $this->middleware('permission:Thêm mới vai trò', ['only' => ['create', 'store']]);
        $this->middleware('permission:Cấp/sửa quyền', ['only' => ['addPermissionToRole', 'givePermissionToRole']]);
        $this->middleware('permission:Sửa vai trò', ['only' => ['update', 'edit']]);
    }

    public function index(Request $request)
    {
        $query = Role::query();

        // Tìm kiếm theo tên vai trò
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Sắp xếp theo cột
        if ($request->has('sort') && $request->has('direction')) {
            $query->orderBy($request->sort, $request->direction);
        }

        $roles = $query->paginate(10); // Phân trang 10 bản ghi mỗi trang

        return view('role-permission.role.index', compact('roles'));
    }

    public function create()
    {
        return view('role-permission.role.create');
    }

    public function store(RoleRequet $request)
    {

        Role::create([
            'name' => $request->name
        ]);

        return redirect('roles')->with('status', 'Role Created Successfully');
    }

    public function edit(Role $role)
    {
        return view('role-permission.role.edit', compact('role'));
    }

    public function update(RoleRequet $request, Role $role)
    {
        $role ->update([
            'name' => $request->name
        ]);

        return redirect('roles')->with('status', 'Role Updated Successfully');
    }

    public function destroy($roleId)
    {
        $role = Role::find($roleId);
        $role->delete();
        return redirect('roles')->with('status', 'Role Deleted Successfully');
    }

    public function addPermissionToRole($roleId)
    {
        $permission = Permission::get();
        $role = Role::findOrFail($roleId);
        $rolePermission = DB::table('role_has_permissions')
                                            ->where('role_has_permissions.role_id', $role->id)
                                            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
                                            ->all();
        return view('role-permission.role.add-permission', [
            'role' => $role,
            'permission' => $permission,
            'rolePermissions' => $rolePermission
        ]);
    }

    public function givePermissionToRole(Request $request, $roleId)
    {
        $request->validate([
            'permission' => 'required'
        ]);
        $role = Role::findOrFail($roleId);
        $role->syncPermissions($request->permission);

        return redirect()->back()->with('status', 'Permissions added to role');
    }
}
