@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Task Details</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $task->task_name }}</h5>
            <p class="card-text">
                <strong>Description:</strong>
                {{ $task->description ? $task->description : 'No description provided.' }}
            </p>
            <p class="card-text">
                <strong>Due Date:</strong>
                {{ $task->due_date ? $task->due_date->format('Y-m-d H:i') : 'No due date set' }}
            </p>
            <p class="card-text">
                <strong>Status:</strong>
                {{ $task->is_completed ? 'Completed' : 'Pending' }}
            </p>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back to List</a>
        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning">Edit Task</a>
        
        <!-- Optional: Add a Delete button -->
        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this task?');">Delete Task</button>
        </form>
    </div>
</div>
@endsection
