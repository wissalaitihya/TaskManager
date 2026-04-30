@extends('layouts.app')
@section('title', 'Edit Task')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="bg-white rounded-3 p-4" style="border:1px solid #e5e7eb;">
            <h5 class="mb-4" style="font-size:18px; font-weight:700;">Edit Task</h5>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('tasks.update', $task) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- TITLE --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $task->title) }}"
                        class="form-control" placeholder="Enter task title...">
                </div>

                {{-- DESCRIPTION --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" rows="4"
                        class="form-control" placeholder="Enter task description...">{{ old('description', $task->description) }}</textarea>
                </div>

                {{-- CATEGORY --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                    <select name="category_id" class="form-select">
                        <option value="">Select a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $task->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- STATUS --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select">
                        <option value="to_do" {{ old('status', $task->status) == 'to_do' ? 'selected' : '' }}>To Do</option>
                        <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="done" {{ old('status', $task->status) == 'done' ? 'selected' : '' }}>Done</option>
                    </select>
                </div>

                {{-- DUE DATE --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">Due Date</label>
                    <input type="date" name="due_date"
                        value="{{ old('due_date', $task->due_date) }}"
                        class="form-control">
                </div>

                {{-- BUTTONS --}}
                <div class="d-flex gap-2">
                    <button type="submit" class="btn text-white px-4"
                        style="background:#10b981; border-radius:8px;">
                        <i class="bi bi-check-circle me-1"></i> Update Task
                    </button>
                    <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary px-4"
                        style="border-radius:8px;">
                        Cancel
                    </a>
                </div>

            </form>
        </div>

    </div>
</div>
@endsection
