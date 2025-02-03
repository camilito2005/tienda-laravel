<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productos;
use App\Models\Facturas;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FacturasController extends Controller
{
    public function CargarDatos(Request $request)
    {
        $nombre = $request->query('nombre');

        $producto = Productos::where('nombre', $nombre)->first();

        if (!$producto) {
            return response()->json(['error' => 'Producto no encontrado.'], 404);
        }

        return response()->json($producto);
    }
    

    public function FormFacturas(){
        $usuario = session('nombre');

        $productos = DB::table('productos')->get();

        return view('facturas.Facturas' , compact('usuario','productos'));
    }

    public function Facturar(Request $request)
    {
        $request->validate([
            'producto' => 'required|string',
            'cantidad' => 'required|integer|min:1',
        ]);

        $usuario = session('correo');

        $producto = Productos::where('nombre', $request->producto)->first();

        if (!$producto) {
            return back()->with('error', 'Producto no encontrado.');
        }

        if ($producto->stock < $request->cantidad) {
            return back()->with('error', 'No hay suficiente stock para este producto.');
        }

        $producto->stock -= $request->cantidad;
        $producto->save();

        $total = $producto->precio * $request->cantidad;

        Facturas::create([
            'producto_id' => $producto->id,
            'stock' => $request->cantidad,
            'precio' => $producto->precio,
            'total' => $total,
            'fecha' => Carbon::now(),
            'cliente_correo' => $usuario ?? 'cliente@example.com',
        ]);

        return redirect()->route('Facturas')->with(['mensaje' => 'Factura procesada con éxito. Se han restado {stock} del producto ', 'type' => 'success']);
        // return back()->with('success', "");
        // return back()->with('success', "Factura procesada con éxito. Se han restado {$request->cantidad} del producto {$producto->nombre}.");{$producto->nombre}.
    }
}
