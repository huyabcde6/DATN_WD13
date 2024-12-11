<?php

namespace App\Http\Controllers;

use App\Models\banner;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\products;

class HomeController extends Controller
{
    public function index()
    {
        $banners = banner::orderBy('order')->get();

        // Sản phẩm mới
        $newProducts = products::where('iS_new', 1)
            ->where('iS_show', 1)
            ->latest() // Sắp xếp theo ngày tạo mới nhất
            ->limit(8)->get(); // Hiển thị tối đa 8 sản phẩm

            // Sản phẩm bán chạy
        $bestSellingProducts = products::where('is_hot', true)
            ->where('is_show', true)
            ->limit(8)->get();

        // Sản phẩm sale
        $saleProducts = products::whereNotNull('discount_price')
            ->where('is_show', true)
            ->limit(8)->get();

        return view('user.sanpham.home', compact('banners', 'newProducts', 'bestSellingProducts', 'saleProducts'));
    }

}
