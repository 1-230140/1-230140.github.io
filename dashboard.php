<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$user_email = $_SESSION['user_email'];
$user_initial = strtoupper(substr($user_email, 0, 2));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard — Nexus</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <style>
    :root {
      --ink: #0d0d0f;
      --surface: #141418;
      --panel: #1c1c22;
      --panel2: #222229;
      --border: #2a2a34;
      --muted: #6b6b7e;
      --text: #e8e8f0;
      --accent: #c8a96e;
      --accent-glow: rgba(200,169,110,0.15);
      --green: #5cb85c;
      --red: #e05c5c;
      --blue: #5c8be0;
      --sidebar-w: 240px;
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      min-height: 100vh;
      background: var(--ink);
      font-family: 'DM Sans', sans-serif;
      color: var(--text);
      display: flex;
      animation: fadeIn 0.4s ease;
    }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    .sidebar {
      width: var(--sidebar-w);
      min-height: 100vh;
      background: var(--surface);
      border-right: 1px solid var(--border);
      display: flex; flex-direction: column;
      padding: 1.75rem 1.25rem;
      position: fixed; top: 0; left: 0; bottom: 0;
      z-index: 100;
    }
    .brand { display: flex; align-items: center; gap: 0.6rem; margin-bottom: 2.5rem; }
    .brand-mark {
      width: 32px; height: 32px; min-width: 32px;
      border: 2px solid var(--accent);
      display: flex; align-items: center; justify-content: center;
      font-family: 'Playfair Display', serif;
      font-size: 0.9rem; color: var(--accent);
    }
    .brand-name { font-family: 'Playfair Display', serif; font-size: 1.1rem; color: var(--text); letter-spacing: 0.1em; }
    .nav-section-label { font-size: 0.65rem; letter-spacing: 0.15em; text-transform: uppercase; color: var(--muted); margin-bottom: 0.5rem; padding-left: 0.5rem; }
    .nav-item {
      display: flex; align-items: center; gap: 0.75rem;
      padding: 0.65rem 0.75rem; border-radius: 2px;
      font-size: 0.88rem; color: var(--muted);
      cursor: pointer; text-decoration: none;
      transition: background 0.15s, color 0.15s;
      margin-bottom: 0.1rem;
    }
    .nav-item:hover { background: var(--panel); color: var(--text); }
    .nav-item.active { background: var(--accent-glow); color: var(--accent); }
    .nav-item svg { opacity: 0.7; flex-shrink: 0; }
    .nav-item.active svg { opacity: 1; }
    .nav-badge { margin-left: auto; background: var(--accent); color: #0d0d0f; font-size: 0.65rem; font-weight: 700; padding: 1px 6px; border-radius: 10px; }
    .sidebar-spacer { flex: 1; }
    .sidebar-user {
      display: flex; align-items: center; gap: 0.75rem;
      padding: 0.75rem; border: 1px solid var(--border); border-radius: 2px;
      cursor: pointer; transition: background 0.15s;
    }
    .sidebar-user:hover { background: var(--panel); }
    .avatar {
      width: 34px; height: 34px; border-radius: 50%;
      background: var(--accent-glow); border: 1px solid var(--accent);
      display: flex; align-items: center; justify-content: center;
      font-size: 0.8rem; font-weight: 600; color: var(--accent); flex-shrink: 0;
    }
    .user-name { font-size: 0.85rem; color: var(--text); font-weight: 500; }
    .user-role { font-size: 0.72rem; color: var(--muted); }
    .main { margin-left: var(--sidebar-w); flex: 1; padding: 2rem 2.5rem; overflow-x: hidden; }
    .topbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem; }
    .page-title { font-family: 'Playfair Display', serif; font-size: 1.6rem; font-weight: 600; color: var(--text); }
    .page-sub { font-size: 0.83rem; color: var(--muted); margin-top: 0.15rem; }
    .topbar-actions { display: flex; align-items: center; gap: 0.75rem; }
    .btn-icon {
      width: 36px; height: 36px; background: var(--panel); border: 1px solid var(--border);
      border-radius: 2px; display: flex; align-items: center; justify-content: center;
      cursor: pointer; color: var(--muted); transition: border-color 0.15s, color 0.15s; position: relative;
    }
    .btn-icon:hover { border-color: var(--muted); color: var(--text); }
    .notif-dot { position: absolute; top: 7px; right: 7px; width: 6px; height: 6px; background: var(--accent); border-radius: 50%; }
    .btn-primary-sm {
      background: var(--accent); color: #0d0d0f; border: none; border-radius: 2px;
      font-family: 'DM Sans', sans-serif; font-size: 0.8rem; font-weight: 600;
      letter-spacing: 0.08em; text-transform: uppercase; padding: 0.5rem 1.1rem; cursor: pointer; transition: opacity 0.2s;
    }
    .btn-primary-sm:hover { opacity: 0.85; }
    .kpi-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.75rem; }
    .kpi-card { background: var(--panel); border: 1px solid var(--border); border-radius: 2px; padding: 1.25rem 1.5rem; position: relative; overflow: hidden; }
    .kpi-card::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 2px; }
    .kpi-card.accent::after { background: var(--accent); }
    .kpi-card.green::after { background: var(--green); }
    .kpi-card.blue::after { background: var(--blue); }
    .kpi-card.red::after { background: var(--red); }
    .kpi-label { font-size: 0.72rem; letter-spacing: 0.1em; text-transform: uppercase; color: var(--muted); margin-bottom: 0.6rem; }
    .kpi-value { font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 700; color: var(--text); line-height: 1; }
    .kpi-change { font-size: 0.78rem; margin-top: 0.5rem; display: flex; align-items: center; gap: 0.3rem; }
    .kpi-change.up { color: var(--green); }
    .kpi-change.down { color: var(--red); }
    .content-row { display: grid; grid-template-columns: 2fr 1fr; gap: 1rem; margin-bottom: 1rem; }
    .card { background: var(--panel); border: 1px solid var(--border); border-radius: 2px; padding: 1.5rem; }
    .card-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem; }
    .card-title { font-size: 0.9rem; font-weight: 600; color: var(--text); letter-spacing: 0.02em; }
    .card-action { font-size: 0.76rem; color: var(--accent); cursor: pointer; text-decoration: none; }
    .bar-chart { display: flex; align-items: flex-end; gap: 8px; height: 140px; padding-top: 10px; }
    .bar-col { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 6px; }
    .bar { width: 100%; border-radius: 2px 2px 0 0; background: var(--border); transition: background 0.3s; position: relative; }
    .bar.accent-bar { background: var(--accent); opacity: 0.85; }
    .bar.active { background: var(--accent); opacity: 1; }
    .bar-label { font-size: 0.65rem; color: var(--muted); }
    .donut-wrap { display: flex; align-items: center; justify-content: center; margin: 0.5rem 0 1rem; }
    svg.donut { transform: rotate(-90deg); }
    .legend-item { display: flex; align-items: center; gap: 0.5rem; font-size: 0.8rem; color: var(--muted); margin-bottom: 0.5rem; }
    .legend-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
    .legend-val { margin-left: auto; font-weight: 500; color: var(--text); }
    .activity-table { width: 100%; border-collapse: collapse; }
    .activity-table th { font-size: 0.68rem; letter-spacing: 0.1em; text-transform: uppercase; color: var(--muted); padding: 0 0 0.75rem; font-weight: 500; border-bottom: 1px solid var(--border); }
    .activity-table th:last-child, .activity-table td:last-child { text-align: right; }
    .activity-table td { padding: 0.85rem 0; font-size: 0.85rem; color: var(--text); border-bottom: 1px solid var(--border); vertical-align: middle; }
    .activity-table tr:last-child td { border-bottom: none; }
    .badge-status { display: inline-flex; align-items: center; gap: 4px; font-size: 0.72rem; font-weight: 500; letter-spacing: 0.04em; padding: 3px 8px; border-radius: 2px; }
    .badge-status.done { background: rgba(92,184,92,0.12); color: var(--green); }
    .badge-status.progress { background: rgba(200,169,110,0.12); color: var(--accent); }
    .badge-status.review { background: rgba(92,139,224,0.12); color: var(--blue); }
    .badge-status.pending { background: rgba(107,107,126,0.12); color: var(--muted); }
    .user-cell { display: flex; align-items: center; gap: 0.6rem; }
    .mini-avatar { width: 26px; height: 26px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.65rem; font-weight: 600; flex-shrink: 0; }
    .task-item { display: flex; align-items: flex-start; gap: 0.75rem; padding: 0.85rem 0; border-bottom: 1px solid var(--border); }
    .task-item:last-child { border-bottom: none; }
    .task-check { width: 16px; height: 16px; min-width: 16px; border: 1px solid var(--border); border-radius: 2px; margin-top: 2px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background 0.2s, border-color 0.2s; }
    .task-check:hover { border-color: var(--accent); }
    .task-check.checked { background: var(--accent); border-color: var(--accent); }
    .task-text { font-size: 0.85rem; color: var(--text); line-height: 1.4; }
    .task-meta { font-size: 0.72rem; color: var(--muted); margin-top: 0.15rem; }
    .task-priority { margin-left: auto; font-size: 0.7rem; padding: 2px 6px; border-radius: 2px; }
    .high { background: rgba(224,92,92,0.12); color: var(--red); }
    .med { background: rgba(200,169,110,0.12); color: var(--accent); }
    .low { background: rgba(92,184,92,0.12); color: var(--green); }
    @media (max-width: 1100px) { .kpi-grid { grid-template-columns: repeat(2, 1fr); } .content-row { grid-template-columns: 1fr; } }
    @media (max-width: 768px) { .sidebar { display: none; } .main { margin-left: 0; padding: 1.25rem; } .kpi-grid { grid-template-columns: 1fr 1fr; } }
  </style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
  <div class="brand">
    <div class="brand-mark">N</div>
    <div class="brand-name">Nexus</div>
  </div>

  <div class="mb-3">
    <div class="nav-section-label">Main</div>
    <a class="nav-item active" href="#">
      <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
      Overview
    </a>
    <a class="nav-item" href="#">
      <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
      Tasks
      <span class="nav-badge">8</span>
    </a>
    <a class="nav-item" href="#">
      <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
      Projects
    </a>
    <a class="nav-item" href="#">
      <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
      Team
    </a>
  </div>

  <div class="mb-3">
    <div class="nav-section-label">Analytics</div>
    <a class="nav-item" href="#">
      <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
      Reports
    </a>
    <a class="nav-item" href="#">
      <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="2" x2="12" y2="22"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
      Revenue
    </a>
  </div>

  <div>
    <div class="nav-section-label">Settings</div>
    <a class="nav-item" href="#">
      <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
      Settings
    </a>

    <!-- LOGOUT -->
    <a class="nav-item" href="logout.php">
      <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/>
        <polyline points="16 17 21 12 16 7"/>
        <line x1="21" y1="12" x2="9" y2="12"/>
      </svg>
      Logout
    </a>
  </div>

  <div class="sidebar-spacer"></div>

  <!-- SIDEBAR USER — shows logged in email -->
  <div class="sidebar-user">
    <div class="avatar"><?= htmlspecialchars($user_initial) ?></div>
    <div>
      <div class="user-name"><?= htmlspecialchars($user_email) ?></div>
      <div class="user-role">Member</div>
    </div>
  </div>
