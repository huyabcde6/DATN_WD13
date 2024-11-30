<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SlidebarController extends Controller
{
    public function index() 
    {
        $colors = Color::all();

        return view('user.sanpham.shop_sidebar', compact( 'colors'));
    }
}
