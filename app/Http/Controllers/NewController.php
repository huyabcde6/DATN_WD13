<?php

namespace App\Http\Controllers;

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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return view('admin.tintuc.addNew');
    }
    public function create(Request $request)
    {
        if ($request->isMethod('POST')) {
            $param = $request->except('_token');
            $param['new_date'] = date("d/m/Y");
            $param['view'] = 0;
            if ($request->hasFile('avata')) {
                $params['avata'] = $request->file('avata')->store('update/');
                // dd($request->file('avata'));
            } else {
                $params['avata'] = null;
            }
            // News::create($params);
            DB::table('news')->insert([
                'title' => $param['title'],
                'description' => $param['description'],
                'status' => $param['status'],
                'detail' => $param['detail'],
                'avata' => $param['avata'],
                'new_date' => Carbon::now()->format('Y-m-d H:i:s'),
                'view' => 0
            ]);
            return redirect()->route('new.show')->with('success', 'Thêm tin tức thành công!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy() {}
}
