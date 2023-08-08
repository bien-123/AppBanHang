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

// Route::get('/', function () {
//     return view('welcome');
// });

// Begin: Login
// Tạo router LoginAdmin
use App\Http\Controllers\Admin\Users\LoginController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\MainController;

// Gọi đến function index trong LoginController
Route::get('admin/users/Login', [LoginController::class, 'index'])->name('login');

// Gọi đến function store trong LoginController
Route::post('admin/users/login/store', [LoginController::class, 'store']);

Route::middleware(['auth'])->group(function (){

    Route::prefix('admin')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\MainController::class, 'index'])
            ->name('admin');
        Route::get('/main', [\App\Http\Controllers\Admin\MainController::class, 'index']);// gọi đến function index trong MainController

        // Danh mục
        Route::prefix('menus')->group(function () {
            Route::get('add', [MenuController::class, 'create']);//gọi đến function create trong MenuController
            Route::post('add', [MenuController::class, 'store']);//gọi đến function store trong MenuController
            Route::get('list', [MenuController::class, 'index']);//gọi đến function index trong MenuController
            Route::get('edit/{menu}', [MenuController::class, 'show']);//gọi đến function show trong MenuController
            Route::post('edit/{menu}', [MenuController::class, 'update']);//gọi đến function show trong MenuController
            Route::DELETE('destroy', [MenuController::class, 'destroy']);//gọi đến function destroy trong MenuController
        });

//        Sản phẩm
        Route::prefix('products')->group(function ()
        {
            Route::get('add', [ProductController::class, 'create']);
            Route::post('add', [ProductController::class, 'store']);
            Route::get('list', [ProductController::class, 'index']);
            Route::get('edit/{product}', [ProductController::class, 'show']);
            Route::post('edit/{product}', [ProductController::class, 'update']);
            Route::DELETE('destroy', [ProductController::class, 'destroy']);
        });

        //        Slider
        Route::prefix('sliders')->group(function ()
        {
            Route::get('add', [SliderController::class, 'create']);
            Route::post('add', [SliderController::class, 'store']);
            Route::get('list', [SliderController::class, 'index']);
            Route::get('edit/{slider}', [SliderController::class, 'show']);
            Route::post('edit/{slider}', [SliderController::class, 'update']);
            Route::DELETE('destroy', [SliderController::class, 'destroy']);
        });

//        Upload
        Route::post('upload/services',[\App\Http\Controllers\Admin\UploadController::class, 'store']);
    });
});

//Gọi đến trang home
Route::get('/', [MainController::class, 'index']);
Route::post('/services/load-product',[MainController::class, 'loadProduct']);

//Gọi đến trang danh mục
Route::get('danh-muc/{id}-{slug}.html', [\App\Http\Controllers\MenuController::class, 'index']);

//gọi đến trang sản phẩm
Route::get('san-pham/{id}-{slug}.html', [\App\Http\Controllers\ProductController::class, 'index']);

//thêm sản phẩm vào giỏ hàng
Route::post('add-cart', [\App\Http\Controllers\CartController::class, 'index']);
Route::get('carts', [\App\Http\Controllers\CartController::class, 'show']);
