<x-app-layout>
    <style>
        * {
            box-sizing: border-box;
        }

        .dashboard-container {
            background: linear-gradient(135deg, #f9fafb 0%, #eff6ff 100%);
            min-height: calc(100vh - 64px);
            padding: 2rem 1.5rem;
        }

        .header-section {
            margin-bottom: 2rem;
        }

        .date-badge {
            display: inline-block;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            color: #2563eb;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
        }

        .greeting-title {
            font-size: 2rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.5rem;
        }

        .greeting-subtitle {
            font-size: 1rem;
            color: #6b7280;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 1.75rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            border-left: 4px solid;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .stat-card.todo {
            border-left-color: #f59e0b;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(254, 252, 231, 0.3) 100%);
        }

        .stat-card.inprogress {
            border-left-color: #06b6d4;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(207, 250, 254, 0.3) 100%);
        }

        .stat-card.completed {
            border-left-color: #10b981;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(220, 252, 231, 0.3) 100%);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-card.todo .stat-icon {
            background: rgba(245, 158, 11, 0.15);
            color: #f59e0b;
        }

        .stat-card.inprogress .stat-icon {
            background: rgba(6, 182, 212, 0.15);
            color: #06b6d4;
        }

        .stat-card.completed .stat-icon {
            background: rgba(16, 185, 129, 0.15);
            color: #10b981;
        }

        .stat-badge {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.35rem 0.75rem;
            border-radius: 999px;
            color: #6b7280;
        }

        .stat-badge.up {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #111827;
            margin: 0.5rem 0;
        }

        .stat-label {
            font-size: 0.875rem;
            color: #6b7280;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        @media (max-width: 1024px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
        }

        .content-card {
            background: #fff;
            border-radius: 12px;
            padding: 1.75rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .card-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .card-title::before {
            content: '';
            width: 4px;
            height: 24px;
            background: linear-gradient(180deg, #2563eb 0%, #1d4ed8 100%);
            border-radius: 2px;
        }

        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .activity-item {
            display: flex;
            gap: 1rem;
            padding: 1rem;
            border-radius: 8px;
            background: #f9fafb;
            transition: all 0.2s ease;
        }

        .activity-item:hover {
            background: #eff6ff;
        }

        .activity-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-top: 6px;
            flex-shrink: 0;
        }

        .activity-content {
            flex: 1;
        }

        .activity-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: #111827;
            margin-bottom: 0.25rem;
        }

        .activity-time {
            font-size: 0.8rem;
            color: #9ca3af;
        }

        .category-breakdown {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .category-bar {
            height: 60px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .category-bar:hover {
            transform: scaleY(1.05);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .category-bar.work {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .category-bar.personal {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

        .category-bar.design {
            background: linear-gradient(135deg, #ec4899 0%, #be185d 100%);
        }

        .category-bar.dev {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        }

        .category-legend {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            border-radius: 8px;
            background: #f9fafb;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 3px;
        }

        .empty-state {
            text-align: center;
            padding: 2rem;
            color: #6b7280;
        }

        .empty-state-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
    </style>

    <div class="dashboard-container">
        <!-- Header -->
        <div class="header-section">
            <div class="date-badge">{{ \Carbon\Carbon::now()->format('D - d M Y') }}</div>
            <h1 class="greeting-title">Hello, {{ Auth::user()->name }}.</h1>
            <p class="greeting-subtitle">Here's an overview of your tasks today.</p>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card todo">
                <div class="stat-header">
                    <div class="stat-icon">�</div>
                    <span class="stat-badge up">↑ +2</span>
                </div>
                <div class="stat-number">{{ $todoCount ?? 7 }}</div>
                <div class="stat-label">To Do</div>
            </div>

            <div class="stat-card inprogress">
                <div class="stat-header">
                    <div class="stat-icon">⚙️</div>
                    <span class="stat-badge up">↑ +2</span>
                </div>
                <div class="stat-number">{{ $inProgressCount ?? 2 }}</div>
                <div class="stat-label">In Progress</div>
            </div>

            <div class="stat-card completed">
                <div class="stat-header">
                    <div class="stat-icon">✓</div>
                    <span class="stat-badge up">↑ +2</span>
                </div>
                <div class="stat-number">{{ $completedCount ?? 3 }}</div>
                <div class="stat-label">Completed</div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="content-grid">
            <!-- Recent Activity -->
            <div class="content-card">
                <h3 class="card-title">Recent Activity</h3>
                <div class="activity-list">
                    @if(isset($tasks) && $tasks->count() > 0)
                        @foreach($tasks->take(6) as $task)
                            <div class="activity-item">
                                <div class="activity-dot" style="background: {{ $task->category?->color ?? '#10b981' }};"></div>
                                <div class="activity-content">
                                    <div class="activity-title">"{{ $task->title }}" created</div>
                                    <div class="activity-time">{{ $task->created_at->diffForHumans() }}</div>
                                </div>
                                @if($task->description)
                                <button type="button" class="btn btn-sm btn-outline-info" 
                                data-bs-toggle="modal" data-bs-target="#descModal{{ $task->id }}" 
                title="View Description">
                <i class="bi bi-file-text"></i>
            </button>
        @endif
                            </div>
                        @endforeach
                    @else
                        <div class="activity-item">
                            <div class="activity-dot" style="background: #10b981;"></div>
                            <div class="activity-content">
                                <div class="activity-title">"Accessibility Audit" task created</div>
                                <div class="activity-time">12 minutes ago</div>
                            </div>
                        </div>

                        <div class="activity-item">
                            <div class="activity-dot" style="background: #f59e0b;"></div>
                            <div class="activity-content">
                                <div class="activity-title">"Integrate Stripe" moved to In Progress</div>
                                <div class="activity-time">38 minutes ago</div>
                            </div>
                        </div>

                        <div class="activity-item">
                            <div class="activity-dot" style="background: #06b6d4;"></div>
                            <div class="activity-content">
                                <div class="activity-title">"Q2 Roadmap" task created</div>
                                <div class="activity-time">1 hour ago</div>
                            </div>
                        </div>

                        <div class="activity-item">
                            <div class="activity-dot" style="background: #ef4444;"></div>
                            <div class="activity-content">
                                <div class="activity-title">"Client Call Acme" task deleted</div>
                                <div class="activity-time">2 hours ago</div>
                            </div>
                        </div>

                        <div class="activity-item">
                            <div class="activity-dot" style="background: #f59e0b;"></div>
                            <div class="activity-content">
                                <div class="activity-title">"Figma Designs" updated</div>
                                <div class="activity-time">3 hours ago</div>
                            </div>
                        </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Category Breakdown -->
            <div class="content-card">
                <h3 class="card-title">By Category</h3>
                <div class="category-breakdown">
                    <div class="category-bar work"></div>
                    <div class="category-bar personal"></div>
                    <div class="category-bar design"></div>
                    <div class="category-bar dev"></div>
                </div>
                <div class="category-legend">
                    <div class="legend-item">
                        <div class="legend-color"
                            style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);"></div>
                        <span>Work <strong style="color: #111827; margin-left: auto;">3</strong></span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color"
                            style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);"></div>
                        <span>Personal <strong style="color: #111827; margin-left: auto;">2</strong></span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color"
                            style="background: linear-gradient(135deg, #ec4899 0%, #be185d 100%);"></div>
                        <span>Design <strong style="color: #111827; margin-left: auto;">3</strong></span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color"
                            style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);"></div>
                        <span>Development <strong style="color: #111827; margin-left: auto;">4</strong></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Description Modals -->
    @if(isset($tasks) && $tasks->count() > 0)
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
    @endif
</x-app-layout>