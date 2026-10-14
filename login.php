<?php

gen_csrf_token();
if(!unauthenticated(BASE_URL . "/dashboard")) {
    die();
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Inter+Tight:wght@500;600;700&amp;family=JetBrains+Mono:wght@400;500&amp;display=swap"
    />
    <title>Sig In</title>
    <script>
      !(function () {
        try {
          var t = localStorage.getItem("dash26-theme"),
            e = window.matchMedia("(prefers-color-scheme: dark)").matches;
          document.documentElement.setAttribute(
            "data-theme",
            t || (e ? "dark" : "light"),
          );
        } catch (t) {
          document.documentElement.setAttribute("data-theme", "light");
        }
      })();
    </script>
    <script defer="defer" src="<?= BASE_URL ?>/assets/runtime.096d507f.js"></script>
    <script defer="defer" src="<?= BASE_URL ?>/assets/2026.5a84696f.js"></script>
    <link href="<?= BASE_URL ?>/assets/style.76ee5eee.css" rel="stylesheet" />
  </head>
  <body>
    <div class="auth-shell">
      <main class="auth-main">
        <div class="auth-card">
          <h2>Welcome back</h2>
          <p class="sub">
            Sign in to your workspace to pick up where you left off.
          </p>
          <div id="login_alert" class="sub"></div>
          <form
            class="auth-form"
          >
            <input type="hidden" name="csrf_token" id="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
            <div class="field">
              <label class="field-label" for="email">Email</label>
              <div class="input-icon">
                <span class="ico"
                  ><svg viewBox="0 0 24 24">
                    <rect x="3" y="5" width="18" height="14" rx="2" />
                    <path d="m3 7 9 6 9-6" /></svg></span
                ><input
                  id="email"
                  name="email"
                  class="input"
                  type="email"
                  placeholder="you@company.com"
                  autocomplete="email"
                  required
                />
              </div>
            </div>
            <div class="field">
              <label class="field-label" for="password">Password</label>
              <div class="input-icon">
                <span class="ico"
                  ><svg viewBox="0 0 24 24">
                    <rect x="3" y="11" width="18" height="11" rx="2" />
                    <path d="M7 11V7a5 5 0 0 1 10 0v4" /></svg></span
                ><input
                  id="password"
                  name="password"
                  class="input"
                  type="password"
                  placeholder="••••••••"
                  autocomplete="current-password"
                  required
                />
              </div>
            </div>
            <button class="btn btn--primary auth-submit" type="submit">
              Sign in
              <svg viewBox="0 0 24 24"><path d="M5 12h14M13 5l7 7-7 7" /></svg>
            </button>
          </form>
        </div>
        <div class="auth-main-bottom">
          By signing in you agree to our <a href="#">Terms</a> and
          <a href="#">Privacy Policy</a>.
        </div>
      </main>
    </div>

    <script>
    const form = document.forms[0];
    form.onsubmit = async function(e) {
      e.preventDefault();
      const formData = new FormData(form);

      const res = await fetch(`<?= BASE_URL . "/api/auth/login"; ?>`, {
        method: "POST",
        body: formData,
      });
      const json = await res.json();

      if(!res.ok) {
        document.querySelector('#login_alert').innerHTML = `<div class="alert danger"><span class="ico"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><path d="M15 9l-6 6M9 9l6 6"></path></svg></span><div class="body"><div class="title">Login failed</div>${json.message}</div><button class="close" aria-label="Dismiss"><svg viewBox="0 0 24 24"><path d="M18 6 6 18M6 6l12 12"></path></svg></button></div>`;
        return
      }
      window.location.href = `<?= BASE_URL . "/dashboard"; ?>`;
    }
    </script>
  </body>
</html>
