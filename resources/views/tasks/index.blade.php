@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

{{-- GREETING --}}
<div class="mb-4">
    <p style="color:#6b7280; font-size:13px; text-transform:uppercase; letter-spacing:1px;">
        {{ strtoupper(now()->format('D · d M Y')) }}
    </p>
    <h2 style="font-size:28px; font-weight:700; color:#111827;">
        Hello, {{ auth()->user()->name }}.
    </h2>
    <p style="color:#6b7280;">Here's an overview of your tasks today.</p>
</div>

{{-- STAT CARDS --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card to_do">
            <div class="number" style="color:#f59e0b;">{{ $counts['to_do'] }}</div>
            <div class="label">To Do</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card in_progress">
            <div class="number" style="color:#3b82f6;">{{ $counts['in_progress'] }}</div>
            <div class="label">In Progress</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card done">
            <div class="number" style="color:#10b981;">{{ $counts['done'] }}</div>
            <div class="label">Completed</div>
        </div>
    </div>
</div>

{{-- FILTERS --}}
<div class="bg-white rounded-3 p-3 mb-4" style="border:1px solid #e5e7eb;">
    <form method="GET" action="{{ route('tasks.index') }}" class="d-flex gap-2 flex-wrap">
        <select name="status" class="form-select form-select-sm" style="width:160px;">
            <option value="">All Statuses</option>
            <option value="to_do" {{ request('status') == 'to_do' ? 'selected' : '' }}>To Do</option>
            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
            <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>Done</option>
        </select>
        <select name="category_id" class="form-select form-select-sm" style="width:160px;">
            <option value="">All Categories</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-sm btn-dark">Filter</button>
        <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
    </form>
</div>

{{-- TASKS TABLE --}}
<div class="bg-white rounded-3" style="border:1px solid #e5e7eb;">
    <table class="table table-hover mb-0">
        <thead style="background:#f9fafb;">
            <tr>
                <th style="font-size:12px; color:#6b7280; padding:16px;">TITLE</th>
                <th style="font-size:12px; color:#6b7280;">CATEGORY</th>
                <th style="font-size:12px; color:#6b7280;">STATUS</th>
                <th style="font-size:12px; color:#6b7280;">DUE DATE</th>
                <th style="font-size:12px; color:#6b7280;">ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tasks as $task)
            <tr>
                <td style="padding:16px; font-weight:500;">{{ $task->title }}</td>
                <td>
                    <span class="badge" style="background:#f3f4f6; color:#374151;">
                        {{ $task->category->name }}
                    </span>
                </td>
                <td>
                    <form action="{{ route('tasks.updateStatus', $task) }}" method="POST">
                        @csrf @method('PATCH')
                        <select name="status" onchange="this.form.submit()"
                            class="form-select form-select-sm" style="width:130px; font-size:12px;">
                            <option value="to_do" {{ $task->status == 'to_do' ? 'selected' : '' }}>To Do</option>
                            <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="done" {{ $task->status == 'done' ? 'selected' : '' }}>Done</option>
                        </select>
                    </form>
                </td>
                <td>
                    @if($task->due_date)
                        <span class="{{ \Carbon\Carbon::parse($task->due_date)->isPast() && $task->status != 'done' ? 'overdue' : '' }}">
                            {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}
                        </span>
                    @else
                        <span style="color:#9ca3af;">—</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('tasks.edit', $task) }}"
                        class="btn btn-sm btn-outline-secondary me-1">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                        class="d-inline" onsubmit="return confirm('Delete this task?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-5" style="color:#9ca3af;">
                    <i class="bi bi-inbox" style="font-size:32px;"></i>
                    <p class="mt-2">No tasks found. Create your first task!</p>
                    <a href="{{ route('tasks.create') }}" class="btn btn-sm btn-dark mt-2">+ New Task</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($tasks->hasPages())
    <div class="p-3 border-top">
        {{ $tasks->links() }}
    </div>
    @endif
</div>

@endsection 
