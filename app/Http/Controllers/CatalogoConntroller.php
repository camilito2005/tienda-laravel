<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Productos;
use Illuminate\Support\Facades\Session;

class CatalogoConntroller extends Controller
{
    public function Catalogo(){

        $productos = Productos::all();
        // $productos = DB::table('productos');
        return view('catalogo.catalogo', compact('productos'));
    }
    public function Detalles($id)
    {

        // Obtener el producto desde la base de datos
        $producto = DB::table('productos')->where('id', $id)->first();

        // Si el producto no existe, redirigir con error
        if (!$producto) {
            return redirect()->route('productos.catalogo')->with(['mensaje'=> 'Producto no encontrado.', 'type'=>'danger']);
        }

        return view('catalogo.detalles', compact('producto'));
    }
    public function mostrarCarrito()
    {
        $carrito = session()->get('carrito', []);


        return view('catalogo.carrito', compact('carrito'));
    }
    // public function MostrarCarrito()
    // {
    //     $carrito = Session::get('carrito', []);

    //     if (empty($carrito)) {
    //         return response()->json([
    //             'mensaje' => 'No hay nada en el carrito',
    //             'link' => route('catalogo.index')
    //         ]);
    //     }

    //     return view('catologo.carrito', compact('carrito'));
    // }
      // Agregar producto al carrito
      public function Agregar(Request $request)
      {
          $id = $request->input('id');
          $producto = [
              'id' => $id,
              'nombre' => $request->input('nombre'),
              'descripcion' => $request->input('descripcion'),
              'precio' => $request->input('precio'),
              'stock' => $request->input('stock'),
              'foto' => $request->input('foto'),
              'cantidad' => $request->input('cantidad')
          ];
  
          $carrito = Session::get('carrito', []);
  
          if (isset($carrito[$id])) {
              $carrito[$id]['cantidad'] += $producto['cantidad'];
          } else {
              $carrito[$id] = $producto;
          }
  
          Session::put('carrito', $carrito);
  
          return redirect()->route('carrito.index');
      }
  

    public function vaciarCarrito()
    {
        session()->forget('carrito');
        return redirect()->route('productos.catalogo')->with(['mensaje'=> 'Carrito vaciado correctamente.','type' => 'success']);
    }

    public function actualizarCarrito(Request $request)
    {
        $id = $request->input('id');
        $cantidad = $request->input('cantidad');
        
        $carrito = session()->get('carrito', []);
        
        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad'] = $cantidad;
            session()->put('carrito', $carrito);
        }
        
        return redirect()->route('carrito.index')->with(['mensaje'=> 'Carrito actualizado correctamente.', 'type' => 'success']);
    }

    public function eliminarProducto(Request $request)
    {
        $id = $request->input('id');
        $carrito = session()->get('carrito', []);
        
        if (isset($carrito[$id])) {
            unset($carrito[$id]);
            session()->put('carrito', $carrito);
        }
        
        return redirect()->route('carrito.index')->with(['mensaje'=> 'Producto eliminado del carrito.', 'type' => 'success']);
    }
}
