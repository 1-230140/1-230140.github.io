<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login — Nexus</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet"/>
  <style>
    :root {
      --ink: #0d0d0f;
      --surface: #141418;
      --panel: #1c1c22;
      --border: #2a2a34;
      --muted: #6b6b7e;
      --text: #e8e8f0;
      --accent: #c8a96e;
      --accent-glow: rgba(200,169,110,0.15);
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      min-height: 100vh;
      background: var(--ink);
      font-family: 'DM Sans', sans-serif;
      color: var(--text);
      display: flex;
      align-items: stretch;
    }

    /* LEFT PANEL */
    .left-panel {
      width: 45%;
      background: var(--surface);
      border-right: 1px solid var(--border);
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 3rem;
      position: relative;
      overflow: hidden;
    }
    .left-panel::before {
      content: '';
      position: absolute;
      top: -120px; left: -120px;
      width: 400px; height: 400px;
      background: radial-gradient(circle, rgba(200,169,110,0.08) 0%, transparent 70%);
      pointer-events: none;
    }
    .left-panel::after {
      content: '';
      position: absolute;
      bottom: -80px; right: -80px;
      width: 300px; height: 300px;
      background: radial-gradient(circle, rgba(200,169,110,0.05) 0%, transparent 70%);
      pointer-events: none;
    }
    .brand {
      display: flex;
      align-items: center;
      gap: 0.6rem;
    }
    .brand-mark {
      width: 36px; height: 36px;
      border: 2px solid var(--accent);
      display: flex; align-items: center; justify-content: center;
      font-family: 'Playfair Display', serif;
      font-size: 1rem;
      color: var(--accent);
      letter-spacing: 0.05em;
    }
    .brand-name {
      font-family: 'Playfair Display', serif;
      font-size: 1.2rem;
      color: var(--text);
      letter-spacing: 0.1em;
    }
    .panel-headline {
      font-family: 'Playfair Display', serif;
      font-size: 2.8rem;
      line-height: 1.15;
      color: var(--text);
      font-weight: 700;
    }
    .panel-headline span {
      color: var(--accent);
    }
    .panel-sub {
      margin-top: 1rem;
      font-size: 0.95rem;
      color: var(--muted);
      font-weight: 300;
      line-height: 1.7;
    }
    .testimonial {
      background: var(--panel);
      border: 1px solid var(--border);
      border-left: 3px solid var(--accent);
      padding: 1.25rem 1.5rem;
      border-radius: 2px;
    }
    .testimonial p {
      font-size: 0.88rem;
      color: var(--muted);
      font-style: italic;
      line-height: 1.6;
    }
    .testimonial-author {
      margin-top: 0.75rem;
      font-size: 0.8rem;
      color: var(--accent);
      letter-spacing: 0.08em;
      text-transform: uppercase;
      font-weight: 500;
    }

    /* RIGHT PANEL */
    .right-panel {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 3rem 4rem;
      background: var(--ink);
    }
    .login-card {
      width: 100%;
      max-width: 420px;
    }
    .login-title {
      font-family: 'Playfair Display', serif;
      font-size: 2rem;
      font-weight: 600;
      color: var(--text);
      margin-bottom: 0.4rem;
    }
    .login-sub {
      font-size: 0.88rem;
      color: var(--muted);
      margin-bottom: 2.5rem;
    }
    .login-sub a {
      color: var(--accent);
      text-decoration: none;
    }
    .form-label {
      font-size: 0.78rem;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: var(--muted);
      font-weight: 500;
      margin-bottom: 0.5rem;
    }
    .form-control {
      background: var(--panel);
      border: 1px solid var(--border);
      border-radius: 2px;
      color: var(--text);
      font-family: 'DM Sans', sans-serif;
      font-size: 0.93rem;
      padding: 0.75rem 1rem;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-control::placeholder { color: var(--muted); opacity: 0.6; }
    .form-control:focus {
      background: var(--panel);
      border-color: var(--accent);
      box-shadow: 0 0 0 3px var(--accent-glow);
      color: var(--text);
      outline: none;
    }
    .form-row { margin-bottom: 1.25rem; }
    .forgot-link {
      font-size: 0.8rem;
      color: var(--muted);
      text-decoration: none;
      transition: color 0.2s;
    }
    .forgot-link:hover { color: var(--accent); }
    .btn-login {
      width: 100%;
      background: var(--accent);
      color: #0d0d0f;
      font-family: 'DM Sans', sans-serif;
      font-weight: 600;
      font-size: 0.88rem;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      border: none;
      border-radius: 2px;
      padding: 0.85rem;
      margin-top: 1.5rem;
      cursor: pointer;
      transition: opacity 0.2s, transform 0.15s;
    }
    .btn-login:hover { opacity: 0.88; transform: translateY(-1px); }
    .divider {
      display: flex; align-items: center; gap: 1rem;
      margin: 1.5rem 0;
    }
    .divider::before, .divider::after {
      content: ''; flex: 1;
      height: 1px; background: var(--border);
    }
    .divider span {
      font-size: 0.75rem; color: var(--muted); letter-spacing: 0.05em;
    }
    .btn-google {
      width: 100%;
      background: transparent;
      border: 1px solid var(--border);
      border-radius: 2px;
      color: var(--text);
      font-family: 'DM Sans', sans-serif;
      font-size: 0.88rem;
      padding: 0.75rem;
      cursor: pointer;
      display: flex; align-items: center; justify-content: center; gap: 0.6rem;
      transition: border-color 0.2s, background 0.2s;
    }
    .btn-google:hover { border-color: var(--muted); background: var(--panel); }

    @media (max-width: 768px) {
      .left-panel { display: none; }
      .right-panel { padding: 2rem 1.5rem; }
    }

    /* Page fade-in */
    body { animation: fadeIn 0.5s ease; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: none; } }
  </style>
