<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\Models\banner;
use Illuminate\Http\Request;
use App\Models\Order;
class HomeController extends Controller
{
    public function index() {
        $banners = banner::orderBy('order')->get();
        return view('user.sanpham.home', compact('banners'));
=======
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        return view('user.sanpham.home');
>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19
    }
}
