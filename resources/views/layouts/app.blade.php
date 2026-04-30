<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; display: flex; height: 100vh; overflow: hidden; }

        /* SIDEBAR */
        .sidebar {
            width: 240px;
            background: #111827;
            color: white;
            display: flex;
            flex-direction: column;
            padding: 24px 16px;
            height: 100vh;
            position: fixed;
            left: 0; top: 0;
        }
        .sidebar .logo {
            font-size: 20px;
            font-weight: 700;
            color: #10b981;
            margin-bottom: 40px;
            padding-left: 8px;
        }
        .sidebar .logo i { margin-right: 8px; }
        .sidebar nav a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            color: #9ca3af;
            text-decoration: none;
            font-size: 14px;
            margin-bottom: 4px;
            transition: all 0.2s;
        }
        .sidebar nav a:hover, .sidebar nav a.active {
            background: #1f2937;
            color: white;
        }
        .sidebar nav a i { font-size: 16px; }
        .sidebar .user-section {
            margin-top: auto;
            border-top: 1px solid #1f2937;
            padding-top: 16px;
        }
        .sidebar .user-section .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }
        .sidebar .user-section .avatar {
            width: 36px; height: 36px;
            background: #10b981;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 14px; color: white;
        }
        .sidebar .user-section .user-name { font-size: 13px; font-weight: 600; color: white; }
        .sidebar .user-section .user-email { font-size: 11px; color: #6b7280; }
        .sidebar .logout-btn {
            width: 100%;
            background: none;
            border: 1px solid #374151;
            color: #9ca3af;
            padding: 8px;
            border-radius: 8px;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .sidebar .logout-btn:hover { background: #1f2937; color: white; }

        /* MAIN CONTENT */
        .main-content {
            margin-left: 240px;
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow-y: auto;
        }

        /* TOPBAR */
        .topbar {
            background: white;
            padding: 16px 32px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .topbar .page-title { font-size: 18px; font-weight: 600; color: #111827; }

        /* PAGE BODY */
        .page-body { padding: 32px; }

        /* ALERTS */
        .alert { border-radius: 10px; font-size: 14px; }

        /* STATUS BADGES */
        .badge-todo { background: #fef3c7; color: #92400e; }
        .badge-in_progress { background: #dbeafe; color: #1e40af; }
        .badge-done { background: #d1fae5; color: #065f46; }

        /* OVERDUE */
        .overdue { color: #ef4444; font-weight: 600; }

        /* CARDS */
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            border-left: 4px solid;
        }
        .stat-card.todo { border-color: #f59e0b; }
        .stat-card.in_progress { border-color: #3b82f6; }
        .stat-card.done { border-color: #10b981; }
        .stat-card .number { font-size: 36px; font-weight: 700; }
        .stat-card .label { font-size: 12px; color: #6b7280; text-transform: uppercase; letter-spacing: 1px; }
    </style>
</head>
<body>

{{-- SIDEBAR --}}
<aside class="sidebar">
    <div class="logo">
        <i class="bi bi-check2-square"></i> TaskManager
    </div>

    <nav>
    <a href="{{ route('tasks.index') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>
    <a href="{{ route('tasks.list') }}" class="{{ request()->is('tasks') ? 'active' : '' }}">
    <i class="bi bi-list-task"></i> My Tasks
    </a>
    <a href="{{ route('tasks.create') }}" class="{{ request()->is('tasks/create') ? 'active' : '' }}">
        <i class="bi bi-plus-circle"></i> New Task
    </a>
</nav>

    <div class="user-section">
        <div class="user-info">
            <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div>
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-email">{{ auth()->user()->email }}</div>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="logout-btn"><i class="bi bi-box-arrow-left"></i> Logout</button>
        </form>
    </div>
</aside>

{{-- MAIN --}}
<div class="main-content">

    {{-- TOPBAR --}}
    <div class="topbar">
        <span class="page-title">@yield('title', 'Dashboard')</span>
        <a href="{{ route('tasks.create') }}" class="btn btn-sm" style="background:#10b981; color:white; border-radius:8px;">
            <i class="bi bi-plus"></i> New Task
        </a>
    </div>

    {{-- CONTENT --}}
    <div class="page-body">
        @if(session('success'))
            <div class="alert alert-success mb-4">{{ session('success') }}</div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
