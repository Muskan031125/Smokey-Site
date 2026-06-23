<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'CRM') ?> — CRM Manager</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    /* ═══════════════════════════════════════════════
       DARK THEME
    ═══════════════════════════════════════════════ */
    :root, [data-theme="dark"] {
        --bg:             #09090b;
        --surface:        #111113;
        --surface2:       #1c1c1f;
        --surface3:       #27272a;
        --border:         #3f3f46;
        --border-soft:    #2c2c30;

        --accent:         #a78bfa;
        --accent2:        #c4b5fd;
        --accent-hover:   #8b5cf6;
        --accent-soft:    #a78bfa18;
        --accent-glow:    #a78bfa35;

        --text:           #e4e4e7;
        --text-strong:    #fafafa;
        --muted:          #71717a;
        --muted2:         #a1a1aa;

        --success:        #4ade80;
        --success-bg:     #14532d33;
        --success-border: #4ade8040;
        --danger:         #f87171;
        --danger-bg:      #7f1d1d33;
        --danger-border:  #f8717140;
        --warning:        #fbbf24;

        --sidebar-bg:     linear-gradient(160deg, #18181b 0%, #0f0f11 100%);
        --sidebar-border: #27272a;
        --sidebar-text:   #a1a1aa;
        --sidebar-active-bg:   rgba(167,139,250,.12);
        --sidebar-active-text: #c4b5fd;
        --sidebar-w:      262px;

        --shadow-sm:      0 1px 3px rgba(0,0,0,.6);
        --shadow-md:      0 4px 24px rgba(0,0,0,.6);
        --shadow-lg:      0 8px 48px rgba(0,0,0,.7);
        --card-gradient:  linear-gradient(145deg, #1c1c1f 0%, #111113 100%);
    }

    /* ═══════════════════════════════════════════════
       LIGHT THEME
    ═══════════════════════════════════════════════ */
    [data-theme="light"] {
        --bg:             #f8f9fc;
        --surface:        #ffffff;
        --surface2:       #f1f2f6;
        --surface3:       #e8eaf0;
        --border:         #e2e4ec;
        --border-soft:    #eceef5;

        --accent:         #7c3aed;
        --accent2:        #8b5cf6;
        --accent-hover:   #6d28d9;
        --accent-soft:    #7c3aed12;
        --accent-glow:    #7c3aed25;

        --text:           #374151;
        --text-strong:    #111827;
        --muted:          #6b7280;
        --muted2:         #9ca3af;

        --success:        #059669;
        --success-bg:     #d1fae5;
        --success-border: #6ee7b7;
        --danger:         #dc2626;
        --danger-bg:      #fee2e2;
        --danger-border:  #fca5a5;
        --warning:        #d97706;

        /* sidebar — deep rich violet */
        --sidebar-bg:     linear-gradient(160deg, #4c1d95 0%, #5b21b6 50%, #4338ca 100%);
        --sidebar-border: rgba(255,255,255,.1);
        --sidebar-text:   rgba(255,255,255,.65);
        --sidebar-active-bg:   rgba(255,255,255,.2);
        --sidebar-active-text: #ffffff;
        --sidebar-w:      262px;

        --shadow-sm:      0 1px 4px rgba(0,0,0,.08);
        --shadow-md:      0 4px 20px rgba(0,0,0,.1);
        --shadow-lg:      0 8px 40px rgba(0,0,0,.14);
        --card-gradient:  none;
    }

    /* ═══════════════════════════════════════════════
       BASE
    ═══════════════════════════════════════════════ */
    body {
        font-family: 'DM Sans', sans-serif;
        background: var(--bg);
        color: var(--text);
        min-height: 100vh;
        display: flex;
        font-size: 14px;
        line-height: 1.55;
        transition: background .25s, color .25s;
    }

    /* ═══════════════════════════════════════════════
       SIDEBAR
    ═══════════════════════════════════════════════ */
    .sidebar {
        width: var(--sidebar-w);
        min-height: 100vh;
        background: var(--sidebar-bg);
        border-right: 1px solid var(--sidebar-border);
        display: flex;
        flex-direction: column;
        position: fixed;
        top: 0; left: 0; bottom: 0;
        overflow-y: auto;
        z-index: 10;
    }

    .sidebar-brand {
        padding: 22px 20px 18px;
        border-bottom: 1px solid rgba(255,255,255,.08);
    }

    .sidebar-brand h1 {
        font-size: 16px;
        font-weight: 700;
        color: #fff;
        letter-spacing: -.2px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .brand-icon {
        width: 30px; height: 30px;
        background: rgba(255,255,255,.2);
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        flex-shrink: 0;
    }

    .sidebar-brand p {
        font-size: 11px;
        color: rgba(255,255,255,.45);
        margin-top: 3px;
        margin-left: 38px;
        letter-spacing: .3px;
    }

    .sidebar-section { padding: 18px 14px 6px; }

    .sidebar-section-label {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.4px;
        color: rgba(255,255,255,.3);
        padding: 0 8px;
        margin-bottom: 4px;
    }

    .sidebar-nav a {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 10px;
        border-radius: 8px;
        color: var(--sidebar-text);
        text-decoration: none;
        font-size: 13.5px;
        font-weight: 500;
        transition: all .15s;
        margin-bottom: 2px;
    }

    .sidebar-nav a:hover {
        background: rgba(255,255,255,.1);
        color: #fff;
    }

    .sidebar-nav a.active {
        background: var(--sidebar-active-bg);
        color: var(--sidebar-active-text);
        font-weight: 600;
        box-shadow: inset 3px 0 0 rgba(255,255,255,.6);
    }

    .sidebar-nav a .icon { font-size: 14px; opacity: .85; }
    .sidebar-nav a.active .icon { opacity: 1; }

    .sidebar-divider {
        border: none;
        border-top: 1px solid rgba(255,255,255,.07);
        margin: 8px 16px;
    }

    .sidebar-projects { padding: 0 14px 20px; flex: 1; }

    .sidebar-projects-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 8px;
        margin-bottom: 4px;
    }

    .sidebar-projects-label {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.4px;
        color: rgba(255,255,255,.3);
    }

    .sidebar-projects-add {
        font-size: 18px;
        color: rgba(255,255,255,.4);
        text-decoration: none;
        line-height: 1;
        transition: color .15s;
    }
    .sidebar-projects-add:hover { color: rgba(255,255,255,.9); }

    .sidebar-project-item {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 7px 10px;
        border-radius: 7px;
        color: rgba(255,255,255,.5);
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        transition: all .15s;
        margin-bottom: 1px;
    }
    .sidebar-project-item:hover { background: rgba(255,255,255,.09); color: rgba(255,255,255,.9); }
    .sidebar-project-item.active { background: rgba(255,255,255,.13); color: #fff; }

    .project-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }

    /* ═══════════════════════════════════════════════
       MAIN AREA
    ═══════════════════════════════════════════════ */
    .main {
        margin-left: var(--sidebar-w);
        flex: 1;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    .topbar {
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        padding: 13px 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: sticky;
        top: 0;
        z-index: 5;
        box-shadow: var(--shadow-sm);
    }

    [data-theme="dark"] .topbar { box-shadow: 0 1px 0 var(--border), 0 4px 24px rgba(0,0,0,.4); }

    .topbar h2 {
        font-size: 15px;
        font-weight: 600;
        color: var(--text-strong);
        letter-spacing: -.1px;
    }

    .topbar-actions { display: flex; align-items: center; gap: 10px; }

    .theme-btn {
        background: var(--surface2);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 6px 10px;
        cursor: pointer;
        font-size: 15px;
        line-height: 1;
        transition: all .15s;
        color: var(--muted2);
    }
    .theme-btn:hover { border-color: var(--accent); background: var(--accent-soft); }

    .page-content { padding: 28px; flex: 1; }

    /* ═══════════════════════════════════════════════
       ALERTS
    ═══════════════════════════════════════════════ */
    .alert {
        padding: 11px 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 13.5px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
        border: 1px solid transparent;
    }
    .alert-success { background: var(--success-bg); border-color: var(--success-border); color: var(--success); }
    .alert-error   { background: var(--danger-bg);  border-color: var(--danger-border);  color: var(--danger); }

    /* ═══════════════════════════════════════════════
       BUTTONS
    ═══════════════════════════════════════════════ */
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 15px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        font-size: 13.5px;
        font-weight: 600;
        text-decoration: none;
        transition: all .15s;
        font-family: inherit;
        letter-spacing: .1px;
        white-space: nowrap;
    }
    .btn-primary { background: var(--accent); color: #fff; box-shadow: 0 2px 8px var(--accent-glow); }
    .btn-primary:hover { background: var(--accent-hover); box-shadow: 0 4px 16px var(--accent-glow); transform: translateY(-1px); }
    .btn-secondary { background: var(--surface2); color: var(--text); border: 1px solid var(--border); }
    .btn-secondary:hover { background: var(--surface3); }
    .btn-danger { background: var(--danger-bg); color: var(--danger); border: 1px solid var(--danger-border); }
    .btn-danger:hover { filter: brightness(1.1); }
    .btn-sm { padding: 5px 12px; font-size: 12px; }
    .btn-ghost { background: transparent; color: var(--muted2); border: 1px solid var(--border); }
    .btn-ghost:hover { background: var(--surface2); color: var(--text); }

    /* ═══════════════════════════════════════════════
       CARDS
    ═══════════════════════════════════════════════ */
    .card {
        background: var(--surface);
        background-image: var(--card-gradient);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 20px;
        box-shadow: var(--shadow-sm);
        transition: background .25s, border-color .25s;
    }
    .card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }
    .card-title { font-size: 14.5px; font-weight: 600; color: var(--text-strong); }

    /* ═══════════════════════════════════════════════
       FORMS
    ═══════════════════════════════════════════════ */
    .form-group { margin-bottom: 18px; }
    .form-label {
        display: block;
        font-size: 11.5px;
        font-weight: 700;
        color: var(--muted);
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: .7px;
    }
    .form-control {
        width: 100%;
        background: var(--surface2);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 10px 12px;
        color: var(--text-strong);
        font-size: 14px;
        font-family: inherit;
        transition: border-color .15s, box-shadow .15s;
    }
    .form-control:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0 0 0 3px var(--accent-soft);
        background: var(--surface);
    }
    textarea.form-control { min-height: 90px; resize: vertical; }
    .form-error { font-size: 12px; color: var(--danger); margin-top: 4px; }

    /* ═══════════════════════════════════════════════
       TABLE
    ═══════════════════════════════════════════════ */
    .table-wrap {
        overflow-x: auto;
        border-radius: 10px;
        border: 1px solid var(--border);
    }
    table { width: 100%; border-collapse: collapse; }
    thead th {
        background: var(--surface2);
        padding: 10px 14px;
        text-align: left;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .9px;
        color: var(--muted);
        border-bottom: 1px solid var(--border);
        white-space: nowrap;
    }
    tbody td {
        padding: 12px 14px;
        font-size: 13.5px;
        border-bottom: 1px solid var(--border-soft);
        vertical-align: middle;
        color: var(--text);
    }
    tbody tr:last-child td { border-bottom: none; }
    tbody tr:hover td { background: var(--surface2); transition: background .1s; }

    /* ═══════════════════════════════════════════════
       BADGES
    ═══════════════════════════════════════════════ */
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 3px 9px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .4px;
        text-transform: uppercase;
    }
    .badge-active {
        background: var(--success-bg);
        color: var(--success);
        border: 1px solid var(--success-border);
    }
    .badge-inactive {
        background: var(--surface3);
        color: var(--muted2);
        border: 1px solid var(--border);
    }

    /* ═══════════════════════════════════════════════
       STAT CARDS  — colorful per theme
    ═══════════════════════════════════════════════ */
    .grid-3 { display: grid; grid-template-columns: repeat(3,1fr); gap: 16px; }
    .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }

    .stat-card {
        border-radius: 12px;
        padding: 20px 22px;
        border: 1px solid transparent;
        box-shadow: var(--shadow-md);
        position: relative;
        overflow: hidden;
    }

    /* Dark stat cards */
    [data-theme="dark"] .stat-card:nth-child(1) {
        background: linear-gradient(135deg, #2e1065 0%, #1c1c1f 100%);
        border-color: #5b21b6aa;
    }
    [data-theme="dark"] .stat-card:nth-child(2) {
        background: linear-gradient(135deg, #064e3b 0%, #1c1c1f 100%);
        border-color: #059669aa;
    }
    [data-theme="dark"] .stat-card:nth-child(3) {
        background: linear-gradient(135deg, #7f1d1d 0%, #1c1c1f 100%);
        border-color: #dc2626aa;
    }
    [data-theme="dark"] .stat-card:nth-child(4) {
        background: linear-gradient(135deg, #0c4a6e 0%, #1c1c1f 100%);
        border-color: #0891b2aa;
    }
    [data-theme="dark"] .stat-card:nth-child(1) .stat-value { color: #c4b5fd; }
    [data-theme="dark"] .stat-card:nth-child(2) .stat-value { color: #4ade80; }
    [data-theme="dark"] .stat-card:nth-child(3) .stat-value { color: #f87171; }
    [data-theme="dark"] .stat-card:nth-child(4) .stat-value { color: #38bdf8; }

    /* Light stat cards: vibrant solid gradients */
    [data-theme="light"] .stat-card:nth-child(1) {
        background: linear-gradient(135deg, #7c3aed 0%, #4f46e5 100%);
        border-color: transparent;
    }
    [data-theme="light"] .stat-card:nth-child(2) {
        background: linear-gradient(135deg, #0891b2 0%, #0d9488 100%);
        border-color: transparent;
    }
    [data-theme="light"] .stat-card:nth-child(3) {
        background: linear-gradient(135deg, #db2777 0%, #ea580c 100%);
        border-color: transparent;
    }
    [data-theme="light"] .stat-card:nth-child(4) {
        background: linear-gradient(135deg, #0891b2 0%, #0284c7 100%);
        border-color: transparent;
    }
    [data-theme="light"] .stat-card { color: #fff; }
    [data-theme="light"] .stat-card .stat-label { color: rgba(255,255,255,.8); }
    [data-theme="light"] .stat-card .stat-value { color: #fff; }

    .stat-card::before {
        content: '';
        position: absolute;
        top: -20px; right: -20px;
        width: 80px; height: 80px;
        border-radius: 50%;
        background: rgba(255,255,255,.05);
    }

    .stat-value { font-size: 32px; font-weight: 700; letter-spacing: -1.5px; line-height: 1; margin-bottom: 6px; }
    .stat-label { font-size: 11.5px; font-weight: 600; text-transform: uppercase; letter-spacing: .6px; opacity: .7; }

    /* ═══════════════════════════════════════════════
       PASSWORD / COPY
    ═══════════════════════════════════════════════ */
    .pw-wrap { position: relative; }
    .pw-wrap .form-control { padding-right: 40px; }
    .pw-toggle {
        position: absolute; right: 10px; top: 50%;
        transform: translateY(-50%);
        background: none; border: none;
        color: var(--muted2); cursor: pointer; font-size: 14px; padding: 2px;
    }

    .copy-btn {
        background: none; border: none;
        color: var(--muted); cursor: pointer;
        font-size: 12px; padding: 3px 6px;
        border-radius: 4px; transition: all .15s;
        font-family: inherit;
    }
    .copy-btn:hover { background: var(--accent-soft); color: var(--accent); }

    /* ═══════════════════════════════════════════════
       USER CHIP
    ═══════════════════════════════════════════════ */
    .user-chip {
        display: flex;
        align-items: center;
        gap: 8px;
        background: var(--surface2);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 4px 12px 4px 5px;
    }
    .user-avatar {
        width: 26px; height: 26px;
        background: linear-gradient(135deg, var(--accent) 0%, var(--accent2) 100%);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 11px; font-weight: 700; color: #fff;
        flex-shrink: 0;
    }
    .user-name { font-size: 13px; font-weight: 500; color: var(--text); }
    .logout-btn {
        color: var(--muted); text-decoration: none;
        font-size: 15px; margin-left: 2px;
        transition: color .15s; line-height: 1;
    }
    .logout-btn:hover { color: var(--danger); }

    /* ═══════════════════════════════════════════════
       SEARCH + PAGINATION
    ═══════════════════════════════════════════════ */
    .search-bar { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; flex-wrap: wrap; }

    .search-input {
        flex: 1; min-width: 200px; max-width: 360px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 9px 14px 9px 36px;
        color: var(--text-strong);
        font-size: 14px; font-family: inherit;
        transition: border-color .15s, box-shadow .15s;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%237b84a0' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='m21 21-4.35-4.35'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: 11px center;
    }
    .search-input:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px var(--accent-soft); }

    .pagination { display: flex; align-items: center; justify-content: center; gap: 5px; margin-top: 22px; flex-wrap: wrap; }
    .pagination a, .pagination span {
        display: inline-flex; align-items: center; justify-content: center;
        min-width: 34px; height: 34px; padding: 0 8px;
        border-radius: 7px; font-size: 13px; font-weight: 500;
        text-decoration: none; transition: all .15s;
        border: 1px solid var(--border);
        color: var(--muted2); background: var(--surface);
    }
    .pagination a:hover { background: var(--surface2); color: var(--text-strong); border-color: var(--accent); }
    .pagination .active { background: var(--accent); color: #fff; border-color: var(--accent); box-shadow: 0 2px 8px var(--accent-glow); }
    .pagination .disabled { opacity: .35; pointer-events: none; }

    /* ═══════════════════════════════════════════════
       COLOR SWATCH PICKER
    ═══════════════════════════════════════════════ */
    .color-picker-row { display: flex; gap: 8px; flex-wrap: wrap; }
    .color-swatch {
        width: 28px; height: 28px;
        border-radius: 50%;
        border: 2px solid transparent;
        cursor: pointer;
        transition: transform .15s, box-shadow .15s;
    }
    .color-swatch:hover { transform: scale(1.2); }
    .color-swatch.selected {
        transform: scale(1.18);
        box-shadow: 0 0 0 3px var(--bg), 0 0 0 5px currentColor;
    }

    /* ═══════════════════════════════════════════════
       EMPTY STATE
    ═══════════════════════════════════════════════ */
    .empty-state { text-align: center; padding: 52px 20px; color: var(--muted); }
    .empty-state .icon { font-size: 40px; margin-bottom: 14px; opacity: .6; }
    .empty-state p { font-size: 14px; margin-bottom: 18px; }

    /* ═══════════════════════════════════════════════
       MONO
    ═══════════════════════════════════════════════ */
    code, .mono { font-family: 'DM Mono', monospace; font-size: .92em; }

    @media (max-width: 768px) {
        .sidebar { transform: translateX(-100%); }
        .main { margin-left: 0; }
        .grid-2, .grid-3 { grid-template-columns: 1fr; }
    }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-brand">
        <h1>
            <span class="brand-icon">⚡</span>
            CRM Manager
        </h1>
        <p>Project &amp; Credentials Hub</p>
    </div>

    <div class="sidebar-section">
        <div class="sidebar-section-label">Menu</div>
        <nav class="sidebar-nav">
            <a href="<?= base_url('/') ?>" class="<?= uri_string() === '' ? 'active' : '' ?>">
                <span class="icon">🏠</span> Dashboard
            </a>
            <a href="<?= base_url('projects') ?>" class="<?= str_starts_with(uri_string(), 'projects') ? 'active' : '' ?>">
                <span class="icon">📁</span> All Projects
            </a>
            <a href="<?= base_url('servers') ?>" class="<?= str_starts_with(uri_string(), 'servers') ? 'active' : '' ?>">
                <span class="icon">🖥️</span> Servers
            </a>
        </nav>
    </div>

</aside>

<div class="main">
    <div class="topbar">
        <h2><?= esc($title ?? 'CRM Manager') ?></h2>
        <div class="topbar-actions">
            <a href="<?= base_url('projects/create') ?>" class="btn btn-primary btn-sm">+ New Project</a>
            <a href="<?= base_url('servers/create') ?>" class="btn btn-secondary btn-sm">+ Add Server</a>
            <?php if (!empty($addBtn) && empty($addBtn['href'])): ?>
                <button class="btn btn-primary btn-sm" onclick="toggleInlineForm()"><?= esc($addBtn['label']) ?></button>
            <?php endif; ?>
            <button class="theme-btn" id="themeToggle" onclick="toggleTheme()" title="Toggle theme">🌙</button>
            <div class="user-chip">
                <span class="user-avatar"><?= strtoupper(substr(session()->get('user_name') ?? 'U', 0, 1)) ?></span>
                <span class="user-name"><?= esc(session()->get('user_name') ?? '') ?></span>
                <a href="<?= base_url('logout') ?>" class="logout-btn" title="Logout">⏻</a>
            </div>
        </div>
    </div>

    <div class="page-content">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">✓ <?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-error">✗ <?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>
        <?= $content ?>
    </div>
</div>

<script>
const root = document.documentElement;
const btn  = document.getElementById('themeToggle');

function applyTheme(t) {
    root.setAttribute('data-theme', t);
    btn.textContent = t === 'dark' ? '☀️' : '🌙';
    localStorage.setItem('crm-theme', t);
}
function toggleTheme() {
    applyTheme(root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark');
}
(function() { applyTheme(localStorage.getItem('crm-theme') || 'dark'); })();

function copyText(text, btn) {
    navigator.clipboard.writeText(text).then(() => {
        const o = btn.textContent; btn.textContent = '✓';
        setTimeout(() => btn.textContent = o, 1500);
    });
}
function togglePw(id, b) {
    const i = document.getElementById(id);
    i.type = i.type === 'password' ? 'text' : 'password';
    b.textContent = i.type === 'password' ? '👁' : '🙈';
}
function selectColor(hex, el) {
    document.getElementById('colorInput').value = hex;
    document.querySelectorAll('.color-swatch').forEach(s => s.classList.remove('selected'));
    el.classList.add('selected');
}
function confirmDelete(form) {
    if (confirm('Delete permanently? This cannot be undone.')) form.submit();
}

function toggleInlineForm() {
    const f = document.getElementById('inlineForm');
    if (!f) return;
    const open = f.style.display !== 'none' && f.style.display !== '';
    f.style.display = open ? 'none' : 'block';
    if (!open) f.scrollIntoView({ behavior: 'smooth', block: 'start' });
}
</script>
</body>
</html>
