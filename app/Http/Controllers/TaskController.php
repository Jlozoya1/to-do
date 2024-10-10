<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // Muestra la lista de tareas
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())->get(); // Obtiene las tareas del usuario autenticado
        return view('dashboard', compact('tasks'));
    }

    // Almacena una nueva tarea
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:Por Hacer,Pendiente,Completado',
        ]);

        $task = Task::create([
            'name' => $request->name,
            'status' => $request->status,
            'user_id' => Auth::id(),
        ]);

        return response()->json($task, 201);
    }

    // Elimina una tarea
    public function destroy(Task $task)
    {
        if ($task->user_id != Auth::id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $task->delete();

        return response()->json(['message' => 'Tarea eliminada'], 200);
    }


    // Marca una tarea como completada
    public function toggleCompleted(Task $task)
    {
        if ($task->user_id == Auth::id()) {
            $task->completed = !$task->completed;
            $task->save();
            return redirect()->route('dashboard');
        }

        return redirect()->route('dashboard')->with('error', 'No tienes permiso para actualizar esta tarea');
    }

    // Actualizar una tarea (nombre y estado)
    public function update(Request $request, Task $task)
    {
        if ($task->user_id != Auth::id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:Por Hacer,Pendiente,Completado',
        ]);

        $task->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'Tarea actualizada'], 200);
    }


    public function apiIndex()
    {
        $tasks = Task::where('user_id', Auth::id())->get();
        return response()->json($tasks);
    }
}
