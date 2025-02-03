<?php

use App\Http\Controllers\CatalogoConntroller;
use App\Http\Controllers\Controller;
use App\Http\Controllers\EstaditicasController;
use App\Http\Controllers\FacturasController;
use App\Http\Controllers\ProductosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [UsuariosController::class , 'index'])->name('index');

Route::get('/Usuarios/formulario', [UsuariosController::class,'formularioClientes'])->name('Usuarios.formulario');

Route::post('/Usuarios/ingresar', [UsuariosController::class , 'guardar'])->name('Usuario.ingresar');

Route::get('/Usuarios' , [UsuariosController::class , 'MostrarUsuarios'])->name('Usuario.Mostrar');

Route::get('/Usuarios/login_form' , [UsuariosController::class , 'Login_html'])->name('Usuario.login_html');

Route::post('usuarios/Login', [usuariosController::class, 'Login'])->name('Usuario.login');

Route::post('/cerrarsesion',[usuariosController::class, 'Logout'])->name('Usuario.cerrar');

Route::get('/EditarUsuarios/{id}',[usuariosController::class, 'EditarU'])->name('Usuario.editar');

Route::put('/usuarios/{id}', [usuariosController::class, 'ActualizarU'])->name('Usuario.actualizar');

Route::delete('/usuarios/{id}',[usuariosController::class, 'EliminarU'])->name('Usuario.eliminar');

Route::get('/usuarios/enviarcorreo',[usuariosController::class, 'FormularioRestablecer'])->name('Usuario.formulariocorreo');

Route::post('/usuarios/RecuperarContraseña',[usuariosController::class, 'requestReset'])->name('Usuario.restablecer');

Route::get('/usuarios/reset/{token}', [usuariosController::class, 'resetForm'])->name('Usuario.reset.form');

Route::post('/usuarios/reset', [usuariosController::class, 'resetPassword'])->name('Usuario.update');

Route::get('/Productos/formulario' , [ProductosController::class , 'Formulario'])->name('productos.formulario');

Route::post('/productos/ingresar' , [ProductosController::class , 'Ingresar'])->name('productos.ingresar');

Route::get('/productos' , [ProductosController::class , 'Mostrar'])->name('productos.mostrar');

Route::delete('/productos/eliminar/{id}' , [ProductosController::class , 'Eliminar'])->name('productos.eliminar');

Route::get('/catalogo', [CatalogoConntroller::class , 'Catalogo'])->name('productos.catalogo');

Route::get('/catalogo/detalles/{id}', [CatalogoConntroller::class , 'Detalles'])->name('productos.detalles');


Route::get('/carrito', [CatalogoConntroller::class, 'mostrarCarrito'])->name('carrito.index');
Route::post('/carrito/agg', [CatalogoConntroller::class, 'Agregar'])->name('carrito.agregar');
Route::post('/carrito/vaciar', [CatalogoConntroller::class, 'vaciarCarrito'])->name('carrito.vaciar');
Route::post('/carrito/actualizar', [CatalogoConntroller::class, 'actualizarCarrito'])->name('carrito.actualizar');
Route::post('/carrito/eliminar', [CatalogoConntroller::class, 'eliminarProducto'])->name('carrito.eliminar');

Route::get('estadisticas/filtro' , [EstaditicasController::class , 'Filtro'])->name('estadisticas.filtro');
Route::get('Estadisticas/mas-ventas' , [EstaditicasController::class , 'MasVentas'])->name('estadisticas.masventas');
Route::match(['get', 'post'], '/Estadisticas/ventaspormes', [EstaditicasController::class, 'VentasPorMes'])->name('estadisticas.ventasxmes');
// Route::match(['get', 'post'], '/Estaditicas/ventasxmes', [EstaditicasController::class, 'FiltroMes'])->name('estadisticas.ventaspormes');

Route::get('Facturas' , [FacturasController::class , 'FormFacturas'])->name('Facturas');
Route::get('Facturas/cargardatos' , [FacturasController::class , 'CargarDatos'])->name('facturas.cargardatos');
Route::post('Facturas/facturar' , [FacturasController::class , 'Facturar'])->name('facturas.crear');

