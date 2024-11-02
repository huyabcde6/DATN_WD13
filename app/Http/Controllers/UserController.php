<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Route::get('/login', [UserController::class, 'login'])->name('login');
        $users = User::when($request->search, function ($query) use ($request) {
            $query->where('name', 'like', "%{$request->search}%");
        })
            ->latest('id')
            ->paginate(5);

        return view('admin.users.index', compact('users'));
    }
    // public function login(Request $request)
    // {
    //     return view('user.sanpham.login');
    // }
    // public function register(Request $request)
    // {
    //     return view('user.sanpham.register');
    // }
    // public function postRegister(Request $req)
    // {
    //     //validate
    //     // dd(Hash::make($req->password));
    //     $req->merge(['password' => Hash::make($req->password)]);
    //     try {
    //         User::create($req->all());
    //     } catch (\Throwable $th) {
    //         dd($th);
    //     }
    //     return redirect()->route('login');
    // }
    // public function postLogin(Request $req)
    // {
    //     if (Auth::attempt(['email' => $req->email, 'password' => $req->password])) {
    //         return redirect()->route('index');
    //     }
    //     return redirect()->back()->with('error', 'sai tt');
    // }


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
