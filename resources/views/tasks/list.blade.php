@extends('layouts.app')
@section('title', 'My Tasks')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 style="font-size:24px; font-weight:700; color:#111827;">My Tasks</h2>
        <p style="color:#6b7280;">Manage and track all your tasks</p>
    </div>
    <!-- #region 
     
    
    -->
</div>

{{-- FILTERS --}}
<div class="bg-white rounded-3 p-3 mb-4" style="border:1px solid #e5e7eb;">
    <form method="GET" action="{{ route('tasks.list') }}" class="d-flex gap-2 flex-wrap">
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
                    @if($task->description)
                        <button type="button" class="btn btn-sm btn-outline-info me-1" 
                            data-bs-toggle="modal" data-bs-target="#descModal{{ $task->id }}" 
                            title="View Description">
                            <i class="bi bi-file-text"></i>
                        </button>
                    @endif
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
                    <p class="mt-2">No tasks found.</p>
                    <a href="{{ route('tasks.create') }}" class="btn btn-sm btn-dark mt-2">
                        + New Task
                    </a>
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

<!-- Description Modals -->
@foreach($tasks as $task)
@if($task->description)
<div class="modal fade" id="descModal{{ $task->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: 2px solid #e5e7eb;">
                <h5 class="modal-title" style="font-weight:700; color:#111827;">{{ $task->title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="color:#374151; line-height:1.6;">
                <div class="mb-3">
                    <small style="color:#6b7280; text-transform:uppercase; font-weight:600;">Description</small>
                    <p style="margin-top:0.5rem; font-size:0.95rem;">{{ nl2br($task->description) }}</p>
                </div>
                @if($task->due_date)
                <div class="mb-3">
                    <small style="color:#6b7280; text-transform:uppercase; font-weight:600;">Due Date</small>
                    <p style="margin-top:0.5rem; font-size:0.95rem;">
                        {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}
                    </p>
                </div>
                @endif
                @if($task->category)
                <div class="mb-3">
                    <small style="color:#6b7280; text-transform:uppercase; font-weight:600;">Category</small>
                    <p style="margin-top:0.5rem; font-size:0.95rem;">{{ $task->category->name }}</p>
                </div>
                @endif
                <div>
                    <small style="color:#6b7280; text-transform:uppercase; font-weight:600;">Status</small>
                    <p style="margin-top:0.5rem; font-size:0.95rem;">
                        <span class="badge" style="background:{{ $task->status == 'done' ? '#dcfce7' : ($task->status == 'in_progress' ? '#cffafe' : '#fef3c7') }}; color:{{ $task->status == 'done' ? '#166534' : ($task->status == 'in_progress' ? '#164e63' : '#92400e') }};">
                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                        </span>
                    </p>
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #e5e7eb;">
                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-dark">
                    <i class="bi bi-pencil"></i> Edit
                </a>
            </div>
        </div>
    </div>
</div>
@endif
@endforeach

@endsection
