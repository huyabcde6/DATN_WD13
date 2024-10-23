<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Route::get('/login', [UserController::class,'login'])->name('login');
        $users = User::when($request->search, function($query) use ($request) {
            $query->where('name', 'like', "%{$request->search}%");
        })
                    ->latest('id')
                    ->paginate(5);

        return view('admin.users.index', compact('users'));

    }
    public function login(Request $request)
    {
        return view('user.sanpham.login');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Xóa thành công!');
    }
}
