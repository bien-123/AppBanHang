<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Slider\SliderService;
use App\Http\Services\Menu\MenuService;
use App\Http\Services\Product\ProductService;

class MainController extends Controller
{
    protected $slider;
    protected $menu;
    protected $product;

    public function __construct(SliderService $slider, MenuService $menu, ProductService $product)
    {
        $this->slider = $slider;
        $this->menu = $menu;
        $this->product = $product;
    }

    public function index()
    {
        return view('main', [
           'title' => 'Shop nước hoa ABC',
            'sliders'=> $this->slider->show(),
            'menus' => $this->menu->show(),
            'products' => $this->product->get()
        ]);
    }

    public function loadProduct(Request $request)
    {
        $page = $request->input('page', 0); // page trong function loadMore ở public.js
        $result = $this->product->get($page);
        if (count($result) != 0) {
            $html = view('products.list', ['products'=>$result])->render(); // truyền vào view một biến products, nó sẽ chứa data($result) và render ra view

            return response()->json([ 'html' => $html ]);
        }

        return response()->json([ 'html' => '' ]);
    }
}
