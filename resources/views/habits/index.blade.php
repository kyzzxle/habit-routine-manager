@extends('layouts.app')

@section('page-title', 'Dashboard / Overview')

@section('content')

    <style>
        .hero {
            background: var(--navy);
            color: #fff;
            padding: 30px 32px;
            border-radius: 16px;
            margin-bottom: 24px;
            display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 16px;
        }
        .hero h2 { font-size: 23px; margin-bottom: 6px; }
        .hero p { font-size: 13.5px; color: #94A3B8; }
        .hero-date { font-size: 13px; color: #CBD5E1; text-align: right; }

        .stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 22px; }
        .stat-card { background: var(--white); border: 1px solid var(--border); border-radius: 14px; padding: 18px 20px; }
        .stat-card .icon { width: 34px; height: 34px; border-radius: 9px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; font-size: 15px; color: #fff; }
        .stat-total .icon { background: var(--indigo); }
        .stat-completed .icon { background: var(--emerald); }
        .stat-pending .icon { background: var(--amber); }
        .stat-streak .icon { background: var(--indigo-bright); }
        .stat-card .value { font-size: 25px; font-weight: 800; }
        .stat-card .label { font-size: 12.5px; color: var(--text-muted); font-weight: 500; margin-top: 2px; }

        .progress-panel { background: var(--white); border: 1px solid var(--border); border-radius: 14px; padding: 20px 22px; margin-bottom: 22px; }
        .progress-panel-top { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 13.5px; font-weight: 600; }
        .progress-bar-track { background: #EEF2F7; border-radius: 20px; height: 10px; overflow: hidden; }
        .progress-bar-fill { background: linear-gradient(90deg, var(--indigo), var(--emerald)); height: 100%; border-radius: 20px; transition: width 0.4s ease; }

        .achievements { display: flex; gap: 10px; margin-bottom: 22px; flex-wrap: wrap; }
        .achievement { display: flex; align-items: center; gap: 8px; padding: 9px 14px; border-radius: 10px; font-size: 12.5px; font-weight: 600; border: 1px solid var(--border); background: var(--white); color: #CBD5E1; }
        .achievement.earned { background: #FFFBEB; border-color: #FDE68A; color: #92400E; }

        .panel { background: var(--white); border: 1px solid var(--border); border-radius: 14px; padding: 22px; }
        .panel-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; gap: 16px; flex-wrap: wrap; }
        .panel-header h3 { font-size: 16px; font-weight: 700; }

        .filters { display: flex; gap: 10px; margin-bottom: 18px; flex-wrap: wrap; }
        .filters input, .filters select {
            padding: 9px 13px; border: 1px solid var(--border); border-radius: 9px; font-size: 13.5px; font-family: inherit; background: var(--white);
        }
        .filters input[type=text] { flex: 1; min-width: 180px; }

        .habit-card {
            display: flex; gap: 14px; align-items: flex-start;
            padding: 18px; border: 1px solid var(--border); border-radius: 12px; margin-bottom: 12px;
            border-left: 4px solid var(--indigo);
            transition: box-shadow 0.15s;
        }
        .habit-card:hover { box-shadow: 0 4px 14px rgba(15,23,42,0.06); }
        .habit-card.priority-High { border-left-color: var(--danger); }
        .habit-card.priority-Medium { border-left-color: var(--amber); }
        .habit-card.priority-Low { border-left-color: var(--text-muted); }

        .habit-main { flex: 1; min-width: 0; }
        .habit-top-row { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; margin-bottom: 6px; }
        .habit-name { font-size: 15.5px; font-weight: 700; }
        .habit-desc { font-size: 13.5px; color: var(--text-muted); margin-bottom: 10px; }
        .habit-meta { display: flex; gap: 8px; flex-wrap: wrap; }

        .pill { font-size: 11.5px; font-weight: 600; padding: 4px 10px; border-radius: 20px; }
        .pill-category { background: #EEF2FF; color: var(--indigo); }
        .pill-priority-High { background: #FEF2F2; color: var(--danger); }
        .pill-priority-Medium { background: #FFFBEB; color: #B45309; }
        .pill-priority-Low { background: #F1F5F9; color: var(--text-muted); }
        .pill-due { background: #F1F5F9; color: var(--text-muted); }
        .pill-streak { background: #FFFBEB; color: #B45309; }
        .badge-status { font-size: 12px; font-weight: 700; padding: 5px 12px; border-radius: 20px; }
        .badge-pending { background: #FFFBEB; color: #B45309; }
        .badge-completed { background: #ECFDF5; color: #047857; }

        .habit-actions { display: flex; gap: 8px; flex-shrink: 0; }

        .empty-state { text-align: center; padding: 50px 20px; color: var(--text-muted); }
        .empty-state .emoji { font-size: 34px; margin-bottom: 10px; }

        @media (max-width: 700px) {
            .stats { grid-template-columns: 1fr 1fr; }
            .habit-card { flex-direction: column; }
            .habit-actions { width: 100%; }
            .habit-actions .btn { flex: 1; text-align: center; justify-content: center; }
        }
    </style>

    <div class="hero">
        <div>
            <h2>Welcome back! 👋</h2>
            <p>Here's how your habits are shaping up today.</p>
        </div>
        <div class="hero-date">{{ now()->format('l, F d, Y') }}</div>
    </div>

    <div class="stats">
        <div class="stat-card stat-total">
            <div class="icon">📋</div>
            <div class="value">{{ $total }}</div>
            <div class="label">Total Habits</div>
        </div>
        <div class="stat-card stat-completed">
            <div class="icon">✓</div>
            <div class="value">{{ $completed }}</div>
            <div class="label">Completed</div>
        </div>
        <div class="stat-card stat-pending">
            <div class="icon">⏱</div>
            <div class="value">{{ $pending }}</div>
            <div class="label">Pending</div>
        </div>
        <div class="stat-card stat-streak">
            <div class="icon">🔥</div>
            <div class="value">{{ $bestStreak }}</div>
            <div class="label">Best Streak</div>
        </div>
    </div>

    <div class="progress-panel">
        <div class="progress-panel-top">
            <span>Today's Progress</span>
            <span>{{ $completed }} of {{ $total }} habits completed — {{ $percentage }}%</span>
        </div>
        <div class="progress-bar-track">
            <div class="progress-bar-fill" style="width: {{ $percentage }}%;"></div>
        </div>
    </div>

    <div class="achievements">
        <div class="achievement {{ $achievements['first_habit'] ? 'earned' : '' }}">🏅 First Habit</div>
        <div class="achievement {{ $achievements['seven_day_streak'] ? 'earned' : '' }}">🔥 7 Day Streak</div>
        <div class="achievement {{ $achievements['ten_completed'] ? 'earned' : '' }}">🏆 10 Completed</div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <h3>My Habits</h3>
            <a href="{{ route('habits.create') }}" class="btn btn-primary">➕ Add New Habit</a>
        </div>

        <form method="GET" action="{{ route('habits.index') }}" class="filters">
            <input type="text" name="search" placeholder="Search habits..." value="{{ request('search') }}">
            <select name="status" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="Pending" {{ request('status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Completed" {{ request('status') === 'Completed' ? 'selected' : '' }}>Completed</option>
            </select>
            <button type="submit" class="btn btn-secondary">Filter</button>
        </form>

        @if($habits->isEmpty())
            <div class="empty-state">
                <div class="emoji">🌱</div>
                @if(request('search') || request('status'))
                    <p>No habits match your search or filter.</p>
                @else
                    <p>No habits yet. Click "Add New Habit" to start your journey.</p>
                @endif
            </div>
        @else
            @foreach($habits as $habit)
                <div class="habit-card priority-{{ $habit->priority }}">
                    <div class="habit-main">
                        <div class="habit-top-row">
                            <span class="habit-name">{{ $habit->habit_name }}</span>
                            <span class="badge-status {{ $habit->status === 'Completed' ? 'badge-completed' : 'badge-pending' }}">
                                {{ $habit->status }}
                            </span>
                        </div>
                        @if($habit->description)
                            <div class="habit-desc">{{ $habit->description }}</div>
                        @endif
                        <div class="habit-meta">
                            <span class="pill pill-category">{{ $habit->category }}</span>
                            <span class="pill pill-priority-{{ $habit->priority }}">{{ $habit->priority }} Priority</span>
                            @if($habit->due_date)
                                <span class="pill pill-due">📅 {{ \Carbon\Carbon::parse($habit->due_date)->format('M d, Y') }}</span>
                            @endif
                            @if($habit->streak > 0)
                                <span class="pill pill-streak">🔥 {{ $habit->streak }} day streak</span>
                            @endif
                        </div>
                    </div>
                    <div class="habit-actions">
                        <a href="{{ route('habits.edit', $habit->id) }}" class="btn btn-edit">Edit</a>
                        <form action="{{ route('habits.destroy', $habit->id) }}" method="POST" onsubmit="return confirm('Delete this habit? This cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

@endsection