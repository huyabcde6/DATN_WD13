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

    
}
