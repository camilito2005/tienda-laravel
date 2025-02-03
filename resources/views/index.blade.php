@extends('layouts.menu')
@section('content')
    @push('estilos')
        <link rel="stylesheet" href="{{asset('css/index.css')}}">
    @endpush
</head>
<body>
    <div class="container-fluid welcome-section">
        <div class="welcome-card bg-white">
            <h1 class="display-4">Bienvenido a la Plataforma</h1>
            <p class="lead">Gestiona tus dispositivos e inventarios de manera eficiente y organizada.</p>
            <hr class="my-4">
            <p>Explora las funcionalidades o comienza iniciando sesión.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{route('Usuario.login_html')}}" class="btn btn-custom btn-lg">Iniciar Sesión</a>
                <a href="#" class="btn btn-outline-primary btn-lg">Más Información</a>
            </div>
        </div>
    </div>

@endsection
