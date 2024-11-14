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
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">{{ strtoupper(Auth::user()->name) }}</span>
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
            <form id="task-form" class="mt-3">
                <div class="input-group">
                    <input type="text" id="task-name" class="form-control" placeholder="Nombre de la tarea" required>
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
            <tbody id="task-list">
                <!-- Las tareas se cargarán aquí -->
            </tbody>
        </table>
    </div>

    <!-- Incluir Bootstrap JS y dependencias -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Código JavaScript para manejar LocalStorage y la Base de Datos -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Cargar tareas desde LocalStorage
            loadTasksFromLocalStorage();

            // Evento para agregar nueva tarea
            document.getElementById('task-form').addEventListener('submit', function(e) {
                e.preventDefault();
                let taskName = document.getElementById('task-name').value.trim();
                if (taskName) {
                    addTask(taskName);
                    document.getElementById('task-name').value = ''; // Limpiar el campo de texto
                }
            });
        });

        const userId = {{ Auth::id() }};
        let tasks = []; // Array global para almacenar las tareas
        let pendingActions = JSON.parse(localStorage.getItem('pending_actions_user_' + userId)) || [];

        // Variable para detectar el estado de conexión
        let isOnline = navigator.onLine;

        window.addEventListener('online', () => {
            isOnline = true;
            syncPendingActions();
        });

        window.addEventListener('offline', () => {
            isOnline = false;
            alert('Estás sin conexión. Los cambios se guardarán localmente y se sincronizarán cuando vuelvas a estar en línea.');
        });

        // Función para cargar tareas desde LocalStorage
        function loadTasksFromLocalStorage() {
            tasks = JSON.parse(localStorage.getItem('tasks_user_' + userId)) || [];
            renderTasks();
            // Cargar tareas desde la base de datos y sincronizar
            loadTasksFromDatabase();
        }

        // Función para cargar tareas desde la base de datos y sincronizar
        function loadTasksFromDatabase() {
            fetch('/tasksAPI', {
                method: 'GET',
                credentials: 'include',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                data.forEach(taskFromDB => {
                    // Verificar si la tarea ya existe en LocalStorage
                    let exists = tasks.some(task => task.id === taskFromDB.id);
                    if (!exists) {
                        tasks.push(taskFromDB);
                    }
                });
                localStorage.setItem('tasks_user_' + userId, JSON.stringify(tasks));
                renderTasks();
            })
            .catch(error => console.error('Error al cargar tareas desde la base de datos:', error));
        }

        // Función para renderizar las tareas en la tabla
        function renderTasks() {
            let taskList = document.getElementById('task-list');
            taskList.innerHTML = '';
            tasks.forEach((task, index) => {
                let row = document.createElement('tr');

                // Columna para el nombre de la tarea (editable)
                let taskNameCell = document.createElement('td');
                let taskNameInput = document.createElement('input');
                taskNameInput.type = 'text';
                taskNameInput.className = 'form-control';
                taskNameInput.value = task.name;
                taskNameInput.oninput = function() {
                    updateTaskName(index, this.value);
                };
                taskNameCell.appendChild(taskNameInput);
                row.appendChild(taskNameCell);

                // Columna para el estado (dropdown)
                let taskStatusCell = document.createElement('td');
                let taskStatusSelect = document.createElement('select');
                taskStatusSelect.className = 'form-select';
                let statuses = ['Por Hacer', 'Pendiente', 'Completado'];
                statuses.forEach(status => {
                    let option = document.createElement('option');
                    option.value = status;
                    option.text = status;
                    if (task.status === status) {
                        option.selected = true;
                    }
                    taskStatusSelect.appendChild(option);
                });
                taskStatusSelect.onchange = function() {
                    updateTaskStatus(index, this.value);
                };
                taskStatusCell.appendChild(taskStatusSelect);
                row.appendChild(taskStatusCell);

                // Columna para acciones
                let actionsCell = document.createElement('td');
                actionsCell.className = 'd-flex';

                // Botón Actualizar
                let updateButton = document.createElement('button');
                updateButton.textContent = 'Actualizar';
                updateButton.className = 'btn btn-success me-2';
                updateButton.onclick = function() {
                    updateTask(index);
                };
                actionsCell.appendChild(updateButton);

                // Botón Eliminar
                let deleteButton = document.createElement('button');
                deleteButton.textContent = 'Eliminar';
                deleteButton.className = 'btn btn-danger';
                deleteButton.onclick = function() {
                    deleteTask(index);
                };
                actionsCell.appendChild(deleteButton);

                row.appendChild(actionsCell);

                // Agregar la fila a la tabla
                taskList.appendChild(row);
            });
        }

        // Función para agregar una nueva tarea
        function addTask(taskName) {
            // Crear objeto de tarea
            let newTask = {
                id: Date.now(), // Usar timestamp como ID temporal
                name: taskName,
                status: 'Por Hacer',
            };

            tasks.push(newTask);
            localStorage.setItem('tasks_user_' + userId, JSON.stringify(tasks));
            renderTasks();

            if (isOnline) {
                // Enviar a la base de datos
                sendAddTaskToServer(newTask);
            } else {
                // Guardar acción pendiente
                pendingActions.push({
                    action: 'add',
                    task: newTask,
                });
                localStorage.setItem('pending_actions_user_' + userId, JSON.stringify(pendingActions));
            }
        }

        function sendAddTaskToServer(task) {
            fetch('/tasks', {
                method: 'POST',
                credentials: 'include',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({
                    name: task.name,
                    status: task.status,
                }),
            })
            .then(response => response.json())
            .then(taskFromDB => {
                // Actualizar el ID de la tarea con el ID real de la base de datos
                tasks = tasks.map(t => {
                    if (t.id === task.id) {
                        t.id = taskFromDB.id;
                    }
                    return t;
                });
                localStorage.setItem('tasks_user_' + userId, JSON.stringify(tasks));
                renderTasks();
            })
            .catch(error => console.error('Error al agregar tarea a la base de datos:', error));
        }

        // Función para actualizar el nombre de una tarea
        function updateTaskName(index, newName) {
            tasks[index].name = newName;
            localStorage.setItem('tasks_user_' + userId, JSON.stringify(tasks));
        }

        // Función para actualizar el estado de una tarea
        function updateTaskStatus(index, newStatus) {
            tasks[index].status = newStatus;
            localStorage.setItem('tasks_user_' + userId, JSON.stringify(tasks));
        }

        // Función para actualizar una tarea (enviar cambios a la base de datos)
        function updateTask(index) {
            let task = tasks[index];
            localStorage.setItem('tasks_user_' + userId, JSON.stringify(tasks));

            if (isOnline) {
                // Actualizar en la base de datos
                sendUpdateTaskToServer(task);
            } else {
                // Guardar acción pendiente
                pendingActions.push({
                    action: 'update',
                    task: task,
                });
                localStorage.setItem('pending_actions_user_' + userId, JSON.stringify(pendingActions));
            }
        }

        function sendUpdateTaskToServer(task) {
            fetch(`/tasks/${task.id}`, {
                method: 'PATCH',
                credentials: 'include',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({
                    name: task.name,
                    status: task.status,
                }),
            })
            .then(response => {
                if (response.ok) {
                    console.log('Tarea actualizada en la base de datos');
                } else {
                    throw new Error('Error al actualizar la tarea en la base de datos');
                }
            })
            .catch(error => console.error(error));
        }

        // Función para eliminar una tarea
        function deleteTask(index) {
            let task = tasks[index];
            let taskId = task.id;
            tasks.splice(index, 1); // Eliminar tarea del array
            localStorage.setItem('tasks_user_' + userId, JSON.stringify(tasks));
            renderTasks();

            if (isOnline) {
                // Eliminar de la base de datos
                sendDeleteTaskToServer(taskId);
            } else {
                // Guardar acción pendiente
                pendingActions.push({
                    action: 'delete',
                    taskId: taskId,
                });
                localStorage.setItem('pending_actions_user_' + userId, JSON.stringify(pendingActions));
            }
        }

        function sendDeleteTaskToServer(taskId) {
            fetch(`/tasks/${taskId}`, {
                method: 'DELETE',
                credentials: 'include',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            })
            .then(response => {
                if (response.ok) {
                    console.log('Tarea eliminada de la base de datos');
                } else {
                    throw new Error('Error al eliminar la tarea de la base de datos');
                }
            })
            .catch(error => console.error(error));
        }

        // Función para sincronizar acciones pendientes al reconectarse
        function syncPendingActions() {
            if (pendingActions.length === 0) return;

            pendingActions.forEach(actionObj => {
                if (actionObj.action === 'add') {
                    sendAddTaskToServer(actionObj.task);
                } else if (actionObj.action === 'update') {
                    sendUpdateTaskToServer(actionObj.task);
                } else if (actionObj.action === 'delete') {
                    sendDeleteTaskToServer(actionObj.taskId);
                }
            });

            // Limpiar la cola de acciones pendientes
            pendingActions = [];
            localStorage.setItem('pending_actions_user_' + userId, JSON.stringify(pendingActions));
        }
    </script>
</body>
</html>
