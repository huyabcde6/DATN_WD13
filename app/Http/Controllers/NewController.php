<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewRequest;
use App\Models\News;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $db = DB::table('news')->get()->all();

        return view('admin.tintuc.New', compact('db'));
    }

    public function index2()
    {
        $news =  News::where('status', 1)->get();

        return view('user.khac.tintuc', compact('news'));
    }
    public function tintucdetail()
    {
        $id = request('id');
        $news = News::findOrFail($id); // Tìm tin tức theo id, nếu không tìm thấy sẽ báo lỗi 404
        $news->increment('view');
        return view('user.khac.tintuc_detail', compact('news'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return view('admin.tintuc.addNew');
    }
    public function create(NewRequest $request)
    {
        if ($request->isMethod('POST')) {
            $param = $request->except('_token');
            $param['new_date'] = date("d/m/Y");
            $param['view'] = 0;

            // Ensure 'detail' is not empty
            if (empty($request->input('detail'))) {
                return redirect()->back()->withErrors(['detail' => 'Mô tả chi tiết không được để trống.']);
            }

            // Handle avatar upload
            if ($request->hasFile('avata')) {
                $param['avata'] = $request->file('avata')->store('update', 'public');
            } else {
                $param['avata'] = null;
            }

            DB::table('news')->insert([
                'title' => $param['title'],
                'description' => $param['description'],
                'status' => $param['status'],
                'detail' => $request->input('detail'), // Save the content of 'detail' properly
                'avata' => $param['avata'],
                'new_date' => Carbon::now()->format('Y-m-d H:i:s'),
                'view' => 0,
            ]);

            return redirect()->route('admin.new.index')->with('success', 'Thêm tin tức thành công!');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $db = DB::table('news')->where('id', $id)->first();
        return view('admin.tintuc.editNew', compact('db'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NewRequest $request, string $id)
    {
        if ($request->isMethod('POST')) {
            $db = DB::table('news')->where('id', $id)->first();
            $param = $request->except('_token');
            $param['new_date'] = date("d/m/Y");
            $param['view'] = 0;
            if ($request->hasFile('avata')) {
                $params['avata'] = $request->file('avata')->store('update', 'public');
            } else {
                $params['avata'] = $db->avata;
            }
            // dd($params['avata']);
            // News::create($params);
            DB::table('news')->where('id', $id)->update([
                'title' => $param['title'],
                'description' => $param['description'],
                'status' => $param['status'],
                'detail' => $param['detail'],
                'avata' => $params['avata'],
                'new_date' => Carbon::now()->format('Y-m-d H:i:s'),
                'view' => 0
            ]);
            return redirect()->route('admin.new.index')->with('success', 'Thêm tin tức thành công!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $products = News::findOrFail($id);
        $products->delete();

        return redirect()->route('admin.new.index')->with('success', 'Tin tức đã được xóa .');
    }
}