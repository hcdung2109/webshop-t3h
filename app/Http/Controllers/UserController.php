<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Cách 1: Lấy toàn bộ dữ liệu
        //$data = User::all(); // SELECT * FROM Users

        //Cách 2: Lấy dữ liệu mới nhất và phân trang - mỗi trang 10 bản ghi
        $data = User::latest()->paginate(10);


        return view('backend.user.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // xác thực dữ liệu - validate


        $User = new User();
        $User->name = $request->input('name');

        if($request->hasFile('avatar')) { // Kiem tra xem co image duoc chon khong
            //get File
            $file = $request->file('avatar');
            // Dat ten cho file image
            $filename = time().'_'.$file->getClientOriginalName();  //$file->getClientOriginalName() == ten anh
            //Dinh nghia duong dan se upload file len
            $path_upload = 'upload/user/';  //upload/brand; upload/vendor
            // Thuc hien upload file
            $file->move($path_upload,$filename);
            // Luu lai ten
            $User->avatar = $path_upload.$filename;
        }

        $User->email = $request->input('email');
        $User->password = bcrypt($request->input('password'));
        $User->role_id = $request->input('role_id');
        //Trang thai
        $is_active = 0;
        if($request->has('is_active')) { //Kiem tra xem is_active co ton tai khong
            $is_active = $request->input('is_active');
        }
        $User->is_active = $is_active;
        $User->save();

        //Chuyen huong ve trang danh sach
        return redirect()->route('admin.user.index');
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
        $model = User::findOrFail($id);

        return view('backend.user.edit', ['model' => $model]);
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
        // xác thực dữ liệu - validate
        $User = User::findOrFail($id);
        $User->name = $request->input('name');

        if($request->hasFile('avatar')) { // Kiem tra xem co image duoc chon khong
            //get File
            $file = $request->file('avatar');
            // Dat ten cho file image
            $filename = time().'_'.$file->getClientOriginalName();  //$file->getClientOriginalName() == ten anh
            //Dinh nghia duong dan se upload file len
            $path_upload = 'upload/user/';  //upload/brand; upload/vendor
            // Thuc hien upload file
            $file->move($path_upload,$filename);
            // Luu lai ten
            $User->avatar = $path_upload.$filename;
        }

        $User->email = $request->input('email');

        $new_password = $request->input('password');
        if (!empty($new_password)) {
            $User->password = bcrypt($new_password);
        }

        $User->role_id = $request->input('role_id');
        //Trang thai
        $is_active = 0;
        if($request->has('is_active')) { //Kiem tra xem is_active co ton tai khong
            $is_active = $request->input('is_active');
        }
        $User->is_active = $is_active;
        $User->save();

        //Chuyen huong ve trang danh sach
        return redirect()->route('admin.user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $User = User::findOrFail($id);
        // xóa ảnh cũ
        @unlink(public_path($User->avatar));

        User::destroy($id);

        return response()->json([
            'status' => true,
            'msg' => 'Xóa thành công'
        ]);
    }
}
