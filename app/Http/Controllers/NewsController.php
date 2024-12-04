<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    // Hiển thị danh sách tin tức
    public function index()
    {
        $news = News::all();
        return view('news.index', compact('news'));
    }

    // Hiển thị form tạo tin tức mới
    public function create()
    {
        return view('news.create');
    }

    // Lưu tin tức mới vào cơ sở dữ liệu
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);
    
        // Chỉ lấy các trường title và content từ request
        News::create($request->only(['title', 'content']));
    
        return redirect()->route('news.index')->with('success', 'Tin tức đã được thêm');
    }
    

    // Hiển thị form sửa tin tức
    public function edit($id)
    {
        $news = News::findOrFail($id);
        return view('news.edit', compact('news'));
    }

    // Cập nhật tin tức trong cơ sở dữ liệu
    public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required|max:255',
        'content' => 'required',
    ]);

    $news = News::findOrFail($id);
    // Chỉ lấy các trường title và content từ request
    $news->update($request->only(['title', 'content']));

    return redirect()->route('news.index')->with('success', 'Tin tức đã được cập nhật');
}

    // Xóa tin tức khỏi cơ sở dữ liệu
    public function destroy($id)
    {
        $news = News::findOrFail($id);
        $news->delete();

        return redirect()->route('news.index')->with('success', 'Tin tức đã bị xóa');
    }
}

