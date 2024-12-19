<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionControler extends Controller
{
    // public function __construct(){
    //     $this->middleware('permission:view permission', ['only' => ['index']]);
    //     $this->middleware('permission:create permission', ['only' => ['create', 'store']]);
    //     $this->middleware('permission:edit permission', ['only' => ['update', 'edit']]);
    //     $this->middleware('permission:delete permission', ['only' => ['destroy']]);
    // }

    public function index(Request $request, $sort_by = 'id', $sort_order = 'asc')
    {
        $query = Permission::query();

        // Tìm kiếm theo tên quyền
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Xử lý sắp xếp
        $validSortColumns = ['id', 'name', 'created_at']; // Các cột hợp lệ để sắp xếp
        $sortBy = in_array($sort_by, $validSortColumns) ? $sort_by : 'id'; // Chọn cột sắp xếp hợp lệ
        $sortOrder = $sort_order === 'desc' ? 'desc' : 'asc'; // Chỉ cho phép 'asc' hoặc 'desc'

        // Áp dụng sắp xếp
        $query->orderBy($sortBy, $sortOrder);

        // Phân trang kết quả
        $permission = $query->paginate(10);

        // Truyền các biến cần thiết vào view
        return view('role-permission.permission.index', [
            'permission' => $permission,
            'sort_by' => $sortBy, // Truyền lại tham số sắp xếp để giữ giá trị trong view
            'sort_order' => $sortOrder, // Truyền lại thứ tự sắp xếp
            'search' => $request->search, // Truyền lại giá trị tìm kiếm
        ]);
    }

    public function create()
    {
        return view('role-permission.permission.create');
    }

    public function store(PermissionRequest $request)
    {
        Permission::create([
            'name' => $request->name
        ]);

        return redirect('permission')->with('status', 'Permission Created Successfully');
    }

    public function edit(Permission $permission)
    {
        return view('role-permission.permission.edit', compact('permission'));
    }

    public function update(PermissionRequest $request, Permission $permission)
    {
        $permission->update([
            'name' => $request->name
        ]);

        return redirect('permission')->with('status', 'Permission Updated Successfully');
    }

    public function destroy($permissionId)
    {
        $permission = Permission::find($permissionId);
        $permission->delete();
        return redirect('permission')->with('status', 'Permission Deleted Successfully');
    }
}
