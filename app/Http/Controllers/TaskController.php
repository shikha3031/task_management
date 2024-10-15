<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaskController extends Controller
{
    // Display a listing of the tasks for the web
    public function index(): \Illuminate\View\View
    {
        $tasks = Task::all();
        return view('tasks.index', compact('tasks'));
    }

    // API - Fetch all tasks
    public function apiIndex(): JsonResponse
    {
        $tasks = Task::all();
        return response()->json(['success' => true, 'data' => $tasks], 200);
    }

    // Show form for creating a new task
    public function create(): \Illuminate\View\View
    {
        return view('tasks.create');
    }

    // Store a newly created task (API & Web)
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'task_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date'
        ]);

        $task = Task::create([
            'task_name' => $request->task_name,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'is_completed' => false,
        ]);

        return response()->json(['success' => true, 'data' => $task], 201);
    }

    // Show form for editing a task
    public function edit($id): \Illuminate\View\View
    {
        $task = Task::findOrFail($id);
        return view('tasks.edit', compact('task'));
    }

    // Update a task (API & Web)
    public function update(Request $request, $id)
    {
        // Validate the incoming data
        $request->validate([
            'task_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
        ]);
    
        // Find the task by ID and update its details
        $task = Task::find($id);
    
        if ($task) {
            $task->task_name = $request->input('task_name');
            $task->description = $request->input('description');
            $task->due_date = $request->input('due_date');
            $task->save();
            
            // Redirect to the index page with a success message
            return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
        }
    
        // If the task is not found, redirect back with an error message
        return redirect()->route('tasks.index')->with('error', 'Task not found.');
    }
    
    // Custom method to toggle task completion
    public function toggleComplete(Task $task): JsonResponse
    {
        $task->is_completed = !$task->is_completed;
        $task->save();

        return response()->json(['success' => true, 'data' => $task], 200);
    }
}
