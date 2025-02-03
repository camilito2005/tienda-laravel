<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductosController extends Controller
{
    public function Formulario()
    {
        return view('productos.formulario');
    }
    public function Ingresar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'cantidad' => 'required|integer|min:1',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Guardar la imagen en storage/app/public/productos
        $rutaImagen = $request->file('foto')->store('productos', 'public');

        $consulta = DB::table('productos')->insert([
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
            'precio' => $request->input('precio'),
            'stock' => $request->input('cantidad'),
            'imagen' => $rutaImagen,
            'fecha_creacion' => now(),
        ]);
        

        if ($consulta) {
            return redirect()->route('productos.mostrar')->with(['mensaje' => 'Producto agregado correctamente.', 'type' => 'success']);
        }
        else {
            return redirect()->route('productos.formulario')->with(['mensaje' => 'Producto agregado correctamente.', 'type' => 'success']);
        }
        
    }
    public function Mostrar(){
        date_default_timezone_set('America/Bogota');
        $fecha = date('d-m-Y g:i:s A');
        
        $productos = DB::table('productos')->orderBy('id','asc')->get();

        return view('productos.mostrar', compact('productos', 'fecha'));
    }
    public function eliminar($id)
    {
        // Verificar si el producto existe
        $producto = DB::table('productos')->where('id', $id)->first();

        if (!$producto) {
            return redirect()->route('productos.mostrar')->with('error', 'Producto no encontrado');
        }

        // Eliminar el producto
        DB::table('productos')->where('id', $id)->delete();

        return redirect()->route('productos.mostrar')->with(['mensaje'=> 'Producto eliminado correctamente' , 'type' => 'info']);
    }
}
