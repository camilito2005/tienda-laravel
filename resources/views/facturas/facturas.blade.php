@extends('layouts.menu')
@section('content')
<div class="container mt-5">
    @if (session('nombre'))
        <form action="{{route('Usuario.cerrar')}}" method="POST" class="mb-4">
            @csrf
            <button type="submit" class="btn btn-danger">Cerrar sesión</button>
        </form>

        <p class="text-center">Bienvenido, {{ session('nombre') }}</p>
        <p class="text-center">Correo: {{ session('correo') }}</p>
        <p class="text-center">Documento: {{ session('dni') }}</p>
        @else

    @endif
        <h4 class="text-center mb-4">Facturas</h4>

        <div class="form-container">
            <form action="{{route('facturas.crear')}}" method="POST" class="bg-light p-4 rounded shadow">
                @csrf
                <div class="form-group">
                    <label for="producto">Producto</label>
                    <select class="form-control" id="producto" name="producto" onchange="cargarDatos()">
                        <option value="" disabled selected>Seleccionar</option>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->nombre }}" data-stock="{{ $producto->stock }}"
                                @if($producto->stock <= 0) disabled @endif>
                                {{ $producto->nombre }} (disponibles: {{ $producto->stock }})
                            </option>
                        @endforeach
                    </select>

                    <label for="nombre">Nombre:</label>
                    <input class="form-control" type="text" id="nombre" required name="nombre" >

                    <label for="descripcion">Descripción:</label>
                    <input class="form-control" type="text" id="descripcion" required name="descripcion" >

                    <label for="cantidad">Cantidad:</label>
                    <input class="form-control" type="number" id="cantidad" required name="cantidad" min="1" max="100" onchange="calcularTotal()">

                    <label for="precio">Precio:</label>
                    <input class="form-control" type="text" id="precio" required name="precio" >

                    <label for="total">Total:</label>
                    <input class="form-control" type="text" id="total" required name="total" >
                </div>
                <button type="submit" class="btn btn-primary">Realizar Factura</button>
            </form>
        </div>

        <a href="{{ route('index') }}" class="btn btn-outline-secondary mt-3">
            <i class="fa-solid fa-house"></i> Inicio
        </a>
</div>

@push('scripts')
    <script src="{{asset('js/facturas.js')}}"></script>
@endpush
@endsection
