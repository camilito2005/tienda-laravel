@extends('layouts.menu')

@section('content')


    <h2>Carrito de Compras</h2>

    @if(session('carrito') && count(session('carrito')) > 0)
        <form action="{{ route('carrito.vaciar') }}" method="POST">
            @csrf
            <button class="btn btn-outline-secondary mb-4" type="submit">
                <i class="fa-solid fa-eraser"></i> Vaciar el carrito
            </button>
        </form>

        @foreach(session('carrito') as $id => $producto)
            @php
                $precio = number_format($producto['precio'], 2);
                $totalProducto = number_format($producto['precio'] * $producto['cantidad'], 2);
            @endphp

            <div class="card mb-4" style="width: 23rem; margin: auto;">
                <img src="{{asset('storage')}}/{{ $producto['foto'] }}" class="card-img-top" alt="{{ $producto['nombre'] }}" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    {{-- <h5 class="card-title">Referencia: {{ $producto['id'] }}</h5> --}}
                    <h6 class="card-subtitle mb-2 text-muted">Nombre: {{ $producto['nombre'] }}</h6>
                    <p>Precio: ${{ $precio }}</p>
                    <p>Disponibles: {{ $producto['stock'] }}</p>
                    <p>Descripción: {{ $producto['descripcion'] }}</p>
                    <p>Total: ${{ $totalProducto }}</p>
                </div>
                <div class="card-footer">
                    <form action="{{ route('carrito.actualizar') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="id" value="{{ $id }}">
                        <label for="cantidad" class="mr-2">Cantidad:</label>
                        <input type="number" name="cantidad" value="{{ $producto['cantidad'] }}" min="1" max="{{ $producto['stock'] }}" class="form-control mx-2" style="width: 70px;">
                        <button type="submit" class="btn btn-outline-primary">Actualizar</button>
                    </form>

                    <form action="{{ route('carrito.eliminar') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="id" value="{{ $id }}">
                        <button type="submit" class="btn btn-outline-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        @endforeach
    @else
        <p class="text-danger">El carrito está vacío.</p>
    @endif

    <a href="{{ route('productos.catalogo') }}" class="btn btn-outline-secondary mt-3">
        <i class="fa-solid fa-shop"></i> Volver a la tienda
    </a>
</div>
@endsection
