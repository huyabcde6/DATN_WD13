<?php

namespace App\Http\Controllers;

use App\Models\banner;
use Illuminate\Http\Request;
use App\Models\Order;
class HomeController extends Controller
{
    public function index() {
        $banners = banner::orderBy('order')->get();
        return view('user.sanpham.home', compact('banners'));
    }
}
