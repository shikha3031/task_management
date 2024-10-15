@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Task List</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('tasks.create') }}" class="btn btn-success mb-3">Create Task</a>

    <table class="table">
        <thead>
            <tr>
                <th>Task Name</th>
                <th>Description</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
                <tr class="{{ $task->is_completed ? 'table-success' : ($task->due_date <= now()->addDay() ? 'table-warning' : '') }}">
                    <td>{{ $task->task_name }}</td>
                    <td>{{ $task->description }}</td>
                    <td>{{ \Carbon\Carbon::parse($task->due_date)->format('Y-m-d H:i') }}</td>
                    <td>{{ $task->is_completed ? 'Completed' : 'Pending' }}</td>
                    <td>
                        <button onclick="toggleComplete({{ $task->id }})" class="btn btn-secondary">Mark Complete</button>
                        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary">Edit</a>
                        <button onclick="deleteTask({{ $task->id }})" class="btn btn-danger">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    function toggleComplete(taskId) {
        axios.patch(`/tasks/${taskId}/toggle`)
            .then(response => {
                if (response.data.success) {
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error toggling task completion:', error);
            });
    }

    function deleteTask(taskId) {
        if (confirm('Are you sure you want to delete this task?')) {
            axios.delete(`/tasks/${taskId}`)
                .then(response => {
                    if (response.data.success) {
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error deleting task:', error);
                });
        }
    }
</script>
@endsection