</head>
<body>

  <!-- LEFT -->
  <div class="left-panel">
    <div class="brand">
      <div class="brand-mark">N</div>
      <div class="brand-name">Nexus</div>
    </div>

    <div>
      <div class="panel-headline">
        Your workspace,<br/><span>elevated.</span>
      </div>
      <p class="panel-sub">
        Manage projects, collaborate with your team, and track performance — all from one unified platform built for modern professionals.
      </p>
    </div>

    <div class="testimonial">
      <p>"Nexus completely transformed how our team operates. The clarity it brings to every workflow is unmatched."</p>
      <div class="testimonial-author">— Sofia Reyes, Head of Product at Lumio</div>
    </div>
  </div>

  <!-- RIGHT -->
  <div class="right-panel">
    <div class="login-card">
      <div class="login-title">Welcome back</div>
      <div class="login-sub">Don't have an account? <a href="signup.html">Create one</a></div>

      <div class="form-row">
        <label class="form-label">Email Address</label>
        <input type="email" class="form-control" placeholder="you@example.com" />
      </div>

      <div class="form-row">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <label class="form-label mb-0">Password</label>
          <a href="#" class="forgot-link">Forgot password?</a>
        </div>
        <input type="password" class="form-control" placeholder="••••••••" />
      </div>

      <div class="d-flex align-items-center gap-2 mt-1">
        <input type="checkbox" id="remember" class="form-check-input" style="background:#1c1c22;border-color:#2a2a34;border-radius:2px;" />
        <label for="remember" style="font-size:0.82rem;color:var(--muted);cursor:pointer;">Remember me for 30 days</label>
      </div>

      <button class="btn-login" onclick="window.location.href='dashboard.html'">Sign In</button>

      <div class="divider"><span>or continue with</span></div>

      <button class="btn-google">
        <svg width="16" height="16" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
        Continue with Google
      </button>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>