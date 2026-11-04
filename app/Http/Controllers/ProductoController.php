<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        return view('productos.productos', compact('productos'));
    }

    public function create()
    {
        return view('productos.create');
    }

    // 
    public function store(Request $request)
    {
        $request->validate([
            'productos' => 'required',
            'precio'    => 'required',
            'categoria' => 'required',
            'stock'     => 'required',
        ]);

        Producto::create($request->all());

        // 
        if ($request->ajax()) {
            return response()->json(['mensaje' => 'Producto ingresado con éxito.']);
        }

        return redirect()->route('productos.index')->with('success', 'Producto ingresado con éxito.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'productos' => 'required',
            'precio'    => 'required|numeric',
            'categoria' => 'required',
            'stock'     => 'required|integer',
        ]);

        $producto = Producto::findOrFail($id);
        $producto->update($request->only(['productos', 'precio', 'categoria', 'stock']));

        return redirect()->route('productos.index')->with('success', 'Producto actualizado con éxito.');
    }

    public function destroy($id)
    {
        Producto::findOrFail($id)->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado con éxito.');
    }
}