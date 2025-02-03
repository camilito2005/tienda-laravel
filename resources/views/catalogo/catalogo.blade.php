@extends('layouts.menu')

@section('content')

<h4 class="text-center text-secondary">Productos</h4>

<div class="input-search text-center">
    <input type="search" id="search" class="form-control" placeholder="Buscar" style="width: 300px; display: inline-block;">
</div>

@if(session('mensaje'))
    <div class="alert alert-{{ session('type') }}">
        {{ session('mensaje') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if(session('nombre'))
    <div class="container-fluid text-end">
        <span>{{ session('correo') }}</span>
        <form action="{{ route('Usuario.cerrar') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm">
                <i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión
            </button>
        </form>
    </div>
@else
    <div class="container-fluid text-end">
        <a href="{{ route('Usuario.login') }}" class="btn btn-primary btn-sm">
            <i class="fa-solid fa-right-from-bracket"></i> Iniciar sesión
        </a>
    </div>
@endauth

<div class="container">
    <div class="row">
        @forelse ($productos as $producto)
            <div class="col-md-3">
                <a href="{{route('productos.detalles',$producto->id)}}">
                    <div class="card mx-4 mt-4">
                        <img src=" {{asset('storage')}}/{{ $producto->imagen }}" class="card-img-top" alt="{{ $producto->nombre }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $producto->nombre }}</h5>
                            <p class="card-text"><strong>Precio: ${{ number_format($producto->precio, 2) }}</strong></p>
                            @if ($producto->stock <= 0)
                                <p class="agotado">Agotado</p>
                            @endif
                        </div>
                        <div class="card-footer">
                            <form action="" method="post" class="d-inline">
                                @csrf
                                <input type="hidden" name="id" value="{{ $producto->id }}">
                                <input name="nombre" type="hidden" value="{{ $producto->nombre }}">
                                <input name="descripcion" type="hidden" value="{{ $producto->descripcion }}">
                                <input name="precio" type="hidden" value="{{ $producto->precio }}">
                                <input name="stock" type="hidden" value="{{ $producto->stock }}">
                                <input name="foto" type="hidden" value="{{ $producto->imagen }}">
                                <button type="submit" class="btn btn-success" {{ $producto->stock <= 0 ? 'disabled' : '' }}>Comprar</button>
                            </form>

                            <form action="{{route('carrito.agregar')}}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="id" value="{{ $producto->id }}">
                                <input name="nombre" type="hidden" value="{{ $producto->nombre }}">
                                <input name="descripcion" type="hidden" value="{{ $producto->descripcion }}">
                                <input name="precio" type="hidden" value="{{ $producto->precio }}">
                                <input name="stock" type="hidden" value="{{ $producto->stock }}">
                                <input name="foto" type="hidden" value="{{ $producto->imagen }}">
                                <button type="submit" class="btn btn-primary" {{ $producto->stock <= 0 ? 'disabled' : '' }}>Agregar al carrito</button>
                            </form>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12 text-center">
                <p>No hay productos registrados.</p>
            </div>
        @endforelse
    </div>

    <div class="text-center">
        <form action="{{route('carrito.index')}}" method="get" class="mt-4">
            @csrf
            <button id="carrito" class="btn btn-info"><i class="fa-solid fa-cart-shopping"></i> Ver carrito</button>
        </form>
    </div>

    <p class="text-center">Total de productos: {{ $productos->count() }}</p>
</div>

<form action="{{ url('index') }}" method="get" class="text-center mt-4">
    <button class="btn btn-outline-secondary">
        <i class="fa-solid fa-house"></i> Inicio
    </button>
</form>
@endsection
