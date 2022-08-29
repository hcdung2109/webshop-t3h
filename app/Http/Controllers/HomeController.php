<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    protected $categories;

    public function __construct()
    {
        $setting = Setting::first();
        // Lấy dữ liệu - Danh mục, có trạng thái là hiển thị
        $this->categories = Category::where(['is_active' => 1])->get();
        $banners = Banner::where(['is_active' => 1])
                                    // where('type', 5)
                                    //->orderBy('created_at')
                                    ->orderBy('id')
                                    ->get();

        View::share('categories', $this->categories);
        View::share('setting', $setting);
        View::share('banners', $banners);

    }

    public function index()
    {
        $list = []; // chứa danh sách sản phẩm  theo danh mục

        foreach($this->categories as $key => $parent) {
            if ($parent->parent_id == 0) { // check danh mục cha
                $ids = []; // tạo chứa các id của danh cha + danh mục con trực thuộc / danh mục con

                $ids[] = $parent->id; // id danh mục cha

                $sub_menu = [];
                foreach ($this->categories as $child) {
                    if ($child->parent_id == $parent->id) {
                        $sub_menu[] = $child;
                        $ids[] = $child->id; // thêm phần tử vào mảng
                    }
                } // ids = [1,7,8,9,..]

                $list[$key]['category'] = $parent; // điện thoại, tablet
                $list[$key]['sub_category'] = $sub_menu; // điện thoại, tablet

                // SELECT * FROM `products` WHERE is_active = 1 AND is_hot = 0 AND category_id IN (1,7,9,11) ORDER BY id DESC LIMIT 10
                $list[$key]['products'] = Product::where(['is_active' => 1, 'is_hot' => 0])
                    ->whereIn('category_id', $ids)
                    ->limit(8)
                    ->orderBy('id', 'desc')
                    ->get();


            }
        }

        return view('frontend.home', ['list' => $list]);
    }

    public function introduce()
    {
        return view('frontend.introduce');
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    // Thêm liên hệ
    public function contactPost(Request $request)
    {
        // validate form
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'phone' => 'required',
            'content' => 'required',
        ],[
            'name.required' => 'Bạn cần phải nhập vào tên',
            'email.required' => 'Bạn chưa nhập email',
            'phone.required' => 'Bạn chưa nhập SĐT',
            'content.required' => 'Bạn chưa nhập nội dung',
        ]);

        $model = new Contact();
        $model->name = $request->input('name');
        $model->phone = $request->input('phone');
        $model->email = $request->input('email');
        $model->content = $request->input('content');
        $model->save();

        return redirect('/lien-he')->with('msgContact', 'Gửi liên hệ thành công !');
    }

    /*
     * Danh sách bài viết
     */
    public function articles()
    {
        $articles = Article::latest()->paginate(20);

        return view('frontend.articles', ['articles' => $articles]);
    }


    public function detailArticle($slug)
    {
        $article = Article::where('slug', $slug)->where('is_active' , 1)->first();

        if ($article == null) {
            dd('not found');
        }

        return view('frontend.detail-article', ['article' => $article]);
    }


    public function category($slug)
    {
        $category = Category::where('slug', $slug)->where('is_active', 1)->first();

        if ($category == null) {
            dd(404);
        }

        $ids[] = $category->id; // khai báo mảng chứa các mã danh mục cần tìm kiếm chưa các sản phẩm

        foreach ($this->categories as $child) {
            if ($child->parent_id == $category->id) {
                $ids[] = $child->id; // thêm id của danh mục con vào mảng ids

                foreach ($this->categories as $sub_child) {
                    if ($sub_child->parent_id == $child->id) {
                        $ids[] = $child->id;
                    }
                }
            }
        }

        // cần viết đệ quy lấy toàn bộ danh mục cha con

        // step 2 : lấy list sản phẩm theo thể loại
        $products = Product::where('is_active', 1)
                            ->whereIn('category_id' , $ids)
                            ->latest()
                            ->paginate(15);

        return view('frontend.category', ['category' => $category, 'products' => $products]);
    }

    public function product(Request $request, $slug)
    {
        $product = Product::where('is_active', 1)->where('slug', $slug)->first();

        if ($product == null) {
            dd(404);
        }

        return view('frontend.product', ['product' => $product]);
    }

    public function search(Request $request)
    {

        $keyword = $request->input('kwd');

        //$slug = Str::slug($keyword);

        //$sql = "SELECT * FROM products WHERE is_active = 1 AND slug like '%$keyword%'";

        //$products = Product::where([
            //['slug', 'like', '%' . $slug . '%'],
            //['is_active', '=', 1]
        //])->orderByDesc('id')->paginate(5);

        //$totalResult = $products->total(); // số lượng kết quả tìm kiếm

        $page = $request->input('page', 1);
        $paginate = 5;

        $products = Product::searchByQuery(['match' => ['name' => $keyword]], null, null, $paginate, $page);
        $totalResult = $products->totalHits();
        $totalResult = $totalResult['value'];
        // $offSet = ($page * $paginate) - $paginate;
        $itemsForCurrentPage = $products->toArray();
        $products = new \Illuminate\Pagination\LengthAwarePaginator($itemsForCurrentPage, $totalResult, $paginate, $page);
        $products->setPath('tim-kiem');

        return view('frontend.search', [
            'products' => $products,
            'totalResult' => $totalResult ?? 0,
            'keyword' => $keyword ? $keyword : ''
        ]);
    }

    public function cart()
    {
        $cartItems = \Cart::getContent();

        $total = \Cart::getTotal();

        return view('frontend.cart', compact('cartItems', 'total'));
    }

    public function addToCart(Request $request)
    {
        \Cart::add([
            'id' => $request->id,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'attributes' => array(
                'image' => $request->image,
            )
        ]);

        session()->flash('success', 'Thêm vào giỏ hàng thành công');

        return redirect()->route('cart.list');
    }

}
