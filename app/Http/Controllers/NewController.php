<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('admin.tintuc.New');
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
            if ($request->hasFile('avata')) {
                $params['avata'] = $request->file('avata')->store('update/', 'public');
            } else {
                $params['avata'] = null;
            }
            dd($param);
            News::query()->create($params);
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
