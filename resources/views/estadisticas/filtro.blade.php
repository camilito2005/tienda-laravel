@extends('layouts.menu')

@section('content')
<link rel="stylesheet" href="{{ asset('css/filtro.css') }}">

<div class="container">
    <h2 class="text-center">📊 Estadísticas de Productos Vendidos</h2>

    <div class="card p-4">
        <form method="get" action="{{ route('estadisticas.filtro') }}" class="mb-4">
            @csrf
            <div class="row">
                <div class="col-md-5">
                    <label for="fecha_inicio">📅 Fecha Inicio:</label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio" value="{{ $fecha_inicio }}" class="form-control" required>
                </div>
                <div class="col-md-5">
                    <label for="fecha_final">📅 Fecha Fin:</label>
                    <input type="date" id="fecha_final" name="fecha_final" value="{{ $fecha_final }}" class="form-control" required>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">🔍 Filtrar</button>
                </div>
            </div>
        </form>

        @if(!empty($fecha_inicio) && !empty($fecha_final))
            @if($resultados->isEmpty())
                <p class="text-danger text-center">❌ No se encontraron productos vendidos en este rango de fechas.</p>
            @else
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID Factura</th>
                            <th>Producto</th>
                            <th>Cantidad Vendida</th>
                            <th>Precio</th>
                            <th>Total</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($resultados as $fila)
                            <tr>
                                <td>{{ $fila->factura_id }}</td>
                                <td>{{ $fila->nombre_producto }}</td>
                                <td>{{ $fila->stock }}</td>
                                <td>${{ number_format($fila->precio) }}</td>
                                <td>${{ number_format($fila->total) }}</td>
                                <td>{{ $fila->fecha }}</td>
                                <td>{{ $fila->cliente_correo }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        @endif

        <div class="d-flex justify-content-between">
            <form method="POST" action="" target="_blank">
                @csrf
                <input type="hidden" name="fecha_inicio" value="{{ $fecha_inicio }}">
                <input type="hidden" name="fecha_final" value="{{ $fecha_final }}">
                <button class="btn btn-danger">📄 Generar PDF</button>
            </form>

            <a href="{{ route('index') }}" class="btn btn-secondary">🏠 Inicio</a>
        </div>
    </div>
</div>
@endsection
