<?php

namespace App\Http\Controllers;

use App\Models\banner;
use App\Models\News;
use App\Models\products;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\Order;

class HomeController extends Controller
{
    public function index() 
    {
        $banners = banner::orderBy('order')->get();
        $news = News::latest()->take(3)->get();
        
        return view('user.sanpham.home', compact('banners', 'news'));
    }
}
