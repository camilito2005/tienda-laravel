@extends('layouts.menu')
@section('content')
@push('estilos')
    <style>
        .card { margin-bottom: 20px; }
        .table-responsive { margin-top: 20px; }
    </style>
@endpush
@push('titulo')
 {{$titulo}}   
@endpush
    <div class="container mt-5">
        <h2 class="text-center">{{ $subtitulo }}</h2>
        <form action="{{route('estadisticas.ventasxmes')}}"  method="get" class="mt-4">
            @csrf
            <div class="form-row d-flex">
                <div class="form-group col-md-6">
                    <label for="fecha_inicio">Fecha de inicio</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" required>

                    <label>Horas iniciales:</label>
                    <select name="horas_iniciales" class="form-control">
                        @foreach ($horas as $hora)
                            <option value="{{ $hora }}">{{ $hora }}</option>
                        @endforeach
                    </select>

                    <label>Minutos iniciales:</label>
                    <select name="minutos_iniciales" class="form-control">
                        @foreach ($minutos as $minuto)
                            <option value="{{ $minuto }}">{{ $minuto }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="fecha_fin">Fecha de fin</label>
                    <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" required>

                    <label>Horas finales:</label>
                    <select name="horas_finales" class="form-control">
                        @foreach ($horas as $hora)
                            <option value="{{ $hora }}">{{ $hora }}</option>
                        @endforeach
                    </select>

                    <label>Minutos finales:</label>
                    <select name="minutos_finales" class="form-control">
                        @foreach ($minutos as $minuto)
                            <option value="{{ $minuto }}">{{ $minuto }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </form>
        {{-- @if (!empty($productosVendidos)) --}}
            <div class="row mt-4">
                @forelse ($productosVendidos as $producto)
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $producto->nombre_producto }}</h5>
                                <p class="card-text">Precio unitario: <strong>{{ number_format($producto->precio_unitario) }}</strong></p>
                                <p class="card-text">Total generado: <strong>{{ number_format($producto->total_dinero) }}</strong></p>
                                <p class="card-text">Total Vendido: <strong>{{ $producto->total_vendido }}</strong></p>
                            </div>
                        </div>
                    </div>
            </div>

            <p><strong>Total ventas:</strong> {{ $totalProductos }}</p>
            <p><strong>Total dinero:</strong> {{ number_format($totalDinero) }}</p>

            <form action="{{ url('estadisticas/pdf') }}" method="post" target="_blank">
                @csrf
                <input type="hidden" name="fecha_inicio" value="{{ $fechaInicio }}">
                <input type="hidden" name="fecha_fin" value="{{ $fechaFin }}">
                <button class="btn btn-outline-secondary">Generar PDF</button>
            </form>
            @empty
            <div class="alert alert-info mt-4">No se encontraron productos vendidos entre {{$fechaInicio }} y {{$fechaFin}} </div>
            @endforelse

        <form action="{{ url('/') }}" method="post">
            @csrf
            <button class="btn btn-outline-secondary" type="submit">Inicio</button>
        </form>
    </div>
@push('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> 
@endpush
@endsection
