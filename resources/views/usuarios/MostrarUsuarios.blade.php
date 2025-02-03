@extends('layouts.menu')
@section('content')
    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @endpush
    @if (session('mensaje'))
        @include('layouts.alertas', [
            'title' => session('type') == 'Danger' ? 'Error' : 'Info',
            'message' => session('mensaje'),
            'type' => session('type'),
        ])
    @endif
    <div class="container mt-4">
        <h3 class="text-center text-secondary">Usuarios</h3>

        <!-- Barra de búsqueda -->
        <div class="input-group my-4 justify-content-center">
            <input type="search" id="search" class="form-control w-50" placeholder="Buscar...">
        </div>

        <!-- Tabla de usuarios -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>DNI</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Correo</th>
                        <th>Cargo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="resultados-usuarios">
                    @forelse($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->id }}</td>
                            <td>{{ $usuario->dni }}</td>
                            <td>{{ $usuario->nombre }}</td>
                            <td>{{ $usuario->apellido }}</td>
                            <td>{{ $usuario->telefono }}</td>
                            <td>{{ $usuario->direccion }}</td>
                            <td>{{ $usuario->correo }}</td>
                            <td>{{ $usuario->cargo }}</td>
                            <td>
                                <a href="{{route('Usuario.editar',$usuario->id)}}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-pen">m</i>
                                </a>
                                <form action="{{route('Usuario.eliminar',$usuario->id)}}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash">E</i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">No hay usuarios registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Botón para agregar usuarios -->
        <div class="text-center my-4">
            <a href="{{ route('Usuarios.formulario') }}" class="btn btn-outline-secondary">
                <i class="fas fa-user-plus"></i> Agregar Usuarios
            </a>
        </div>

        <!-- Botón para volver al inicio -->
        <div class="text-center">
            <a href="{{ route('index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-house"></i> Inicio
            </a>
        </div>
    </div>
@endsection
