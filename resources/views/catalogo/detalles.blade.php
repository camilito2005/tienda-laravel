@extends('layouts.menu')
@section('content')
@push('estilos')
<link rel="stylesheet" href="{{ asset('css/detalles.css') }}">
@endpush
    <div class="container mt-5">
        <div class="card">
            <div class="row g-0">
                <div class="col-md-5 text-center p-3">
                    <img src="{{ asset('storage') }}/{{ $producto->imagen }}" class="img-fluid rounded" alt="{{ $producto->nombre }}">
                </div>
                <div class="col-md-7">
                    <div class="card-body">
                        <h3 class="card-title">{{ $producto->nombre }}</h3>
                        <p><strong>Descripción:</strong> {{ $producto->descripcion }}</p>
                        <p><strong>Cop:</strong> ${{ number_format($producto->precio, 2) }}</p>
                        <p><strong>Disponibles:</strong> {{ $producto->stock }}</p>
                        
                        @if ($producto->stock <= 0)
                            <p class="text-danger fw-bold">Agotado</p>
                        @endif
                        
                        <form action="" method="post" class="mt-3">
                            @csrf
                            <input type="hidden" name="id_producto" value="{{ $producto->id }}">
                            <div class="mb-3">
                                <label for="cantidad" class="form-label">Cantidad:</label>
                                <input type="number" name="cantidad" id="cantidad" class="form-control" value="1" min="1" max="{{ $producto->stock }}" required>
                            </div>
                            @if ($producto->stock > 0)
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-cart-plus"></i> Agregar al carrito
                                </button>
                            @endif
                        </form>
                        
                        <p class="mt-3"><strong>Referencia:</strong> {{ $producto->descripcion }}</p>
                        <p><strong>Categoría:</strong> N/A</p>
                        <p><strong>Subcategoría:</strong> N/A</p>
                        <p><strong>Envío:</strong> N/A</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('productos.catalogo') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver al catálogo
            </a>
        </div>
    </div>
    @endsection
