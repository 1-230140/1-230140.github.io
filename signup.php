<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sign Up — Nexus</title>
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
      --error: #e05c5c;
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      min-height: 100vh;
      background: var(--ink);
      font-family: 'DM Sans', sans-serif;
      color: var(--text);
      display: flex;
      align-items: stretch;
      animation: fadeIn 0.5s ease;
    }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: none; } }

    /* LEFT */
    .left-panel {
      width: 40%;
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
      top: 60%; left: 50%;
      transform: translate(-50%, -50%);
      width: 500px; height: 500px;
      background: radial-gradient(circle, rgba(200,169,110,0.06) 0%, transparent 65%);
      pointer-events: none;
    }
    .brand {
      display: flex; align-items: center; gap: 0.6rem;
    }
    .brand-mark {
      width: 36px; height: 36px;
      border: 2px solid var(--accent);
      display: flex; align-items: center; justify-content: center;
      font-family: 'Playfair Display', serif;
      font-size: 1rem; color: var(--accent);
    }
    .brand-name {
      font-family: 'Playfair Display', serif;
      font-size: 1.2rem; color: var(--text); letter-spacing: 0.1em;
    }
    .steps-list { list-style: none; }
    .steps-list li {
      display: flex; align-items: flex-start; gap: 1rem;
      padding: 1.1rem 0;
      border-bottom: 1px solid var(--border);
    }
    .steps-list li:last-child { border-bottom: none; }
    .step-num {
      width: 28px; height: 28px; min-width: 28px;
      border: 1px solid var(--accent);
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-size: 0.72rem; color: var(--accent); font-weight: 600;
      margin-top: 2px;
    }
    .step-title {
      font-size: 0.9rem; font-weight: 500; color: var(--text);
    }
    .step-desc {
      font-size: 0.8rem; color: var(--muted); margin-top: 0.2rem; line-height: 1.5;
    }
    .panel-footer {
      font-size: 0.78rem; color: var(--muted); line-height: 1.6;
    }
    .panel-footer strong { color: var(--accent); font-weight: 500; }

    /* RIGHT */
    .right-panel {
      flex: 1;
      display: flex; align-items: center; justify-content: center;
      padding: 3rem 4rem;
      background: var(--ink);
      overflow-y: auto;
    }
    .signup-card {
      width: 100%; max-width: 460px;
      padding: 2.5rem 0;
    }
    .signup-title {
      font-family: 'Playfair Display', serif;
      font-size: 2rem; font-weight: 600; color: var(--text);
      margin-bottom: 0.4rem;
    }
    .signup-sub {
      font-size: 0.88rem; color: var(--muted); margin-bottom: 2rem;
    }
    .signup-sub a { color: var(--accent); text-decoration: none; }

    .form-label {
      font-size: 0.75rem;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: var(--muted);
      font-weight: 500;
      margin-bottom: 0.5rem;
      display: block;
    }
    .form-control {
      background: var(--panel);
      border: 1px solid var(--border);
      border-radius: 2px;
      color: var(--text);
      font-family: 'DM Sans', sans-serif;
      font-size: 0.93rem;
      padding: 0.75rem 1rem;
      width: 100%;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-control::placeholder { color: var(--muted); opacity: 0.5; }
    .form-control:focus {
      background: var(--panel);
      border-color: var(--accent);
      box-shadow: 0 0 0 3px var(--accent-glow);
      color: var(--text);
      outline: none;
    }
    .form-row { margin-bottom: 1.2rem; }
    .name-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }

    .password-hint {
      font-size: 0.75rem; color: var(--muted); margin-top: 0.4rem;
    }

    /* Strength bar */
    .strength-bar {
      display: flex; gap: 4px; margin-top: 0.5rem;
    }
    .strength-seg {
      height: 3px; flex: 1; background: var(--border); border-radius: 2px;
      transition: background 0.3s;
    }

    .terms-row {
      display: flex; align-items: flex-start; gap: 0.75rem;
      margin: 1.25rem 0;
    }
    .form-check-input {
      background: var(--panel); border-color: var(--border);
      border-radius: 2px; margin-top: 3px; cursor: pointer;
      flex-shrink: 0;
    }
    .terms-text {
      font-size: 0.82rem; color: var(--muted); line-height: 1.5;
    }
    .terms-text a { color: var(--accent); text-decoration: none; }

    .btn-signup {
      width: 100%;
      background: var(--accent);
      color: #0d0d0f;
      font-family: 'DM Sans', sans-serif;
      font-weight: 600; font-size: 0.88rem;
      letter-spacing: 0.12em; text-transform: uppercase;
      border: none; border-radius: 2px;
      padding: 0.85rem;
      cursor: pointer;
      transition: opacity 0.2s, transform 0.15s;
    }
    .btn-signup:hover { opacity: 0.88; transform: translateY(-1px); }

    .divider {
      display: flex; align-items: center; gap: 1rem; margin: 1.5rem 0;
    }
    .divider::before, .divider::after {
      content: ''; flex: 1; height: 1px; background: var(--border);
    }
    .divider span { font-size: 0.75rem; color: var(--muted); letter-spacing: 0.05em; }

    .btn-google {
      width: 100%;
      background: transparent; border: 1px solid var(--border);
      border-radius: 2px; color: var(--text);
      font-family: 'DM Sans', sans-serif; font-size: 0.88rem;
      padding: 0.75rem; cursor: pointer;
      display: flex; align-items: center; justify-content: center; gap: 0.6rem;
      transition: border-color 0.2s, background 0.2s;
    }
    .btn-google:hover { border-color: var(--muted); background: var(--panel); }

    @media (max-width: 768px) {
      .left-panel { display: none; }
      .right-panel { padding: 2rem 1.5rem; }
      .name-row { grid-template-columns: 1fr; }
    }
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
      <p style="font-size:0.75rem;letter-spacing:0.12em;text-transform:uppercase;color:var(--accent);font-weight:500;margin-bottom:1.5rem;">Getting started is simple</p>
      <ul class="steps-list">
        <li>
          <div class="step-num">1</div>
          <div>
            <div class="step-title">Create your account</div>
            <div class="step-desc">Takes less than 2 minutes. No credit card required.</div>
          </div>
        </li>
        <li>
          <div class="step-num">2</div>
          <div>
            <div class="step-title">Set up your workspace</div>
            <div class="step-desc">Invite your team and configure your first project.</div>
          </div>
        </li>
        <li>
          <div class="step-num">3</div>
          <div>
            <div class="step-title">Start building</div>
            <div class="step-desc">Track tasks, manage pipelines, and hit your goals.</div>
          </div>
        </li>
      </ul>
    </div>

    <div class="panel-footer">
      Trusted by <strong>12,000+</strong> professionals at leading companies worldwide.
    </div>
  </div>

  <!-- RIGHT -->
  <div class="right-panel">
    <div class="signup-card">
      <div class="signup-title">Create an account</div>
      <div class="signup-sub">Already have one? <a href="login.html">Sign in</a></div>

      <div class="name-row form-row">
        <div>
          <label class="form-label">First Name</label>
          <input type="text" class="form-control" placeholder="Jane" />
        </div>
        <div>
          <label class="form-label">Last Name</label>
          <input type="text" class="form-control" placeholder="Doe" />
        </div>
      </div>

      <div class="form-row">
        <label class="form-label">Work Email</label>
        <input type="email" class="form-control" placeholder="jane@company.com" />
      </div>

      <div class="form-row">
        <label class="form-label">Password</label>
        <input type="password" class="form-control" id="pwd" placeholder="Min. 8 characters" oninput="updateStrength(this.value)" />
        <div class="strength-bar">
          <div class="strength-seg" id="s1"></div>
          <div class="strength-seg" id="s2"></div>
          <div class="strength-seg" id="s3"></div>
          <div class="strength-seg" id="s4"></div>
        </div>
        <div class="password-hint" id="pwd-hint">Use letters, numbers & symbols for a strong password.</div>
      </div>

      <div class="form-row">
        <label class="form-label">Confirm Password</label>
        <input type="password" class="form-control" placeholder="Repeat password" />
      </div>

      <div class="terms-row">
        <input type="checkbox" class="form-check-input" id="terms" />
        <label for="terms" class="terms-text">
          I agree to Nexus's <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>. I understand my data will be processed accordingly.
        </label>
      </div>

      <button class="btn-signup" onclick="window.location.href='dashboard.html'">Create Account</button>

      <div class="divider"><span>or sign up with</span></div>

      <button class="btn-google">
        <svg width="16" height="16" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
        Continue with Google
      </button>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function updateStrength(val) {
      const segs = ['s1','s2','s3','s4'];
      const colors = ['#e05c5c','#e08a3c','#d4c547','#5cb85c'];
      let score = 0;
      if (val.length >= 8) score++;
      if (/[A-Z]/.test(val)) score++;
      if (/[0-9]/.test(val)) score++;
      if (/[^a-zA-Z0-9]/.test(val)) score++;
      const labels = ['','Weak','Fair','Good','Strong'];
      segs.forEach((id, i) => {
        const el = document.getElementById(id);
        el.style.background = i < score ? colors[score - 1] : 'var(--border)';
      });
      const hint = document.getElementById('pwd-hint');
      hint.textContent = score > 0 ? `Password strength: ${labels[score]}` : 'Use letters, numbers & symbols for a strong password.';
      hint.style.color = score > 0 ? colors[score - 1] : 'var(--muted)';
    }
  </script>
</body>
</html>