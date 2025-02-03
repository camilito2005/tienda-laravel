@extends('layouts.menu')
@section('content')
@section('titulo', 'Inicio de Sesión')
@push('estilos')
<link rel="stylesheet" href="{{asset('css/login.css')}}">
@endpush
    @if (session('mensaje'))
    @include('layouts.alertas', [
        'title' => session('type') == 'Danger' ? 'Error' : 'Info',
        'message' => session('mensaje'),
        'type' => session('type'),
    ])
@endif
{{-- @if ($mensaje)
    @include('layouts.alert', [
        'title' => $title,
        'message' => $message,
        'type' => $type,
    ]) --}}
{{-- @endif --}}

    <div class="login-container">
        <div class="login-card">
            <h2 class="text-center">Inicia Sesión</h2>
            {{-- <p class="text-center text-secondary">Conéctate con tus datos</p> --}}
            <form action="{{route('Usuario.login')}}" method="post">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                @csrf
                <div class="mb-3">
                    <input type="text" name="correo" class="form-control" placeholder="Correo Electrónico" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="contraseña" class="form-control" placeholder="Contraseña" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                </div>
            </form>
            <a class="link-recuperar" href="">¿Olvidaste tu contraseña?</a>
        </div>
    </div>
    <form id="myForm" action="" onsubmit="showLoading()" method="get">
        <button class="btn btn-outline-secondary" value="inicio">
            <i class="fa-solid fa-user-plus"></i> Agregar usuarios
        </button>
    </form>
    <form id="myForm" action="{{route('index')}}" onsubmit="showLoading()" method="get">
        <button class="btn btn-outline-secondary" value="inicio">
            <i class="fa-solid fa-house"></i> Inicio
        </button>
    </form>
</body>
</html>
@endsection