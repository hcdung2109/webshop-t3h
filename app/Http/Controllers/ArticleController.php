<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Cách 1: Lấy toàn bộ dữ liệu
        //$data = Article::all(); // SELECT * FROM Articles

        //Cách 2: Lấy dữ liệu mới nhất và phân trang - mỗi trang 10 bản ghi
        $data = Article::latest()->paginate(10);


        return view('backend.article.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Category::where('type', 2)->get(); // select * from categories

        return view('backend.article.create', ['data' => $data]);
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
        $request->validate([
            'title' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10000',
            'category_id' => 'required',
            'summary' => 'required',
            'description' => 'required',
            'meta_title' => 'required',
            'meta_description' => 'required',
        ],[
            'title.required' => 'Bạn cần phải nhập vào tiêu đề',
            'image.required' => 'Bạn chưa chọn file ảnh',
            'image.image' => 'File ảnh phải có dạng jpeg,png,jpg,gif,svg',
            'category_id.required' => 'Bạn cần phải chọn danh mục',
            'summary.required' => 'Bạn cần phải nhập vào tóm tắt',
            'description.required' => 'Bạn cần phải nhập vào mô tả',
            'meta_title.required' => 'Bạn cần phải nhập vào meta title',
            'meta_description.required' => 'Bạn cần phải nhập vào meta description',
        ]);

        $Article = new Article();
        $Article->title = $request->input('title');
        $Article->slug = Str::slug($request->input('title')); //slug

        if($request->hasFile('image')) { // Kiem tra xem co image duoc chon khong
            //get File
            $file = $request->file('image');
            // Dat ten cho file image
            $filename = time().'_'.$file->getClientOriginalName();  //$file->getClientOriginalName() == ten anh
            //Dinh nghia duong dan se upload file len
            $path_upload = 'upload/Article/';  //upload/brand; upload/vendor
            // Thuc hien upload file
            $file->move($path_upload,$filename);
            // Luu lai ten
            $Article->image = $path_upload.$filename;
        }

        $Article->url = $request->input('url');
        $Article->category_id = $request->input('category_id');

        // Loai
        //$Article->type = $request->input('type') ?? 0;
        //Trang thai
        $is_active = 0;
        if($request->has('is_active')) { //Kiem tra xem is_active co ton tai khong
            $is_active = $request->input('is_active');
        }
        //Trang thai
        $Article->is_active = $is_active;
        //Vi tri
        $position=0;
        if($request->has('position')){
            $position = $request->input('position');
        }
        $Article->position = $position;
        //Mo ta

        $Article->summary = $request->input('summary');
        $Article->description = $request->input('description');
        $Article->meta_title = $request->input('meta_title');
        $Article->meta_description = $request->input('meta_description');
        //Luu
        $Article->save();

        //Chuyen huong ve trang danh sach
        return redirect()->route('admin.article.index');
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
        $model = Article::findOrFail($id);
        $categories = Category::where('type', 2)->get();

        return view('backend.article.edit', ['model' => $model, 'categories' => $categories]);
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
        $request->validate([
            'title' => 'required|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10000',
            'category_id' => 'required',
            'summary' => 'required',
            'description' => 'required',
            'meta_title' => 'required',
            'meta_description' => 'required',
        ],[
            'title.required' => 'Bạn cần phải nhập vào tiêu đề',
            'image.required' => 'Bạn chưa chọn file ảnh',
            'image.image' => 'File ảnh phải có dạng jpeg,png,jpg,gif,svg',
            'category_id.required' => 'Bạn cần phải chọn danh mục',
            'summary.required' => 'Bạn cần phải nhập vào tóm tắt',
            'description.required' => 'Bạn cần phải nhập vào mô tả',
            'meta_title.required' => 'Bạn cần phải nhập vào meta title',
            'meta_description.required' => 'Bạn cần phải nhập vào meta description',
        ]);

        $Article = Article::findOrFail($id);
        $Article->title = $request->input('title');
        $Article->slug = Str::slug($request->input('title')); //slug

        if($request->hasFile('image')) { // Kiem tra xem co image duoc chon khong
            //get File
            $file = $request->file('image');
            // Dat ten cho file image
            $filename = time().'_'.$file->getClientOriginalName();  //$file->getClientOriginalName() == ten anh
            //Dinh nghia duong dan se upload file len
            $path_upload = 'upload/Article/';  //upload/brand; upload/vendor
            // Thuc hien upload file
            $file->move($path_upload,$filename);
            // Luu lai ten
            $Article->image = $path_upload.$filename;
        }

        $Article->url = $request->input('url');
        $Article->category_id = $request->input('category_id');

        // Loai
        //$Article->type = $request->input('type') ?? 0;
        //Trang thai
        $is_active = 0;
        if($request->has('is_active')) { //Kiem tra xem is_active co ton tai khong
            $is_active = $request->input('is_active');
        }
        //Trang thai
        $Article->is_active = $is_active;
        //Vi tri
        $position=0;
        if($request->has('position')){
            $position = $request->input('position');
        }
        $Article->position = $position;
        //Mo ta

        $Article->summary = $request->input('summary');
        $Article->description = $request->input('description');
        $Article->meta_title = $request->input('meta_title');
        $Article->meta_description = $request->input('meta_description');
        //Luu
        $Article->save();

        //Chuyen huong ve trang danh sach
        return redirect()->route('admin.article.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Article = Article::findOrFail($id);
        // xóa ảnh cũ
        @unlink(public_path($Article->image));

        Article::destroy($id); // DELETE FROM articles WHERE id = ?

        return response()->json([
            'status' => true,
            'msg' => 'Xóa thành công'
        ]);
    }
}
