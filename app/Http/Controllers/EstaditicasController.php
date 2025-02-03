<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EstaditicasController extends Controller
{
    public function Filtro(Request $request)
    {
        $usuario = session('nombre'); // Obtener el usuario autenticado

        
        $fecha_inicio = $request->input('fecha_inicio', '');
        $fecha_final = $request->input('fecha_final', '');
        
        $resultados = [];
        
        if (!empty($fecha_inicio) && !empty($fecha_final)) {
            $resultados = DB::table('facturas as f')
                ->join('productos as p', 'f.producto_id', '=', 'p.id')
                ->select('f.id as factura_id', 'p.nombre as nombre_producto', 'f.stock', 'f.precio', 'f.total', 'f.fecha', 'f.cliente_correo')
                ->whereBetween('f.fecha', [$fecha_inicio, $fecha_final])
                ->get();
        }
        
        return view('estadisticas.filtro', compact('fecha_inicio', 'fecha_final', 'resultados'));
    }
    public function MasVentas()
    {
        // Consultar los 10 productos más vendidos
        $productosMasVendidos = DB::table('facturas as f')
            ->join('productos as p', 'f.producto_id', '=', 'p.id')
            ->select('p.nombre as nombre_producto', DB::raw('SUM(f.stock) as total_vendido'))
            ->groupBy('p.nombre')
            ->orderByDesc('total_vendido')
            ->limit(10)
            ->get();

        // Preparar datos para Chart.js
        $productos = $productosMasVendidos->pluck('nombre_producto')->toArray();
        $totales = $productosMasVendidos->pluck('total_vendido')->toArray();

        return view('estadisticas.masventas', compact('productos', 'totales'));
    }
    public function VentasPorMes(Request $request)
    {
        $titulo = "Ventas por Mes";
        $subtitulo = "Estadísticas de Ventas";
        $horas = array_map(fn($i) => str_pad($i, 2, "0", STR_PAD_LEFT), range(0, 23));
        $minutos = array_map(fn($i) => str_pad($i, 2, "0", STR_PAD_LEFT), range(0, 59));

        $productosVendidos = [];
        $totalProductos = 0;
        $totalDinero = 0;
        $fechaInicio = null;
        $fechaFin = null;

        if ($request->isMethod('get')) {
            // Obtener la fecha actual
            $fechaActual = now()->format('Y-m-d');
        
            // Obtener el primer y último día del mes actual
            $fechaInicioDefecto = now()->startOfMonth()->format('Y-m-d 00:00:00');
            $fechaFinDefecto = now()->endOfMonth()->format('Y-m-d 23:59:59');
        
            // Obtener los valores del formulario o usar los valores por defecto
            $fechaInicio = $request->input('fecha_inicio', now()->startOfMonth()->format('Y-m-d'));
            $fechaFin = $request->input('fecha_fin', now()->endOfMonth()->format('Y-m-d'));
            $horasInicio = $request->input('horas_iniciales', '00'); // 00 por defecto
            $minutosInicio = $request->input('minutos_iniciales', '00'); // 00 por defecto
            $horasFin = $request->input('horas_finales', '23'); // 23 por defecto
            $minutosFin = $request->input('minutos_finales', '59'); // 59 por defecto
        
            // Construir fecha completa
            $fechaInicio = "{$fechaInicio} {$horasInicio}:{$minutosInicio}:00";
            $fechaFin = "{$fechaFin} {$horasFin}:{$minutosFin}:59";
        
            // Verificar si las fechas son válidas
            if (!strtotime($fechaInicio) || !strtotime($fechaFin)) {
                $fechaInicio = $fechaInicioDefecto;
                $fechaFin = $fechaFinDefecto;
            }
            // dump("fecha inicio :".$fechaInicio);
            // dump("fecha final : ".$fechaFin);

        
            DB::enableQueryLog();
            $productosVendidos = DB::table('facturas as f')
                ->join('productos as p', 'f.producto_id', '=', 'p.id')
                ->select(
                    'p.nombre as nombre_producto',
                    'p.precio as precio_unitario',
                    DB::raw('SUM(f.stock) as total_vendido'),
                    DB::raw('SUM(f.total) as total_dinero')
                )
                ->whereBetween('f.fecha', [$fechaInicio, $fechaFin])
                ->groupBy('p.nombre', 'p.precio')
                ->orderByDesc('total_vendido')
                ->get();
        
            // dd(DB::getQueryLog());
        
            $totalProductos = $productosVendidos->sum('total_vendido');
            $totalDinero = $productosVendidos->sum('total_dinero');
        
            return view('estadisticas.ventasxmes', compact(
                'titulo', 'subtitulo', 'horas', 'minutos', 'productosVendidos', 'totalProductos', 'totalDinero',
                'fechaInicio', 'fechaFin'
            ));
    }else{
        return "error en el metodo";
    }
    }
}