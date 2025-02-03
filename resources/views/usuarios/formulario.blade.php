@extends('layouts.menu')
@section('content')
@if (session('mensaje'))
    @include('layouts.alertas', [
        'title' => session('type') == 'Danger' ? 'Error' : 'Info',
        'message' => session('mensaje'),
        'type' => session('type'),
    ])
@endif
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Registro de Clientes</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    <form id="myForm" action="{{route('Usuario.ingresar')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="dni" class="form-label">DNI</label>
                            <input id="dni" type="text" name="dni" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="rol" class="form-label">Rol</label>
                            <select id="rol" name="rol" class="form-select" required>
                                @foreach($roles as $valor )
                                    <option value="{{ $valor->id }}">{{ $valor->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input id="nombre" type="text" name="nombre" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellidos</label>
                            <input id="apellido" type="text" name="apellido" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="telefono" class="form-label">Número Telefónico</label>
                            <input id="telefono" type="tel" name="telefono" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input id="direccion" type="text" name="direccion" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo Electrónico</label>
                            <input id="correo" type="email" name="correo" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="contraseña" class="form-label">Contraseña</label>
                            <input id="contraseña" type="password" name="contraseña" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="confirmar_contraseña" class="form-label">Confirmar Contraseña</label>
                            <input id="confirmar_contraseña" type="password" name="contraseña_confirmation" class="form-control" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Registrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container center-align">
        <form action="{{route('index')}}" onsubmit="showLoading()" method="post">
            <button class="btn-flat waves-effect">
                <i class="material-icons left">Inicio</i> 
            </button>
        </form>
    </div>
</div>
@endsection