</aside>

<!-- MAIN -->
<main class="main">

  <!-- TOPBAR -->
  <div class="topbar">
    <div>
      <!-- GREETING — shows logged in email -->
      <div class="page-title">Good morning, <?= htmlspecialchars($user_email) ?>.</div>
      <div class="page-sub">Wednesday, March 18 · Here's what's happening today.</div>
    </div>
    <div class="topbar-actions">
      <div class="btn-icon">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0"/></svg>
        <div class="notif-dot"></div>
      </div>
      <div class="btn-icon">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      </div>
      <button class="btn-primary-sm">+ New Task</button>
    </div>
  </div>

  <!-- KPI CARDS -->
  <div class="kpi-grid">
    <div class="kpi-card accent">
      <div class="kpi-label">Total Revenue</div>
      <div class="kpi-value">$84.2K</div>
      <div class="kpi-change up">
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"/></svg>
        +12.4% from last month
      </div>
    </div>
    <div class="kpi-card green">
      <div class="kpi-label">Active Projects</div>
      <div class="kpi-value">24</div>
      <div class="kpi-change up">
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"/></svg>
        +3 this week
      </div>
    </div>
    <div class="kpi-card blue">
      <div class="kpi-label">Team Members</div>
      <div class="kpi-value">38</div>
      <div class="kpi-change up">
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"/></svg>
        2 joined recently
      </div>
    </div>
    <div class="kpi-card red">
      <div class="kpi-label">Pending Tasks</div>
      <div class="kpi-value">17</div>
      <div class="kpi-change down">
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
        5 overdue
      </div>
    </div>
  </div>

  <!-- ROW 1 -->
  <div class="content-row">
    <div class="card">
      <div class="card-header">
        <div class="card-title">Monthly Revenue</div>
        <a class="card-action" href="#">View report →</a>
      </div>
      <div class="bar-chart" id="barChart"></div>
      <div style="display:flex;justify-content:space-between;margin-top:0.5rem;">
        <span style="font-size:0.7rem;color:var(--muted)">Total YTD: <strong style="color:var(--text)">$84,210</strong></span>
        <span style="font-size:0.7rem;color:var(--green)">↑ 12.4% vs last year</span>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
        <div class="card-title">Project Status</div>
      </div>
      <div class="donut-wrap">
        <svg class="donut" width="110" height="110" viewBox="0 0 110 110">
          <circle cx="55" cy="55" r="42" fill="none" stroke="var(--border)" stroke-width="12"/>
          <circle cx="55" cy="55" r="42" fill="none" stroke="#5cb85c" stroke-width="12" stroke-dasharray="131.9 263.9" stroke-dashoffset="0"/>
          <circle cx="55" cy="55" r="42" fill="none" stroke="#c8a96e" stroke-width="12" stroke-dasharray="76.5 263.9" stroke-dashoffset="-131.9"/>
          <circle cx="55" cy="55" r="42" fill="none" stroke="#5c8be0" stroke-width="12" stroke-dasharray="34.3 263.9" stroke-dashoffset="-208.4"/>
          <circle cx="55" cy="55" r="42" fill="none" stroke="#6b6b7e" stroke-width="12" stroke-dasharray="21.1 263.9" stroke-dashoffset="-242.7"/>
        </svg>
      </div>
      <div>
        <div class="legend-item"><div class="legend-dot" style="background:var(--green)"></div> Completed <span class="legend-val">50%</span></div>
        <div class="legend-item"><div class="legend-dot" style="background:var(--accent)"></div> In Progress <span class="legend-val">29%</span></div>
        <div class="legend-item"><div class="legend-dot" style="background:var(--blue)"></div> In Review <span class="legend-val">13%</span></div>
        <div class="legend-item"><div class="legend-dot" style="background:var(--muted)"></div> Pending <span class="legend-val">8%</span></div>
      </div>
    </div>
  </div>

  <!-- ROW 2 -->
  <div class="content-row">
    <div class="card">
      <div class="card-header">
        <div class="card-title">Recent Tasks</div>
        <a class="card-action" href="#">All tasks →</a>
      </div>
      <table class="activity-table">
        <thead>
          <tr><th>Task</th><th>Assignee</th><th>Due</th><th>Status</th></tr>
        </thead>
        <tbody>
          <tr>
            <td>Redesign onboarding flow</td>
            <td><div class="user-cell"><div class="mini-avatar" style="background:rgba(200,169,110,0.15);color:var(--accent)">SR</div>Sofia R.</div></td>
            <td style="color:var(--muted);font-size:0.8rem;">Mar 20</td>
            <td><span class="badge-status progress">In Progress</span></td>
          </tr>
          <tr>
            <td>API rate limit documentation</td>
            <td><div class="user-cell"><div class="mini-avatar" style="background:rgba(92,139,224,0.15);color:var(--blue)">MK</div>Marco K.</div></td>
            <td style="color:var(--muted);font-size:0.8rem;">Mar 19</td>
            <td><span class="badge-status review">In Review</span></td>
          </tr>
          <tr>
            <td>Q1 financial report</td>
            <td><div class="user-cell"><div class="mini-avatar" style="background:rgba(92,184,92,0.15);color:var(--green)">AL</div>Ana L.</div></td>
            <td style="color:var(--muted);font-size:0.8rem;">Mar 15</td>
            <td><span class="badge-status done">Completed</span></td>
          </tr>
          <tr>
            <td>Migrate database to v3</td>
            <td><div class="user-cell"><div class="mini-avatar" style="background:rgba(107,107,126,0.2);color:var(--muted)">TH</div>Tom H.</div></td>
            <td style="color:var(--red);font-size:0.8rem;">Mar 17 ⚠</td>
            <td><span class="badge-status pending">Pending</span></td>
          </tr>
          <tr>
            <td>Launch new landing page</td>
            <td><div class="user-cell"><div class="mini-avatar" style="background:rgba(200,169,110,0.15);color:var(--accent)">JD</div>Jane D.</div></td>
            <td style="color:var(--muted);font-size:0.8rem;">Mar 25</td>
            <td><span class="badge-status progress">In Progress</span></td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="card">
      <div class="card-header">
        <div class="card-title">My Tasks Today</div>
        <a class="card-action" href="#">Add task →</a>
      </div>
      <div id="taskList">
        <div class="task-item">
          <div class="task-check checked" onclick="toggleCheck(this)"><svg width="10" height="10" fill="none" stroke="#0d0d0f" stroke-width="3" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div>
          <div><div class="task-text" style="text-decoration:line-through;opacity:0.5">Morning standup call</div><div class="task-meta">9:00 AM · Team</div></div>
          <span class="task-priority low">Low</span>
        </div>
        <div class="task-item">
          <div class="task-check" onclick="toggleCheck(this)"></div>
          <div><div class="task-text">Review onboarding mockups</div><div class="task-meta">Before noon · Design</div></div>
          <span class="task-priority high">High</span>
        </div>
        <div class="task-item">
          <div class="task-check" onclick="toggleCheck(this)"></div>
          <div><div class="task-text">Send weekly update email</div><div class="task-meta">2:00 PM · Comms</div></div>
          <span class="task-priority med">Med</span>
        </div>
        <div class="task-item">
          <div class="task-check" onclick="toggleCheck(this)"></div>
          <div><div class="task-text">Review DB migration PR</div><div class="task-meta">EOD · Engineering</div></div>
          <span class="task-priority high">High</span>
        </div>
        <div class="task-item">
          <div class="task-check" onclick="toggleCheck(this)"></div>
          <div><div class="task-text">Approve Q1 expense reports</div><div class="task-meta">EOD · Finance</div></div>
          <span class="task-priority med">Med</span>
        </div>
      </div>
    </div>
  </div>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const months = ['Jul','Aug','Sep','Oct','Nov','Dec','Jan','Feb','Mar'];
  const values = [42, 58, 51, 67, 55, 72, 63, 78, 84];
  const max = Math.max(...values);
  const chart = document.getElementById('barChart');
  months.forEach((m, i) => {
    const pct = Math.round((values[i] / max) * 120);
    const isActive = i === months.length - 1;
    chart.innerHTML += `<div class="bar-col"><div class="bar ${isActive ? 'active' : 'accent-bar'}" style="height:${pct}px" title="$${values[i]}K"></div><div class="bar-label">${m}</div></div>`;
  });

  function toggleCheck(el) {
    const isChecked = el.classList.toggle('checked');
    const textEl = el.parentElement.querySelector('.task-text');
    textEl.style.textDecoration = isChecked ? 'line-through' : 'none';
    textEl.style.opacity = isChecked ? '0.5' : '1';
    el.innerHTML = isChecked ? '<svg width="10" height="10" fill="none" stroke="#0d0d0f" stroke-width="3" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>' : '';
  }
</script>
</body>
</html>