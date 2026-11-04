<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;

// La raíz redirige a la lista de productos http://127.0.0.1:8000
Route::get('/', function () {
    return redirect()->route('productos.index');
});

// Rutas del CRUD de productos (con AJAX), según la guía
Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
Route::get('/productos/obtenerProductos', [ProductoController::class, 'getProduct'])->name('productos.obtenerProductos');
Route::get('/productos/create', [ProductoController::class, 'create'])->name('productos.create');
Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');
Route::put('/productos/{id}', [ProductoController::class, 'update'])->name('productos.update');
Route::delete('/productos/{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');
