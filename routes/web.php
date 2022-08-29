<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/gioi-thieu', [\App\Http\Controllers\HomeController::class, 'introduce'])->name('introduce');
Route::get('/tin-tuc', [\App\Http\Controllers\HomeController::class, 'articles'])->name('articles');
Route::get('/tin-tuc/{slug}', [\App\Http\Controllers\HomeController::class, 'detailArticle'])->name('detail-article');
Route::get('/danh-muc/{category}', [\App\Http\Controllers\HomeController::class, 'category'])->name('category');
Route::get('/chi-tiet-san-pham/{product}', [\App\Http\Controllers\HomeController::class, 'product'])->name('product');
Route::get('/tim-kiem', [\App\Http\Controllers\HomeController::class, 'search'])->name('search');
Route::get('/gio-hang', [\App\Http\Controllers\HomeController::class, 'cart'])->name('cart');
Route::get('/lien-he', [\App\Http\Controllers\HomeController::class, 'contact'])->name('contact');
Route::post('/lien-he', [\App\Http\Controllers\HomeController::class, 'contactPost'])->name('contactPost');


Route::get('cart', [\App\Http\Controllers\HomeController::class, 'cart'])->name('cart.list');
Route::post('cart', [\App\Http\Controllers\HomeController::class, 'addToCart'])->name('cart.store');
Route::post('update-cart', [\App\Http\Controllers\HomeController::class, 'updateCart'])->name('cart.update');
Route::post('remove', [\App\Http\Controllers\HomeController::class, 'removeCart'])->name('cart.remove');
Route::post('clear', [\App\Http\Controllers\HomeController::class, 'clearAllCart'])->name('cart.clear');

Route::get('/admin/login', [\App\Http\Controllers\AdminController::class, 'login'])->name('login');
Route::post('/admin/postLogin', [\App\Http\Controllers\AdminController::class, 'postLogin'])->name('admin.postLogin');
Route::get('/admin/logout', [\App\Http\Controllers\AdminController::class, 'logout'])->name('admin.logout');

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/dashboard',[\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/test', [\App\Http\Controllers\BannerController::class, 'test']);
    Route::resource('product', \App\Http\Controllers\ProductController::class);
    Route::resource('banner', \App\Http\Controllers\BannerController::class);
    Route::post('category/restore/{category}', [\App\Http\Controllers\CategoryController::class, 'restore'])->name('category.restore');
    Route::resource('category', \App\Http\Controllers\CategoryController::class);
    Route::resource('article', \App\Http\Controllers\ArticleController::class);
    Route::resource('setting', \App\Http\Controllers\SettingController::class);
    Route::resource('contact', \App\Http\Controllers\ContactController::class);
    Route::resource('user', \App\Http\Controllers\UserController::class);
});
