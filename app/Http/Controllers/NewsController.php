<?php

namespace App\Http\Controllers; 

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    // Hiển thị danh sách tin tức
    public function index()
    {
        $news = News::latest()->paginate(10);
        return view('admin.news.index', compact('news')); 
    }

    // Hiển thị form thêm tin tức
    public function create()
    {
        return view('admin.news.create');
    }

    // Lưu tin tức mới
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'detail' => 'required',
            'avata' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $news = new News();
        $news->title = $request->title;
        $news->description = $request->description;
        $news->detail = $request->detail;
        $news->new_date = now();
        $news->view = 0;

        if($request->hasFile('avata')){
            $file = $request->file('avata');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/news'), $filename);
            $news->avata = 'uploads/news/' . $filename;
        }

        $news->save();

        return redirect()->route('admin.news.index')->with('success', 'Tin tức đã được thêm thành công');
    }

    // Hiển thị form sửa tin tức
    public function edit($id)
    {
        $news = News::findOrFail($id);
        return view('admin.news.edit', compact('news'));
    }

    // Cập nhật tin tức
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required', 
            'detail' => 'required',
            'avata' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $news = News::findOrFail($id);
        $news->title = $request->title;
        $news->description = $request->description;
        $news->detail = $request->detail;

        if($request->hasFile('avata')){
            // Xóa ảnh cũ
            if(file_exists(public_path($news->avata))){
                unlink(public_path($news->avata));
            }
            
            $file = $request->file('avata');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/news'), $filename);
            $news->avata = 'uploads/news/' . $filename;
        }

        $news->save();

        return redirect()->route('admin.news.index')->with('success', 'Tin tức đã được cập nhật thành công');
    }

    // Xóa tin tức
    public function destroy($id)
    {
        $news = News::findOrFail($id);
        
        // Xóa ảnh
        if(file_exists(public_path($news->avata))){
            unlink(public_path($news->avata));
        }
        
        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'Tin tức đã được xóa thành công');
    }
}