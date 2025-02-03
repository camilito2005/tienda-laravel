@extends('layouts.menu')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Agregar Productos</h4>
                </div>
                <div class="card-body">
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

                    <form action="{{ route('productos.ingresar') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del Producto</label>
                            <input id="nombre" type="text" name="nombre" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea id="descripcion" name="descripcion" class="form-control" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio</label>
                            <input id="precio" type="number" name="precio" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="cantidad" class="form-label">Cantidad</label>
                            <input id="cantidad" type="number" name="cantidad" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto del Producto</label>
                            <input type="file" name="foto" class="form-control" accept="image/*" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Agregar Producto</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ url('index') }}" class="btn btn-secondary">Inicio</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
