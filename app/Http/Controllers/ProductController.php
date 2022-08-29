<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Cách 1: Lấy toàn bộ dữ liệu
        //$data = Product::all(); // SELECT * FROM Products

        //Cách 2: Lấy dữ liệu mới nhất và phân trang - mỗi trang 10 bản ghi
        $data = Product::latest()->paginate(10);


        return view('backend.Product.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Category::all(); // select * from categories

        return view('backend.Product.create', ['data' => $data]);
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
            'name' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10000',
            'category_id' => 'required',
            'summary' => 'required',
            'description' => 'required',
            'meta_title' => 'required',
            'meta_description' => 'required',
        ],[
            'name.required' => 'Bạn cần phải nhập vào tiêu đề',
            'image.required' => 'Bạn chưa chọn file ảnh',
            'image.image' => 'File ảnh phải có dạng jpeg,png,jpg,gif,svg',
            'category_id.required' => 'Bạn cần phải chọn danh mục',
            'summary.required' => 'Bạn cần phải nhập vào tóm tắt',
            'description.required' => 'Bạn cần phải nhập vào mô tả',
            'meta_title.required' => 'Bạn cần phải nhập vào meta title',
            'meta_description.required' => 'Bạn cần phải nhập vào meta description',
        ]);

        $Product = new Product();
        $Product->name = $request->input('name');
        $Product->slug = Str::slug($request->input('name')); //slug

        if($request->hasFile('image')) { // Kiem tra xem co image duoc chon khong
            //get File
            $file = $request->file('image');
            // Dat ten cho file image
            $filename = time().'_'.$file->getClientOriginalName();  //$file->getClientOriginalName() == ten anh
            //Dinh nghia duong dan se upload file len
            $path_upload = 'upload/product/';  //upload/brand; upload/vendor
            // Thuc hien upload file
            $file->move($path_upload,$filename);
            // Luu lai ten
            $Product->image = $path_upload.$filename;
        }

        $Product->stock = (int) $request->input('stock');
        $Product->price = (int) Str::remove(',', $request->input('price'));
        $Product->sale = (int) Str::remove(',', $request->input('sale'));
        $Product->url = $request->input('url');
        $Product->category_id = (int) $request->input('category_id');

        // Loai
        //$Product->type = $request->input('type') ?? 0;
        //Trang thai
        $is_active = 0;
        if($request->has('is_active')) { //Kiem tra xem is_active co ton tai khong
            $is_active = $request->input('is_active');
        }
        //Trang thai
        $Product->is_active = $is_active;
        //Vi tri
        $position=0;
        if($request->has('position')){
            $position = $request->input('position');
        }
        $Product->position = $position;
        $Product->is_hot = $request->input('is_hot') ?? 0;
        $Product->summary = $request->input('summary');
        $Product->description = $request->input('description');
        $Product->meta_title = $request->input('meta_title');
        $Product->meta_description = $request->input('meta_description');
        $Product->save();

        //$Product->addToIndex();

        //Product::createIndex($shards = null, $replicas = null);

        //Product::putMapping($ignoreConflicts = true);

        Product::addAllToIndex();

        //Chuyen huong ve trang danh sach
        return redirect()->route('admin.product.index');
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
        $model = Product::findOrFail($id);
        $categories = Category::all(); // select * from categories

        return view('backend.Product.edit', ['model' => $model, 'data' => $categories]);
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
            'name' => 'required|max:255',
            //'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10000',
            'category_id' => 'required',
            'summary' => 'required',
            'description' => 'required',
            'meta_title' => 'required',
            'meta_description' => 'required',
        ],[
            'name.required' => 'Bạn cần phải nhập vào tiêu đề',
            //'image.required' => 'Bạn chưa chọn file ảnh',
            'image.image' => 'File ảnh phải có dạng jpeg,png,jpg,gif,svg',
            'category_id.required' => 'Bạn cần phải chọn danh mục',
            'summary.required' => 'Bạn cần phải nhập vào tóm tắt',
            'description.required' => 'Bạn cần phải nhập vào mô tả',
            'meta_title.required' => 'Bạn cần phải nhập vào meta title',
            'meta_description.required' => 'Bạn cần phải nhập vào meta description',
        ]);

        $Product = Product::find($id);
        $Product->name = $request->input('name');
        $Product->slug = Str::slug($request->input('name')); //slug

        if($request->hasFile('image')) { // Kiem tra xem co image duoc chon khong
            //get File
            $file = $request->file('image');
            // Dat ten cho file image
            $filename = time().'_'.$file->getClientOriginalName();  //$file->getClientOriginalName() == ten anh
            //Dinh nghia duong dan se upload file len
            $path_upload = 'upload/product/';  //upload/brand; upload/vendor
            // Thuc hien upload file
            $file->move($path_upload,$filename);
            // Luu lai ten
            $Product->image = $path_upload.$filename;
        }

        $Product->stock = (int) $request->input('stock');
        $Product->price = (int) Str::remove(',', $request->input('price'));
        $Product->sale = (int) Str::remove(',', $request->input('sale'));
        $Product->url = $request->input('url');
        $Product->category_id = (int) $request->input('category_id');

        // Loai
        //$Product->type = $request->input('type') ?? 0;
        //Trang thai
        $is_active = 0;
        if($request->has('is_active')) { //Kiem tra xem is_active co ton tai khong
            $is_active = $request->input('is_active');
        }
        //Trang thai
        $Product->is_active = $is_active;
        //Vi tri
        $position=0;
        if($request->has('position')){
            $position = $request->input('position');
        }
        $Product->position = $position;
        $Product->is_hot = $request->input('is_hot') ?? 0;
        $Product->summary = $request->input('summary');
        $Product->description = $request->input('description');
        $Product->meta_title = $request->input('meta_title');
        $Product->meta_description = $request->input('meta_description');
        $Product->save();

        //Chuyen huong ve trang danh sach
        return redirect()->route('admin.product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Product = Product::findOrFail($id);
        // xóa ảnh cũ
        @unlink(public_path($Product->image));

        Product::destroy($id); // DELETE FROM Products WHERE id = ?

        return response()->json([
            'status' => true,
            'msg' => 'Xóa thành công'
        ]);
    }
}
