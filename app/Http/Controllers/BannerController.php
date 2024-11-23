<?php

namespace App\Http\Controllers;

use App\Http\Requests\BannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Models\banner;
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
        return view('admin.banners.create');
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
        ];

        if($request->hasFile('image_path')) {
            $dataBanner['image_path'] = Storage::put('banners', $request->file('image_path'));    
        }

        $banner = banner::query()->create($dataBanner);

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
        return view('admin.banners.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBannerRequest $request, Banner $banner)
    {
        $dataBanner = [
            "title"         => $request->title,
            "image_path"    => $request->image_path,
            "description"   => $request->description,  
            "order"         => $request->order,      
        ];

        if ($request->hasFile('image')) {
            // Xóa ảnh cũ
            if ($banner->image_path) {
                Storage::disk('public')->delete($banner->image_path);
            }

            $imagePath = $request->file('image')->store('banners', 'public');
            $dataBanner['image_path'] = $imagePath;
        }

        $banner->update($dataBanner);

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
