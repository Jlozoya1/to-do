<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Lista de Tareas</title>
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
        .btn-primary {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Bienvenido {{ strtoupper(Auth::user()->name) }}</span>
            <form action="{{ route('logout') }}" method="POST" class="d-flex">
                @csrf
                <button type="submit" class="btn btn-outline-light">Cerrar Sesión</button>
            </form>
        </div>
    </nav>

    <div class="container">
        <!-- Formulario para agregar nueva tarea -->
        <div class="form-container">
            <h2 class="text-center">Agregar Nueva Tarea</h2>
            <form action="{{ route('tasks.store') }}" method="POST" class="mt-3">
                @csrf
                <div class="input-group">
                    <input type="text" name="name" class="form-control" placeholder="Nombre de la tarea" required>
                    <button type="submit" class="btn btn-primary">Añadir Tarea</button>
                </div>
            </form>
        </div>

        <!-- Lista de tareas -->
        <h2 class="mt-5">Tus Tareas</h2>
        <table class="table table-dark table-hover mt-3">
            <thead>
                <tr>
                    <th>Tarea</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="d-flex align-items-center">
                            @csrf
                            @method('PATCH')
                            <td>
                                <input type="text" name="name" class="form-control" value="{{ $task->name }}" required>
                            </td>
                            <td>
                                <select name="status" class="form-select" required>
                                    <option value="Por Hacer" {{ $task->status == 'Por Hacer' ? 'selected' : '' }}>Por Hacer</option>
                                    <option value="Pendiente" {{ $task->status == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="Completado" {{ $task->status == 'Completado' ? 'selected' : '' }}>Completado</option>
                                </select>
                            </td>
                            <td class="d-flex">
                                <button type="submit" class="btn btn-success me-2">Actualizar</button>
                        </form>
                                <!-- Formulario para eliminar tarea -->
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
