<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Slider\SliderService;
use App\Http\Services\Menu\MenuService;
use App\Http\Services\Product\ProductService;

class MainController extends Controller
{
    protected $slider;
    protected $product;

    public function __construct(SliderService $slider,ProductService $product)
    {
        $this->slider = $slider;
        $this->product = $product;

    }

    public function index()
    {
        return view('home',[
            'title'=>'shop Thực Phẩm',
            'sliders' => $this->slider->show(),
            'products' => $this->product->get()
        ]);
    }

    public function index1()
    {
        return view('admin.main',[
            'title'=>'Shop Thực Phẩm',
        ]);
    }
}
