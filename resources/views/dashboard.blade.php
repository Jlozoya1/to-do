<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Lista de Tareas</title>
    <!-- Incluir Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos personalizados */
        body {
            background-color: #212529; /* Fondo oscuro */
            color: #fff; /* Texto blanco */
        }
        .navbar {
            margin-bottom: 20px;
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto; /* Centrar el formulario */
        }
        .table {
            color: #fff;
        }
        .table thead th {
            border-bottom: 2px solid #dee2e6;
        }
        .table tbody tr td {
            border-top: 1px solid #dee2e6;
        }
    </style>
    <!-- Meta para CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <!-- Navbar -->
    {{-- <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">{{ strtoupper(Auth::user()->name) }}</span>
            <form action="{{ route('logout') }}" method="POST" class="d-flex">
                @csrf
                <button type="submit" class="btn btn-outline-light">Cerrar Sesión</button>
            </form>
        </div>
    </nav> --}}

    <div id="app">
      <app-sidebar></app-sidebar>
    </div>

    @vite('resources/js/app.js')
</body>
</html>
