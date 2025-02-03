@extends('layouts.menu')

@section('content')
<link rel="stylesheet" href="{{ asset('css/estadisticas.css') }}">

<div class="container">
    <h2 class="text-center">📊 Top 10 Productos Más Vendidos</h2>

    <div class="card p-4">
        <canvas id="chartProductos"></canvas>
    </div>

    <div class="mt-3 text-center">
        <a href="{{ route('index') }}" class="btn btn-secondary">🏠 Inicio</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('chartProductos').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($productos) !!},
            datasets: [{
                label: 'Total Vendido',
                data: {!! json_encode($totales) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
