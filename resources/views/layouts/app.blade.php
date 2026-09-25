<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Habit & Routine Manager')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy: #0F172A;
            --indigo: #4F46E5;
            --indigo-bright: #6366F1;
            --emerald: #10B981;
            --amber: #F59E0B;
            --bg: #F8FAFC;
            --white: #FFFFFF;
            --text: #0F172A;
            --text-muted: #64748B;
            --border: #E2E8F0;
            --danger: #EF4444;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 264px;
            background: var(--navy);
            color: #fff;
            padding: 28px 22px;
            flex-shrink: 0;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }
        .brand { display: flex; align-items: center; gap: 12px; margin-bottom: 4px; }
        .brand-icon {
            width: 38px; height: 38px;
            background: var(--indigo);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 16px;
        }
        .brand-title { font-weight: 700; font-size: 15px; line-height: 1.3; }
        .brand-sub { font-size: 12px; color: #94A3B8; margin: 10px 0 32px; }
        .nav-section-label { font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748B; margin: 18px 0 8px 4px; }
        .nav-link {
            display: flex; align-items: center; gap: 10px;
            padding: 11px 14px;
            border-radius: 10px;
            color: #CBD5E1;
            text-decoration: none;
            font-size: 14px; font-weight: 500;
            margin-bottom: 4px;
            transition: background 0.15s, color 0.15s;
        }
        .nav-link:hover { background: rgba(255,255,255,0.06); color: #fff; }
        .nav-link.active { background: var(--indigo); color: #fff; }
        .sidebar-footer {
            margin-top: 40px;
            font-size: 12.5px;
            color: #94A3B8;
            border-top: 1px solid rgba(255,255,255,0.08);
            padding-top: 18px;
            line-height: 1.5;
        }
        .sidebar-footer strong { color: #E2E8F0; }

        /* Main area */
        .main { flex: 1; padding: 32px 42px; min-width: 0; }
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 26px; gap: 16px; }
        .topbar h1 { font-size: 21px; font-weight: 700; }
        .topbar-right { display: flex; align-items: center; gap: 14px; }
        .status-online { font-size: 13px; color: var(--emerald); display: flex; align-items: center; gap: 6px; font-weight: 500; }
        .status-online::before { content: ''; width: 7px; height: 7px; border-radius: 50%; background: var(--emerald); display: inline-block; }
        .menu-toggle {
            display: none;
            background: var(--white); border: 1px solid var(--border); border-radius: 8px;
            width: 38px; height: 38px; font-size: 16px; cursor: pointer;
        }

        .alert-success {
            background: #ECFDF5; color: #047857; border: 1px solid #A7F3D0;
            padding: 13px 18px; border-radius: 10px; margin-bottom: 20px; font-size: 14px; font-weight: 500;
        }

        /* Buttons */
        .btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 10px 18px; border-radius: 10px; font-size: 13.5px; font-weight: 600;
            text-decoration: none; border: none; cursor: pointer; transition: all 0.15s;
        }
        .btn-primary { background: var(--indigo); color: #fff; }
        .btn-primary:hover { background: #4338CA; transform: translateY(-1px); }
        .btn-edit { background: #EEF2FF; color: var(--indigo); }
        .btn-edit:hover { background: #E0E7FF; }
        .btn-delete { background: #FEF2F2; color: var(--danger); }
        .btn-delete:hover { background: #FEE2E2; }
        .btn-secondary { background: var(--white); color: var(--text); border: 1px solid var(--border); }
        .btn-secondary:hover { background: #F1F5F9; }

        @media (max-width: 900px) {
            .sidebar { position: fixed; left: -280px; top: 0; bottom: 0; z-index: 100; transition: left 0.25s ease; width: 260px; }
            .sidebar.open { left: 0; }
            .menu-toggle { display: block; }
            .main { padding: 22px; }
        }
    </style>
</head>
<body>
    <aside class="sidebar" id="sidebar">
        <div class="brand">
            <div class="brand-icon">✓</div>
            <div class="brand-title">Habit & Routine<br>Manager</div>
        </div>
        <div class="brand-sub">Build better habits.<br>Become better every day.</div>

        <div class="nav-section-label">Main</div>
        <a href="{{ route('habits.index') }}" class="nav-link {{ request()->routeIs('habits.index') ? 'active' : '' }}">📊 Dashboard</a>
        <a href="{{ route('habits.create') }}" class="nav-link {{ request()->routeIs('habits.create') ? 'active' : '' }}">➕ Add Habit</a>

        <div class="sidebar-footer">
            <strong>Small steps every day</strong><br>lead to big results.
        </div>
    </aside>

    <main class="main">
        <div class="topbar">
            <div style="display:flex; align-items:center; gap:14px;">
                <button class="menu-toggle" onclick="document.getElementById('sidebar').classList.toggle('open')">☰</button>
                <h1>@yield('page-title', 'Dashboard')</h1>
            </div>
            <div class="topbar-right">
                <div class="status-online">System Online</div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        @yield('content')
    </main>
</body>
</html>