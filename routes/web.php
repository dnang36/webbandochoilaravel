<?php

use App\Http\Controllers\Admin\CartController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\Users\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('admin/users/login',[LoginController::class,'index'])->name('login');
Route::post('admin/users/login/store',[LoginController::class,'store']);


Route::middleware(['auth'])->group(function(){

     Route::prefix('admin')->group(function(){
        Route::get('/',[MainController::class,'index1'])->name('admin');
        Route::get('/main',[MainController::class,'index']);

     //menu
        Route::prefix('menus')->group(function(){
            Route::get('add',[MenuController::class,'create']);
            Route::post('add',[MenuController::class,'store']);
            Route::get('list',[MenuController::class,'index']);
            Route::delete('/destroy',[MenuController::class,'destroy']); 
            Route::get('/edit/{menu}',[MenuController::class,'show']);     
            Route::post('/edit/{menu}',[MenuController::class,'update']);    
        });

    //product
    Route::prefix('products')->group(function(){
        Route::get('add',[ProductController::class,'create']);
        Route::post('add',[ProductController::class,'store']);
        Route::get('list',[ProductController::class,'index']);
        Route::delete('/destroy',[ProductController::class,'destroy']); 
        Route::get('/edit/{product}',[ProductController::class,'show']);     
        Route::post('/edit/{product}',[ProductController::class,'update']);    
    });

     //sliders
     Route::prefix('sliders')->group(function(){
        Route::get('add',[SliderController::class,'create']);
        Route::post('add',[SliderController::class,'store']);
        Route::get('list',[SliderController::class,'index']);
        Route::delete('/destroy',[SliderController::class,'destroy']); 
        Route::get('/edit/{slider}',[SliderController::class,'show']);     
        Route::post('/edit/{slider}',[SliderController::class,'update']);    
    });

    #Cart
    Route::get('customers', [CartController::class, 'index']);
    Route::get('customers/view/{customer}', [CartController::class, 'show']);

    //upload
    Route::post('upload/services',[UploadController::class,'store']);

    });
});

Route::get('/',[MainController::class, 'index']);

Route::get('danh-muc/{id}-{slug}.html',[App\Http\Controllers\MenuController::class,'index']);
Route::get('san-pham/{id}-{slug}.html',[App\Http\Controllers\ProductController::class,'index']);

Route::post('add-cart',[App\Http\Controllers\CartController::class,'index']);
Route::get('carts',[App\Http\Controllers\CartController::class,'show']);
Route::post('update-cart',[App\Http\Controllers\CartController::class,'update']);
Route::get('carts/delete/{id}',[App\Http\Controllers\CartController::class,'remove']);
Route::post('carts',[App\Http\Controllers\CartController::class,'addCart']);





