<?php

namespace App\Http\Controllers;

use App\Http\Requests\BannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Models\banner;
use App\Models\categories;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = banner::orderBy('order')->get();
        return view('admin.banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $danhmuc = categories::all();
        return view('admin.banners.create', compact('danhmuc'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BannerRequest $request)
    {
        $dataBanner = [
            "title"         => $request->title,
            "image_path"    => $request->image_path,
            "description"   => $request->description,
            "order"         => $request->order,
            "status"        => $request->status,  // Lấy giá trị status (1: Hiển thị, 0: Ẩn)
            "category_id"   => $request->category,  // Lấy id của danh mục sản phẩm
        ];

        // Kiểm tra xem người dùng có tải lên ảnh hay không
        if ($request->hasFile('image_path')) {
            // Lưu file ảnh vào thư mục 'public/banners' và lấy đường dẫn của ảnh
            $dataBanner['image_path'] = $request->file('image_path')->store('banner', 'public');
        }

        // Tạo mới banner và lưu vào cơ sở dữ liệu
        Banner::query()->create($dataBanner);

        // Quay lại trang danh sách banner với thông báo thành công
        return redirect()->route('admin.banners.index')->with('success', 'Thao tác thành công!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        $danhmuc = categories::all();
        return view('admin.banners.edit', compact('banner', 'danhmuc'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBannerRequest $request, Banner $banner)
    {
        // Tạo mảng dữ liệu cần cập nhật
        $dataBanner = [
            "title"         => $request->title,
            "description"   => $request->description,
            "order"         => $request->order,
            "status"        => $request->status,  // Lấy giá trị status (1: Hiển thị, 0: Ẩn)
            "category_id"   => $request->category,  // Lấy id của danh mục sản phẩm
        ];

        // Kiểm tra nếu có file hình ảnh mới, thì lưu và cập nhật giá trị image_path
        if ($request->hasFile('image_path')) {
            // Lưu ảnh mới vào thư mục banners và lấy đường dẫn
            $dataBanner['image_path'] = $request->file('image_path')->store('banner', 'public');

            // Xóa ảnh cũ nếu có (kiểm tra sự tồn tại của ảnh cũ)
            $currentPathImage = $banner->image_path;
            if (Storage::exists($currentPathImage)) {
                Storage::delete($currentPathImage);
            }
        } else {
            // Nếu không có ảnh mới, giữ lại ảnh cũ
            $dataBanner['image_path'] = $banner->image_path;
        }

        // Cập nhật thông tin banner
        $banner->update($dataBanner);

        // Chuyển hướng về trang danh sách banner với thông báo thành công
        return redirect()->route('admin.banners.index')->with('success', 'Thao tác thành công!');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        if ($banner->image_path) {
            Storage::disk('public')->delete($banner->image_path);
        }

        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Xóa Banner thành công!');
    }
}
