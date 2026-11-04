<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    // Muestra la vista (la tabla se llena después con AJAX)
    public function index()
    {
        return view('productos.producto');
    }

    // Devuelve todos los productos en JSON para la tabla
    public function getProduct()
    {
        $productos = Producto::all();
        return response()->json(['productos' => $productos]);
    }

    // Página aparte "Registrar Producto" (menú lateral)
    public function create()
    {
        return view('productos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'productos' => 'required|string|max:20',
            'categoria' => 'required|string|max:30',
            'precio'    => 'required|numeric',
            'stock'     => 'required|integer',
        ]);

        Producto::create($request->only(['productos', 'categoria', 'precio', 'stock']));

        // Si viene por AJAX respondemos JSON, si viene del formulario normal redirigimos
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Producto creado exitosamente.',
            ]);
        }

        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'productos' => 'required|string|max:20',
            'categoria' => 'required|string|max:30',
            'precio'    => 'required|numeric',
            'stock'     => 'required|integer',
        ]);

        $producto = Producto::findOrFail($id);
        $producto->update($request->only(['productos', 'categoria', 'precio', 'stock']));

        return response()->json([
            'success'  => true,
            'message'  => 'Producto actualizado correctamente.',
            'producto' => $producto,
        ]);
    }

    public function destroy($producto)
    {
        $prod = Producto::where('idProductos', $producto)->firstOrFail();
        $prod->delete();

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado exitosamente.',
        ]);
    }
}
