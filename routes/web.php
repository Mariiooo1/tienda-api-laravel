<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/productos', function(){
    return view('productos');
});

Route::get('/consultar', function (){
    $user = new App\Models\User();
    return dd($user->all());
});

Route::get('/insertar', function (){
    $user = new App\Models\User();
    $user->email = 'email@gmail.com';
    $user->name = 'Ejemplo 2';
    $user->password = "mypassword";
    $user->save();
    return dd($user);
});

Route::get('/products', [App\Http\Controllers\ProductController::class, "index"])->name('product.list');