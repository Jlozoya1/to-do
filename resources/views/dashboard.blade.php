<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    {{-- <title>Dashboard - Lista de Tareas</title> --}}
    <!-- Incluir Bootstrap CSS -->
    @vite('resources/js/app.js')
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

    <div id="app">
      <router-view/>
    </div>


</body>
</html>
