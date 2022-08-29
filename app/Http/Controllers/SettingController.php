<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = Setting::first();

        return view('backend.setting.index', ['model' => $model]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = Setting::first();

        $model->company = $request->input('company');
        if($request->hasFile('image')) { // Kiem tra xem co image duoc chon khong
            //get File
            $file = $request->file('image');
            // Dat ten cho file image
            $filename = time().'_'.$file->getClientOriginalName();  //$file->getClientOriginalName() == ten anh
            //Dinh nghia duong dan se upload file len
            $path_upload = 'upload/setting/';  //upload/brand; upload/vendor
            // Thuc hien upload file
            $file->move($path_upload,$filename);
            // Luu lai ten
            $model->image = $path_upload.$filename;
        }

        $model->address = $request->input('address');
        $model->address2 = $request->input('address2');
        $model->phone = $request->input('phone');
        $model->email = $request->input('email');
        $model->tax = $request->input('taxt');
        $model->content = $request->input('content');
        $model->facebook = $request->input('facebook');
        $model->open_time = $request->input('open_time');
        $model->save();

        //Chuyen huong ve trang danh sach
        return redirect()->route('admin.setting.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
