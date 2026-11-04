<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;

/* CODIGO PARA ENLACE DE http://127.0.0.1:8000/productos/create
Route::get('/', function () {
    return view('welcome');
});

Route::resource('productos', ProductoController::class);
*/

// Nueva ruta: redirige la raíz a la lista de productos http://127.0.0.1:8000
Route::get('/', function () {
    return redirect()->route('productos.index');
});

Route::resource('productos', ProductoController::class);