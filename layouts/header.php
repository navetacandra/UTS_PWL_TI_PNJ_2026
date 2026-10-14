<?php
gen_csrf_token();
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Inter+Tight:wght@500;600;700&amp;family=JetBrains+Mono:wght@400;500&amp;display=swap"
    />
    <title>Dashboard</title>
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
  <body data-active="dashboard" data-crumbs="Workspace | Dashboard">
    <div class="shell">
      <aside class="d-sidebar">
        <div class="brand">
          <div class="brand-logo">
            <svg viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
              <path
                fill="#ffffff"
                d="M14.747 9.125c.527-1.426 1.736-2.573 3.317-2.573c1.643 0 2.792 1.085 3.318 2.573l6.077 16.867c.186.496.248.931.248 1.147c0 1.209-.992 2.046-2.139 2.046c-1.303 0-1.954-.682-2.264-1.611l-.931-2.915h-8.62l-.93 2.884c-.31.961-.961 1.642-2.232 1.642c-1.24 0-2.294-.93-2.294-2.17c0-.496.155-.868.217-1.023l6.233-16.867zm.34 11.256h5.891l-2.883-8.992h-.062l-2.946 8.992z"
              ></path>
            </svg>
          </div>
          <div class="brand-text">
            <div class="brand-name">UTS</div>
            <div class="brand-tag">v0.0.1</div>
          </div>
        </div>

        <nav class="nav-section">
          <div class="nav-label">Workspace</div>

          <a class="nav-link" href="<?= BASE_URL ?>/dashboard">
            <svg viewBox="0 0 24 24">
              <path d="M3 12 12 3l9 9"></path>
              <path d="M5 10v10h14V10"></path>
            </svg>
            <span>Dashboard</span>
          </a>
          <a class="nav-link" href="<?= BASE_URL ?>/account_type">
              <svg viewBox="0 0 24 24">
                <path
                  d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"
                ></path>
                <path d="M14 2v6h6M8 13h8M8 17h8M8 9h2"></path>
              </svg>
            <span>Account Types</span>
          </a>
          <a class="nav-link" href="<?= BASE_URL ?>/accounts">
              <svg viewBox="0 0 24 24">
                <circle cx="12" cy="8" r="4"></circle>
                <path d="M4 21c0-4.4 3.6-8 8-8s8 3.6 8 8"></path>
              </svg>
            <span>Accounts</span>
          </a>
          <a class="nav-link" href="<?= BASE_URL ?>/actions">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-wrench" viewBox="0 0 16 16">
                <path d="M.102 2.223A3.004 3.004 0 0 0 3.78 5.897l6.341 6.252A3.003 3.003 0 0 0 13 16a3 3 0 1 0-.851-5.878L5.897 3.781A3.004 3.004 0 0 0 2.223.1l2.141 2.142L4 4l-1.757.364zm13.37 9.019.528.026.287.445.445.287.026.529L15 13l-.242.471-.026.529-.445.287-.287.445-.529.026L13 15l-.471-.242-.529-.026-.287-.445-.445-.287-.026-.529L11 13l.242-.471.026-.529.445-.287.287-.445.529-.026L13 11z"/>
              </svg>
            <span>Actions</span>
          </a>
        </nav>

        <div class="sidebar-footer">
          <div class="workspace">
            <div class="workspace-avatar">JD</div>
            <div class="workspace-text">
              <div class="workspace-name"><?= $_SESSION["user"]["name"]; ?></div>
              <div class="workspace-role"><?= $_SESSION["user"]["account_type_name"]; ?></div>
            </div>
            <svg
              class="workspace-chev"
              width="14"
              height="14"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="1.8"
            >
              <path d="m7 9 5-5 5 5"></path>
              <path d="m7 15 5 5 5-5"></path>
            </svg>
          </div>
        </div>
      </aside>

      <div class="main">
        <header class="d-topbar">
          <div class="crumbs">
            <button
              class="hamburger"
              data-drawer-open=""
              aria-label="Open navigation"
            >
              <svg
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
              >
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
              </svg>
            </button>
          </div>
          <div class="topbar-actions">

            <button class="icon-btn" id="themeToggle" aria-label="Toggle theme">
              <svg
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
              >
                <circle cx="12" cy="12" r="4"></circle>
                <path
                  d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"
                ></path>
              </svg>
            </button>

            <div class="dd-wrap">
              <div
                class="avatar"
                data-dropdown=""
                tabindex="0"
                role="button"
                aria-label="Account menu"
              >
                JD
              </div>
              <div class="dd-menu dd-profile" role="menu">
                <div class="dd-profile-head">
                    <div class="dd-profile-name"><?= $_SESSION["user"]["name"]; ?></div>
                  <div class="dd-profile-email"><?= $_SESSION["user"]["email"]; ?></div>
                </div>
                <a class="dd-menu-item" href="#">
                  <svg viewBox="0 0 24 24">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                  </svg>
                  Profile
                </a>
                <div class="dd-divider"></div>
                <form method="POST" action="<?= BASE_URL . "/api/auth/logout" ?>" style="width: 100%">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION["csrf_token"]; ?>">
                    <button class="dd-menu-item danger" type="submit" style="width: 100%">
                      <svg viewBox="0 0 24 24">
                        <path
                          d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"
                        ></path>
                      </svg>
                      Logout
                    </button>
                </form>
              </div>
            </div>
          </div>
        </header>
