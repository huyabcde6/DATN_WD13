<?php

namespace App\Http\Controllers;

use App\Http\Requests\BannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Models\banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
  
    public function index()
    {
        $banners = banner::orderBy('order')->get();
        return view('admin.banners.index', compact('banners'));
    }

   
    public function create()
    {
        return view('admin.banners.create');
    }

   
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

  
    public function show(string $id)
    {
        //
    }

  
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

  
    public function update(UpdateBannerRequest $request, Banner $banner)
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

            $currentPathImage = $banner->image_path;
            
            $banner->update($dataBanner);
        

        if($request->hasFile('image_path') && Storage::exists($currentPathImage)) {
            Storage::delete($currentPathImage);
        }

        return redirect()->route('admin.banners.index')->with('success', 'Thao tác thành công!');
    }

    
    public function destroy(Banner $banner)
    {
        if ($banner->image_path) {
            Storage::disk('public')->delete($banner->image_path);
        }

        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Xóa Banner thành công!');
    }
}
