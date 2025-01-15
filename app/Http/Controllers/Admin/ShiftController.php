<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Shift;
use Illuminate\Support\Facades\Auth;

class ShiftController extends Controller
{
    public function showAssignShiftForm(User $user)
    {
        $shifts = Shift::all(); // Lấy danh sách ca làm việc
        $assignedShifts = $user->shifts()->get(); // Lấy danh sách ca đã được gán cho user

        return view('role-permission.user.assign-shift', compact('user', 'shifts', 'assignedShifts'));
    }
    public function assignShift(Request $request, User $user)
    {
        $request->validate([
            'shift_id' => 'required|exists:shifts,id',
            'assigned_date' => 'nullable|date',
        ]);

        $user->shifts()->attach($request->shift_id, [
            'assigned_date' => $request->assigned_date ?? now()->toDateString(),
        ]);

        return redirect()->back()->with('success', 'Ca làm việc đã được gán thành công!');
    }
    public function index()
    {
        $shifts = Shift::all(); // Lấy danh sách ca làm việc
        return view('admin.shifts.index', compact('shifts'));
    }
    public function create()
    {
        return view('admin.shifts.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
        ]);
        
        if (strtotime($request->start_time) >= strtotime($request->end_time)) {
            // Trường hợp ca làm việc qua đêm
            if (strtotime($request->end_time) >= strtotime('12:00:00')) {
                return redirect()->back()->withErrors(['end_time' => 'Thời gian kết thúc không hợp lệ. Ca đêm kết thúc phải sau 12 giờ sáng.']);
            }
        }
        

        Shift::create([
            'name' => $request->name,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->route('admin.shifts.index')->with('success', 'Ca làm việc được thêm mới thành công!');
    }
    public function edit(Shift $shift)
    {
        return view('admin.shifts.edit', compact('shift'));
    }
    public function update(Request $request, Shift $shift)
    {
        // Chuyển đổi định dạng nếu cần
        $request->merge([
            'start_time' => date('H:i', strtotime($request->start_time)),
            'end_time' => date('H:i', strtotime($request->end_time)),
        ]);

        $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
        ]);


        $shift->update([
            'name' => $request->name,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->route('admin.shifts.index')->with('success', 'Ca làm việc đã được cập nhật thành công!');
    }


}
