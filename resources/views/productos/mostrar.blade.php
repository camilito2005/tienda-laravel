@extends('layouts.menu')
@section('content')
    
@push('estilos')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush
    
    <div class="container mt-4">
        <h3 class="text-center">Lista de Productos</h3>

        <div class="input-search text-center mb-3">
            <input type="search" id="search" class="form-control" placeholder="Buscar" style="width: 300px; display: inline-block;">
        </div>

        <div class="mb-3 text-center">
            <a href="" class="btn btn-warning"><i class="fa-solid fa-file-excel"></i></a>
            <a href="" target="_blank" class="btn btn-success"><i class="fa-solid fa-file-pdf"></i></a>
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
        
<p>Fecha y hora: {{ now()->format('d-m-Y g:i:s A') }}</p>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($productos as $producto)
                    <tr>
                        <td>{{ $producto->id }}</td>
                        <td>
                            <img src="{{  asset('storage')."/".$producto->imagen }}" height="80" width="100">
                            {{-- <img src="{{  Storage::url($producto->imagen) }}" height="70" width="100"> --}}
                        </td>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->descripcion }}</td>
                        <td>{{ number_format($producto->precio, 0, ',', '.') }}</td>
                        <td>{{ $producto->stock }}</td>
                        <td>
                            <a href="" class="btn btn-warning">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{route('productos.eliminar',$producto->id)}}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button name="eliminar" class="btn btn-danger" type="submit" onclick="return confirm('¿Seguro que deseas eliminar este producto?')">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No hay productos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <p>Total: {{ $productos->count() }}</p>

        <div class="text-center">
            <a href="" class="btn btn-outline-secondary">
                <i class="fa-solid fa-shop"></i> Ver Catálogo
            </a>
            <a href="{{ route('productos.formulario') }}" class="btn btn-outline-secondary">
                <i class="fa-solid fa-plus"></i> Agregar Producto
            </a>
            <a href="{{ url('index') }}" class="btn btn-outline-secondary">
                <i class="fa-solid fa-house"></i> Inicio
            </a>
        </div>
    </div>

@endsection